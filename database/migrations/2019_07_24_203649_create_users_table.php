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
            $table->increments('id');
            $table->string('email',190)->unique();
            $table->string('password',500);
            $table->string('tipo_usuario',300)->nullable();
            $table->string('rol',300)->nullable();
            $table->string('nombre',300)->nullable();
            $table->string('direccion')->nullable();
            $table->string('cuidad')->nullable();
            $table->string('telefono')->nullable();
            $table->string('dni')->nullable();
            $table->string('estatus')->nullable();
            $table->rememberToken();
            $table->string('token',60)->unique()->nullable();
            $table->string('img_perfil')->nullable();
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
