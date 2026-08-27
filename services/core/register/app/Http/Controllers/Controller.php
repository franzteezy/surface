<?php

namespace App\Http\Controllers;

use App\Models\RegistrationToken;
use App\Models\User;
use App\Providers\CDN;
use App\Providers\Mailer;
use App\Providers\Tenant;
use Carbon\Carbon;
use COM;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    public static function put(Request $request)
    {

        $credentials = Validator::make($request->toArray(), [
            'email' => ['required', 'email'],
            'invited_by' => [],
        ])->validate();

        $user = User::query()->where('email', $credentials['email'])->exists();

        if ($user) {
            return response([
                'success' => false,
                'error' => [
                    'message' => 'User already exists'
                ]
            ]);
        }

        $token = RegistrationToken::query()->where('email', $credentials['email'])->first();

        if ($token) { //expire current token
            $token->expires_at = Carbon::now();
            $token->save();
        }

        $uuid = Str::uuid();

        $token = new RegistrationToken([
            'uuid' => $uuid,
            'email' => $credentials['email'],
            'expires_at' => Carbon::now()->addDay(), // 24 hour expire on tokens
            'invited_by' => $credentials['invited_by'] ?? null
        ]);

        $token->save();

        $origin = $request->header('Origin');
        $protocol = 'https://';
        $tenant = '';

        if ($origin) {
            $split = explode('://', $origin);
            $protocol = $split[0] . '://';
            $tenant = explode('.', $split[1])[0];
        }

        $mail_content = view('mails.register', [
            'token' => $token,
            'url' =>  env('APP_URL'),
            'tenant' =>  $tenant,
            'protocol' => $protocol
        ])->render();

        Mailer::addMail($mail_content, "you've been invited to join Stafflify 🎉", $credentials['email']);

        return response([
            'success' => true,
        ]);
    }

    public static function get($attr = null)
    {
        $registration = RegistrationToken::query()->where('uuid', $attr)->where('expires_at', '>=', Carbon::now())->first();

        if (!$registration) {
            return response([
                'success' => false,
                'error' => [
                    'message' => 'Invitation has expired, please ask your administrator to re-invite you'
                ]
            ]);
        }

        if ($registration->accepted_at) {
            return response([
                'success' => false,
                'error' => [
                    'message' => 'This invitaion has already been accepted.'
                ]
            ]);
        }

        if (User::where('email', $registration->email)->exists()) {
            return response([
                'success' => false,
                'error' => [
                    'message' => 'A user with this email already exists.'
                ]
            ]);
        }

        $registration->encryption_key = CDN::getEncryptKey(Tenant::getTenant());

        return response([
            'success' => true,
            'single' => $registration
        ]);
    }

    //delete single
    public static function delete($attr = null)
    {
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
