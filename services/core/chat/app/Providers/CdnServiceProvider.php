<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class CdnClass
{

    public static function saveFile($uuid, $file)
    {
        $parts = explode('.', $file['name']);
        $model = new FileModel([
            'uuid' => $uuid,
            'original_name' => $file['name'],
            'extension' => $parts[count($parts) - 1],
        ]);

        if ($model->save()) {
            return $model;
        }

        return false;
    }

    public static function getFile($uuid)
    {
        return FileModel::where('uuid', $uuid)->first();
    }

    public static function getTenantBucketId($tenant = null)
    {
        $tenant = $tenant ?? Tenant::getTenant();
        return md5($tenant);
    }

    public static function getEncryptKey($tenant)
    {
        $now = Carbon::now();
        $now->addHours(4);
        $hash = "8bc88cf3d8f32ab24d46b0fe24671ff7";
        $iv = "4d46b0fe24671ff7";
        return openssl_encrypt($now->format('Y-m-d\TH:i'), "AES-256-CBC", md5($tenant . $hash), 0, $iv);
    }
    public function decryptKey($key, $tenant)
    {
        $hash = "8bc88cf3d8f32ab24d46b0fe24671ff7";
        $iv = "4d46b0fe24671ff7";
        return openssl_decrypt($key, "AES-256-CBC", md5($tenant . $hash), 0, $iv);
    }
}

class CdnServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('CDN', function () {
            return new CdnClass;
        });
    }
}



use Illuminate\Support\Facades\Facade;

class CDN extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'CDN';
    }
}



use Illuminate\Database\Eloquent\Model;

class FileModel extends Model
{
    public $table = 'files';
    protected $fillable = [
        'uuid',
        'original_name',
        'extension',
    ];
}
