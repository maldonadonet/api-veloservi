<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Producto;
use DB;

class ProductosController extends Controller
{
    // Obtener la lista de productos
    public function list_products(Request $request,$id,$token) {
        
        $user = User::where('id',$id)->where('token',$token)->first();

        if($user) {

            // $productos = Producto::paginate(10);
            $productos = Producto::paginate(30);

            return response()->json([
                'error'=> false,
                'data' => $productos,
                'code' => 201
            ]);

        }else{
            return response()->json([
                'error'=>true,
                'message' => 'Datos errones, favor de cerrar sesión e iniciar nuevamente para actualizar los datos de conexión..'
            ],400);
        }
        
        return response()->json(['error'=>'No autorizado'],401);
    }

    // Filtrar por categoria
    public function filtrar_categoria(Request $request, $id, $token,$categoria) {

            $data = $request->json()->all();

            $user = User::where('id',$id)->where('token',$token)->first();

            if($user) {

                $productos = DB::table('productos')->where('categoria',$categoria)->paginate(30);

                return response()->json([
                    'error'=> false,
                    'data' => $productos,
                    'code' => 201
                ]);

            }else{
                return response()->json([
                    'error'=>true,
                    'message' => 'Datos errones, favor de cerrar sesión e iniciar nuevamente para actualizar los datos de conexión..'
                ],400);
            }

        return response()->json(['error'=>'No autorizado'],401);
    }

    // Filtrar productos por sucursal
     public function filtrar_sucursal(Request $request, $id, $token) {
        
        $data = $request->json()->all();

            $user = User::where('id',$id)->where('token',$token)->first();

            if($user) {

                $productos = DB::table('productos')->where('usuario_id',$data['usuario_id'])->paginate(10);

                return response()->json([
                    'error'=> false,
                    'data' => $productos,
                    'code' => 201
                ]);

            }else{
                return response()->json([
                    'error'=>true,
                    'message' => 'Datos errones, favor de cerrar sesión e iniciar nuevamente para actualizar los datos de conexión..'
                ],400);
            }

        return response()->json(['error'=>'No autorizado'],401);

    }
    // Buscar producto
    public function buscar(Request $request, $id, $token) {
        
        $data = $request->json()->all();

            $user = User::where('id',$id)->where('token',$token)->first();

            if($user) {

                $productos = DB::table('productos')->where('nombre','like','%'.$data['termino'].'%')->paginate(10);

                return response()->json([
                    'error'=> false,
                    'data' => $productos,
                    'code' => 201
                ]);

            }else{
                return response()->json([
                    'error'=>true,
                    'message' => 'Datos errones, favor de cerrar sesión e iniciar nuevamente para actualizar los datos de conexión..'
                ],400);
            }

        return response()->json(['error'=>'No autorizado'],401);
    }

}
