<?php

namespace App\Http\Controllers;
use App\User;
use App\Pedido;
use App\DetailPedido;
use App\PedidoEsp;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PedidosController extends Controller
{

    // Crear un nuevo pedido
    public function create(Request $request,$id,$token) {
        $productos = "";
        if ( $request->isJson() ) {
            $user = User::where('id',$id)->where('token',$token)->first();

            if($user) {
                $data = $request->json()->all();
                $productos = explode(',',$data['productos']);
                $cantidades = explode(',',$data['cantidades']);
                $costos = explode(',',$data['costos']);
                $cant = count($productos);

                $pedido = Pedido::create([
                    'usuario_id' => $user->id,
                    'direccion_entrega' => $data['direccion_entrega'],
                    'fecha_pedido' => date('Y/m/d'),
                    'monto' => $data['monto'],
                    'estatus' => 'pendiente de revision',
                    'tipo_pedido' => $data['asociado_id']
                ]);

                for ($i=0; $i < $cant; $i++) {
                    $detalle = DetailPedido::create([
                        'pedido_id' => $pedido->id,
                        'producto_id' => $productos[$i],
                        'cantidad' => $cantidades[$i],
                        'costo' => $costos[$i]
                    ]);
                }


                return response()->json([
                    'error'=> false,
                    'code' => 201,
                    'pedido' => $pedido
                ]);

            }else{
                return response()->json(['error'=>'Datos de usuario no validos, favor de iniciar sesion de nuevo'],401);
            }

        }

        return response()->json(['error'=>'No autorizado'],401);

    }

    // Obtener el historial de pedidos de un usuario
    public function historial(Request $request,$id,$token) {
        if ( $request->isJson() ) {
            $user = User::where('id',$id)->where('token',$token)->first();

            if($user) {
                $data = $request->json()->all();

                $pedidos = Pedido::where('usuario_id',$id)->get();

                return response()->json([
                    'error'=> false,
                    'code' => 201,
                    'pedido_especial' => $pedidos
                ]);

            }else{
                return response()->json(['error'=>'Datos de usuario no validos, favor de iniciar sesion de nuevo'],401);
            }

        }

        return response()->json(['error'=>'No autorizado'],401);
    }

    // Crea un nuevo pedido especial
    public function create_especial(Request $request,$id,$token) {
         
        if ( $request->isJson() ) {
            $user = User::where('id',$id)->where('token',$token)->first();

            if($user) {
                $data = $request->json()->all();

                $pedidoesp = PedidoEsp::create([
                    'nombre_sucursal' => $data['nombre_sucursal'],
                    'direccion_sucursal' => $data['direccion_sucursal'],
                    'productos' => $data['productos'],
                    'total' => 0,
                    'estatus' => 'pendiente de revision',
                    'dir_cliente' => $data['dir_cliente'],
                    'dir_alterna' => $data['dir_alterna'],
                    'usuario_id' => $id
                ]);

                return response()->json([
                    'error'=> false,
                    'code' => 201,
                    'pedido_especial' => $pedidoesp
                ]);

            }else{
                return response()->json(['error'=>'Datos de usuario no validos, favor de iniciar sesion de nuevo'],401);
            }

        }

        return response()->json(['error'=>'No autorizado'],401);
    }

}