<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPedido extends Model
{
    protected $table = 'detalle_pedido';
    protected $primaryKey = 'id';
    protected $fillable = ['pedido_id','producto_id','cantidad','costo'];
    protected $hidden = ['created_at','updated_at'];
    
    

}
