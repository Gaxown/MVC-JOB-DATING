<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

Capsule::schema()->create('announcements', function (Blueprint $table) {
    $table->increments('id');
    $table->unsignedInteger('company_id');
    $table->string('title');
    $table->text('description');
    $table->integer('candidates_count')->default(0);
    $table->string('cover')->nullable();
    $table->timestamps();
    $table->softDeletes();
    $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
});