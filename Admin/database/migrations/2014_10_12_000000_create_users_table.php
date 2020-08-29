<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('email')->unique();
            $table->integer('email_verified')->default(0);
            $table->string('password');
            $table->string('image')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->integer('phone_verified')->default(0);
            $table->string('mobile_network')->nullable();
            $table->date('dob')->nullable();
            $table->integer('education')->nullable();
            $table->integer('occupation')->nullable();
            $table->string('marital_status')->nullable();
            $table->integer('children')->nullable();
            $table->integer('children_group')->nullable();
            $table->integer('children_household')->nullable();
            $table->string('house_hold')->nullable();
            $table->integer('role_purchasing')->nullable();
            $table->integer('status')->nullable();
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
