<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','email','password','tipo_usuario','rol','nombre','direccion','cuidad','telefono','dni','estatus','img_perfil','token'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token','created_at','updated_at'
    ];

    public function productos() {
        return $this->hasMany(Producto::class,'usuario_id');
    }

    public function pedidosEspeciales() {
        return $this->hasMany(PedidoEsp::class,'usuario_id');
    }

    public function pedidos() {
        return $this->hasMany(Pedido::class,'usuario_id');
    }
}
