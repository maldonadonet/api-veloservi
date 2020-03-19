<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PedidoEsp extends Model
{
    protected $table = 'pedido_especial';
    protected $primaryKey = 'id';
    protected $fillable = ['nombre_sucursal','direccion_sucursal','productos','total','estatus','usuario_id','dir_cliente','dir_alterna'];
    protected $hidden = ['created_at','updated_at'];

}
