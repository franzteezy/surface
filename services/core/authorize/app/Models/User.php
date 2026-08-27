<?php

namespace App\Models;

use App\Providers\CDN;
use App\Providers\Tenant;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    protected $connection = 'mysql';
    use Authenticatable, Authorizable, HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'image_uuid',
        'email',
        'password',
        'token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    public function getImageAttribute()
    {
        if (!$this->image_uuid) {
            return null;
        }
        $bucket = CDN::getTenantBucketId();
        return 'cdn.' . env('APP_URL') . '/bucket/' . $bucket . '/' . $this->image_uuid;
    }
}

class TenantUser extends Model
{
    protected $connection = 'tenants';
    public $timestamps = false;
    public $table = 'tenant_users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tenant',
        'email',
    ];
}
