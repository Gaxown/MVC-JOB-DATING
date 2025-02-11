<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

Capsule::schema()->create('role_permissions', function (Blueprint $table) {
    $table->increments('id');
    $table->unsignedInteger('role_id');
    $table->unsignedInteger('permission_id');
    $table->timestamps();

    $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
    $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
});