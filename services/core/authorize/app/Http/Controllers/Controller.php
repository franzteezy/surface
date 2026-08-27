<?php

namespace App\Http\Controllers;

use App\Models\RegistrationToken;
use App\Models\TenantUser;
use App\Models\User;
use App\Providers\CDN;
use App\Providers\Mail;
use App\Providers\Mailer;
use App\Providers\Tenant;
use Carbon\Carbon;
use Exception;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class Controller extends BaseController
{
    //get single
    public static function get($attr = null)
    {
        $user = $attr ? User::query()->where('id', $attr)->first() : auth()->user();

        $user->append('image');

        if (!$user && $attr) {
            $exception =  new Exception('Unauthenticated.', 401);
            abort($exception->getCode(), $exception->getMessage());
        }

        return response([
            'success' => true,
            'single' => $user
        ]);
    }

    //get many
    public static function fetch(Request $request)
    {

        $validator = Validator::make($request->toArray(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return response([
                'success' => false,
                'error' => [
                    'message' => 'Please provide an E-mail and a Password'
                ]
            ], 400);
        }

        $credentials = $validator->validated();

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            $token = md5(uniqid());
            User::where('id', Auth::id())->update([ 'token' => $token ]);
            return response([
                'success' => true,
                'single' => auth()->user()
            ]);
        } else {
            return response([
                'success' => false,
                'error' => [
                    'message' => 'Wrong email or password'
                ]
            ], 401);
        }
    }

    //create/save single
    public static function put(Request $request)
    {

        $credentials = Validator::make($request->toArray(), [
            'id'                    => [],
            'email'                 => ['required', 'email'],
            'first_name'            => ['required'],
            'last_name'             => ['required'],
            'registration_token'    => [],
            'email_verified_at'     => [],
            'password'              => ['required'],
            'password_repeat'       => ['required', 'same:password'],
            'image'                 => [],
            'image_uuid'            => [],
            'cc'                    => [],
            'phone'                 => [],
        ])->validate();

        if (!$credentials['id']) {
            return self::register($credentials, $request);
        }

        return response([
            'success' => true,
            'test' => $credentials
        ]);
    }

    //delete single
    public static function delete($attr = null)
    {
    }


    /***********FUNCTIONS***********/
    public static function resetPassword(Request $request)
    {
        $validation = Validator::make($request->toArray(), [
            'new_password' => ['required', 'confirmed'],
            'new_password_confirmation' => ['required'],
            'token' => ['required'],
        ]);

        if ($validation->fails()) {
            foreach ($validation->failed() as $field => $reasons) {
                $keys = array_keys($reasons);
                $note = str_replace('_', ' ', ucfirst($field));

                if (in_array('Required', $keys)) {
                    $note = $note . ' is required';
                } else if (in_array('Confirmed', $keys)) {
                    $note = $note . 's needs to match';
                }

                return response([
                    'success' => false,
                    'error' => [
                        'message' => $note
                    ]
                ], 400);
            }
        }
        $validated = $validation->validated();
        $token = DB::table('password_resets')->where('token', $validated['token'])->whereNull('used_at')->first();

        if (!$token) {
            return response([
                'success' => false,
                'error' => [
                    'message' => "The password-reset token is invalid, please request a new token"
                ]
            ], 401);
        }

        $user = User::query()->where('email', $token->email)->first();
        $user->password =  Hash::make($validated['new_password']);
        $user_ip = $request->ip();

        if (!($user_ip === $token->created_by_ip)) {
            return response([
                'success' => false,
                'error' => [
                    'message' => 'Your IP does not match the IP that requested the reset, are you using a VPN? Request your password reset from the same computer you use to make the new password.'
                ]
            ], 401);
        }

        DB::table('password_resets')->where('token', $validated['token'])
            ->whereNull('used_at')->update(['used_at' => Carbon::now()]);
        $user->save();

        return response([
            'success' => true,
        ]);
    }

    public static function forgotPassword(Request $request)
    {
        $credentials = Validator::make($request->toArray(), [
            'email' => ['required', 'email'],
        ])->validate();

        $user = User::query()->where('email', $credentials['email'])->first();

        if ($user) {
            $exists = true;

            //create unique token
            while ($exists) {
                $token = Str::random(12);
                $exists = DB::table('password_resets')->where('token', $token)->exists();
            }

            //delete existing
            DB::table('password_resets')->where('email', $credentials['email'])->whereNull('used_at')->delete();

            DB::table('password_resets')->insert([
                'email' => $credentials['email'],
                'token' => $token,
                'created_at' => Carbon::now(),
                'created_by_ip' => $request->ip(),
            ]);

            $tenant = Tenant::getTenant();
            $origin = $request->header('Origin');
            $protocol = 'https://';

            if ($origin) {
                $split = explode('://', $origin);
                $protocol = $split[0] . '://';
            }

            $mail_content = view('mails.forgot-password', [
                'token' => $token,
                'url' =>  env('APP_URL'),
                'tenant' =>  $tenant,
                'protocol' => $protocol
            ])->render();

            Mailer::addMail($mail_content, "Reset your password 🔑", $credentials['email']);
        }

        return response([
            'success' => true,
        ]);
    }

    public static function register($credentials, $request)
    {
        if (!isset($credentials['registration_token'])) {
            return response([
                'success' => false,
                'error' => [
                    'message' => 'Registration token not provided'
                ]
            ], 401);
        }

        $registration = RegistrationToken::query()->where('uuid', $credentials['registration_token'])->first();
        $registration->accepted_at = Carbon::now();
        $registration->save();
        if ($registration->email !== $credentials['email']) {
            return response([
                'success' => false,
                'error' => [
                    'message' => 'Registration token is invalid'
                ]
            ], 401);
        }

        $credentials['password'] = Hash::make($credentials['password']); // hash password

        //if image is uploaded, save that to user
        if ($credentials['image_uuid']) {
            CDN::saveFile($credentials['image_uuid'], $credentials['image']);
        }

        //Create user
        $user = new User($credentials);
        $user->save();

        $origin = $request->header('Origin');

        if ($origin) {
            $split = explode('://', $origin);
            $tenant = explode('.', $split[1])[0];

            (new TenantUser([
                'email' => $credentials['email'],
                'tenant' => $tenant
            ]))->save();
        }

        return response([
            'success' => true,
            'single' => $user
        ]);
    }

    /***********HELPSERS***********/
    public static function getSql($builder)
    {
        $sql = $builder->toSql();
        foreach ($builder->getBindings() as $binding) {
            $value = is_numeric($binding) ? $binding : "'" . $binding . "'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }
        return $sql;
    }

    public static function isUpdating($updates, $key): bool
    {
        if (!$updates) return true;
        if (in_array($key, $updates)) return true;
        if (array_key_exists($key, $updates)) return true;
        return false;
    }
}
