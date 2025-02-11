<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

Capsule::schema()->create('permissions', function (Blueprint $table) {
    $table->increments('id');
    $table->string('name', 50);
    $table->timestamps();
});