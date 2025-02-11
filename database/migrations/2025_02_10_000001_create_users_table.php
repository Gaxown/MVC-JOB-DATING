<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

Capsule::schema()->create('users', function (Blueprint $table) {
    $table->increments('id');
    $table->string('username');
    $table->string('email')->unique();
    $table->string('password');
    $table->string('role')->default('user');
    $table->timestamps();
});