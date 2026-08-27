<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class  Mailer extends Model
{
    protected $table = 'mail_queue';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'created_by',
        'uuid',
        'email_to',
        'email_from',
        'subject',
        // 'uploadedFiles',
        // 'uploadedImages',
        'content',
        'sent_at',
        'opened_at',
        'delivered_at',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'sent_at' => 'datetime',
        'opened_at' => 'datetime',
        'delivered_at' => 'datetime',
        'created_at' => 'datetime',
        'update_at' => 'datetime',
        // 'uploadedFiles' => 'array',
        // 'uploadedImages' => 'array'
    ];
}
