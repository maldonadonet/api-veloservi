<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidoEspecialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedido_especial', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre_sucursal');
            $table->string('direccion_sucursal');
            $table->string('productos');
            $table->decimal('total',8,2)->nullable();
            $table->string('estatus')->nullable();
            $table->integer('usuario_id');
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
        Schema::dropIfExists('pedido_especial');
    }
}
