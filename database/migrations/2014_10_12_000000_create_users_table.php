<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('levelId');
            $table->string('userLogin');
            $table->string('userPass')->nullable();
            $table->string('userEmail')->unique();
            $table->string('userPhone')->nullable();
            $table->string('userDisplayName')->nullable();
            $table->enum('userBlock', ['y', 'n'])->default('n');
            $table->integer('userDelete')->unsigned()->nullable();
            $table->integer('userLastLogin')->unsigned()->nullable();
            $table->string('userActivationKey')->nullable();
            $table->integer('userRegistered')->unsigned()->nullable();
            $table->string('userSession')->nullable();
            $table->longText('userCheckPoint')->nullable();
            $table->string('userDir')->nullable();
            $table->text('userPicture')->nullable();
            $table->enum('userOnlineStatus', ['online', 'offline', 'busy'])->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
