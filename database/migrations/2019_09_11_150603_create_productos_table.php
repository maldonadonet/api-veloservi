<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre',200);
            $table->string('descripcion',200)->nullable();
            $table->string('categoria',200);
            $table->decimal('precio',8,2);
            $table->integer('stock')->nullable();
            $table->integer('usuario_id');
            $table->decimal('descuento',8,2)->nullable();
            $table->integer('puntos')->nullable();
            $table->string('status',200)->nullable();
            $table->string('foto',200)->nullable();
            $table->timestamps();

            $table->foreign('usuario_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
