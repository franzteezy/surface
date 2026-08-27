<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class MailerClass
{
    public function addMail($content, $subject, $email_to, $email_from = null, $uuid = null, $created_by = null, $send_at = null)
    {
        if ($uuid === null) {
            $uuid = Str::uuid();
        }
        $mail = new Mail([
            'created_by' => $created_by,
            'uuid' => $uuid,
            'email_to' => $email_to,
            'email_from' => $email_from,
            'send_at' => $send_at,
            'subject' => $subject,
            'content' => $content,
        ]);
        $mail->save();

        return $mail;
    }

    public function getMails($created_by = null, $email = null)
    {
        $query = Mail::query();

        //get attached to user
        if ($created_by !== null) {
            $query->orWhere('created_by', $created_by);
        }

        //get email to/from user
        if ($email !== null) {
            $query->orWhere('email_from', $email)->orWhere('email_to', $email);
        }

        $mails = $query->get();
        $threads = $mails->groupBy('uuid');

        return $threads;
    }

    public function getThread($uuid)
    {
        $query = Mail::query()->where('uuid', $uuid);
        $mails = $query->get();

        return $mails;
    }
}



class MailerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('mailer', function () {
            return new MailerClass;
        });
    }
}



use Illuminate\Support\Facades\Facade;

class Mailer extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'mailer';
    }
}



use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    public $table = 'mail_queue';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'created_by',
        'uuid',
        'email_to',
        'email_from',
        'subject',
        'content',
        'sent_at',
        'opened_at',
        'delivered_at',
        'created_at',
        'update_at',
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
    ];

    //minify content before saving, to save space in database
    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->content = str_replace(array("\r", "\n"), '', $model->content);
        });

        self::updating(function ($model) {
            $model->content = str_replace(array("\r", "\n"), '', $model->content);
        });
    }
}
