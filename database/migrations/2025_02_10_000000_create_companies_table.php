<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

Capsule::schema()->create('companies', function (Blueprint $table) {
    $table->increments('id');
    $table->string('name');
    $table->string('logo')->nullable();
    $table->string('cover')->nullable();
    $table->text('description')->nullable();
    $table->string('website')->nullable();
    $table->string('service')->nullable();
    $table->integer('effective')->nullable();
    $table->string('location')->nullable();
    $table->decimal('capital', 15, 2)->nullable();   
    $table->timestamps();
});