<?php

namespace App\Http\Controllers;
use App\User;
use App\Pedido;
use App\DetailPedido;
use App\PedidoEsp;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;

class PedidosController extends Controller
{

    // Crear un nuevo pedido
    public function create(Request $request,$id,$token) {

        if ( $request->isJson() ) {

            $user = User::where('id',$id)->where('token',$token)->first();

            if($user) {

                $data = $request->json()->all();

                $cantidades = explode(",", $data['cantidades']);
                $productos = explode(",", $data['ids']);
                $proveedores = explode(",", $data['asociados']);
                $costos = explode(",", $data['costos']);

                $cant = count($cantidades);
                $repartidor = rand(1,3);

                $pedido = Pedido::create([
                    'usuario_id' => $user->id,
                    'direccion_entrega' =>'S/N', # $data['direccion_entrega']
                    'fecha_pedido' => date('Y/m/d'),
                    'monto' => $data['total'],
                    'estatus' => 'pendiente de revision',
                    'id_repartidor' => $repartidor
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

        $user = User::where('id',$id)->where('token',$token)->first();

        if($user) {

            $data = $request->json()->all();

            $pedidos = Pedido::where('usuario_id',$id)->orderBy('created_at','desc')->get();

            $pedidos2 = DB::table('pedidos as p')
            ->join('users as u','p.usuario_id','=','u.id')
            ->select('p.id','u.nombre','p.direccion_entrega','p.fecha_pedido','p.monto','p.estatus')
            ->where('p.usuario_id',$id)
            ->orderBy('p.created_at','desc')
            ->get();

            $ordenes = array();

            foreach ($pedidos2 as $key => $value) {

                $query_detalle = DB::table('detalle_pedido as dp')
                ->join('productos as p','dp.producto_id','=','p.id')
                ->select('dp.id','dp.pedido_id as pedido','p.nombre','dp.cantidad','dp.costo')
                ->where('dp.pedido_id',$value->id)->get();

                $orden = array(
                    'id_pedido' => $value->id,
                    'nombre' => $value->nombre,
                    'direccion_entrega' => $value->direccion_entrega,
                    'fecha_pedido' => $value->fecha_pedido,
                    'monto' => $value->monto,
                    'estatus' => $value->estatus,
                    'detalle' => $query_detalle
                );

                array_push($ordenes, $orden);

            }

            return response()->json([
                'error'=> false,
                'code' => 201,
                'pedidos' => $ordenes
            ]);

        }else{
            return response()->json(['error'=>'Datos de usuario no validos, favor de iniciar sesion de nuevo'],401);
        }


    }

    // Obtener el historial de pedidos de un usuario
    public function historialEspeciles(Request $request,$id,$token) {

        $user = User::where('id',$id)->where('token',$token)->first();

        if($user) {

            $data = $request->json()->all();

            $pedidos = PedidoEsp::where('usuario_id',$id)->orderBy('created_at','desc')->get();

            return response()->json([
                'error'=> false,
                'code' => 201,
                'pedidos' => $pedidos
            ]);

        }else{
            return response()->json(['error'=>'Datos de usuario no validos, favor de iniciar sesion de nuevo'],401);
        }


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
                    'dir_entrega' => $data['dir_entrega'],
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

    // Envía los detalles de cada pedido
    public function historial_repartidor(Request $request,$id,$token) {

        $user = User::where('id',$id)->where('token',$token)->first();

        if($user) {

            $data = $request->json()->all();

            $pedidos = Pedido::where('id_repartidor',$id)->orderBy('created_at','desc')->get();

            $pedidos2 = DB::table('pedidos as p')
            ->join('users as u','p.usuario_id','=','u.id')
            ->select('p.id','u.nombre','p.direccion_entrega','p.fecha_pedido','p.monto','p.estatus')
            ->where('p.id_repartidor',$id)
            ->orderBy('p.created_at','desc')
            ->get();

            $ordenes = array();

            foreach ($pedidos2 as $key => $value) {

                $query_detalle = DB::table('detalle_pedido as dp')
                ->join('productos as p','dp.producto_id','=','p.id')
                ->select('dp.id','dp.pedido_id as pedido','p.nombre','dp.cantidad','dp.costo')
                ->where('dp.pedido_id',$value->id)->get();

                $orden = array(
                    'id_pedido' => $value->id,
                    'nombre' => $value->nombre,
                    'direccion_entrega' => $value->direccion_entrega,
                    'fecha_pedido' => $value->fecha_pedido,
                    'monto' => $value->monto,
                    'estatus' => $value->estatus,
                    'detalle' => $query_detalle
                );

                array_push($ordenes, $orden);

            }

            return response()->json([
                'error'=> false,
                'code' => 201,
                'pedidos' => $ordenes
            ]);

        }else{
            return response()->json(['error'=>'Datos de usuario no validos, favor de iniciar sesion de nuevo'],401);
        }
    }

    public function historial_especiales_repartidor(Request $request,$id,$token) {

        $user = User::where('id',$id)->where('token',$token)->first();

        if($user) {

            $data = $request->json()->all();

            $pedidos = PedidoEsp::where('repartidor_id',$id)->orderBy('created_at','desc')->get();

            return response()->json([
                'error'=> false,
                'code' => 201,
                'pedidos' => $pedidos
            ]);

        }else{
            return response()->json(['error'=>'Datos de usuario no validos, favor de iniciar sesion de nuevo'],401);
        }

    }
}
