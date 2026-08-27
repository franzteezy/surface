<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class TenantClass
{
    public static function setTenant()
    {
        try {

            $app = $_GET['app'] ?? null;
            if ($app) {
                $tenant_url = $app;
            } else {
                $origin = explode('://', $_SERVER['HTTP_ORIGIN'])[1];
                $tenant_url = explode('.', $origin)[0];
            }
            $tenant = TenantModel::query()->where('tenant', $tenant_url)->first();
            if ($tenant) {
                self::setTenantConnection($tenant);
            }
            return $tenant;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getTenant()
    {

        $origin = $_SERVER['HTTP_ORIGIN'] ?? false;
        $tenant = '';

        if ($origin) {
            $split = explode('://', $origin);
            $tenant = explode('.', $split[1])[0];
        }
        return $tenant;
    }

    public static function setTenantConnection(TenantModel $tenant)
    {
        Config::set('database.connections.mysql.host', $tenant->ip_address);
        Config::set('database.connections.mysql.database', $tenant->database_name);
        Config::set('database.connections.mysql.password', $tenant->password);
        DB::purge('mysql');
    }
}

class TenantServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('tenant', function () {
            return new TenantClass;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Tenant::setTenant();
    }
}



use Illuminate\Support\Facades\Facade;

class Tenant extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'tenant';
    }
}



use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class TenantModel extends Model
{
    protected $connection = 'tenants';
    public $table = 'tenants';
    protected $fillable = [
        'tenant',
        'ip_address',
        'password',
        'name',
        'database_name',
    ];

    public function getPasswordAttribute($attr)
    {
        return Crypt::decryptString($attr);
    }
}
