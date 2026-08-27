<?php

namespace App\Http\Controllers;

use App\Models\Mailer;
use App\Models\MailUploads;
use App\Providers\Tenant;
use App\Providers\TenantServiceProvider;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Exception;
use Faker\Core\Uuid;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Predis\Command\Redis\ECHO_;

class Controller extends BaseController
{
    //get single
    public static function get($attr = null)
    {
        if($attr !== null){
            $mailer = Mailer::query()->where('id', $attr)->first();
        }else{
            $mailer = Mailer::query()->get();
        }

        return response([
            'success' => true,
            'single' => $mailer,
            'tenant' => Tenant::getTenant()
        ]);
    }

    //get many
    public static function fetch(Request $request)
    {
        $mailer = Mailer::query()->orderBy('id', 'DESC')->get();

        return response([
            'success' => true,
            'many' => $mailer,
            'tenant' => Tenant::getTenant()
        ]);
    }

    //create/save single
    public static function put(Request $request)
    {

        try{

            $fileUploads = Validator::make($request->toArray(), [
                'uploadedFiles' => [],
                'uploadedImages' => []
            ])->validate();

            $credentials = Validator::make($request->toArray(), [
            'id'                    => [],
            'created_by'            => [],
            'uuid'                  => [],
            'email_to'              => ['required', 'email'],
            'email_from'            => [],
            // 'uploadedFiles'         => [],
            // 'uploadedImages'        => [],
            'subject'               => ['required'],
            'content'               => ['required'],
            'send_at'               => [],
            'opened_at'             => [],
            ])->validate();
            $uuid = Str::uuid();
            $credentials['uuid'] = $uuid;
            $credentials['created_by'] = auth()->user()->id;
            $credentials['send_at'] = Carbon::now();
            $mailer = new Mailer($credentials);
            $mailer->save();
            
            foreach($fileUploads['uploadedFiles'] as $file){
                $file['mail_uuid'] = $uuid;
                $attachments = new MailUploads($file);
                $attachments->save();
            }
            foreach($fileUploads['uploadedImages'] as $img){
                $img['mail_uuid'] = $uuid;
                $attachments = new MailUploads($img);
                $attachments->save();
            }
        }catch(Exception $ex){
            Log::error($ex);
            return response([
                'success' => false,
                'single' => null
            ]);
        }
        return response([
            'success' => true,
            'single' => $mailer
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
