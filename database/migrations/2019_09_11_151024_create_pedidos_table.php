<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('usuario_id');
            $table->string('direccion_entrega')->nullable();
            $table->date('fecha_pedido');
            $table->decimal('monto',8,2);
            $table->string('estatus')->nullable();
            $table->string('lt')->nullable();
            $table->string('lng')->nullable();
            $table->string('tipo_pedido');
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
        Schema::dropIfExists('pedidos');
    }
}
