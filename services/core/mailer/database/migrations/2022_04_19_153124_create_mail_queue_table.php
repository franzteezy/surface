<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_queue', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('created_by')->nullable();
            $table->string('uuid'); //the UUID is used to detect a thread of messages
            $table->string('email_to');
            $table->string('email_from')->nullable(); //null means a mail sent by the system
            $table->string('subject');
            $table->longText('content');
            $table->dateTime('send_at')->nullable(); // delay sending of email
            $table->dateTime('opened_at')->nullable();
            $table->dateTime('delivered_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_queue');
    }
};
