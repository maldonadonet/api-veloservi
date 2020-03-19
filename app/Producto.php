<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id';
    protected $fillable = ['nombre','descripcion','categoria','precio','stock','usuario_id','descuento','puntos','status','foto'];
    protected $hidden = ['created_at','updated_at'];
    
    public function detallePedido() {
        return $this->hasMany(DetailPedido::class,'producto_id');
    }

}
