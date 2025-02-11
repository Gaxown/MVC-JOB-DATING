    <?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

Capsule::schema()->create('users', function (Blueprint $table) {
    $table->increments('id');
    $table->string('name', 50);
    $table->string('email', 50)->unique();
    $table->string('password', 100);
    $table->unsignedInteger('role_id');
    $table->timestamps();

    $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
});