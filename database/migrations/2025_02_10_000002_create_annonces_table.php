<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

Capsule::schema()->create('annonces', function (Blueprint $table) {
    $table->increments('id');
    $table->unsignedInteger('entreprise_id');
    $table->string('title');
    $table->text('description');
    $table->integer('nombre_candidature')->default(0);
    $table->string('cover')->nullable();
    $table->timestamps();
    $table->softDeletes();
    $table->foreign('entreprise_id')->references('id')->on('entreprises')->onDelete('cascade');
});