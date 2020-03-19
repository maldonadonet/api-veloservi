<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedidos';
    protected $primaryKey = 'id';
    protected $fillable = ['usuario_id','direccion_entrega','fecha_pedido','monto','estatus','lt','lng','tipo_pedido'];
    protected $hidden = ['created_at','updated_at'];
    
    public function detalles() {
        return $this->hasMany(DetailPedido::class,'pedido_id');
    }

    

}