<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    // funcion para registrar nuevos usuarios
    public function register(Request $request) {

        if($request->isJson()) {

            $data = $request->json()->all();
            
            $validacion = User::where('email',$data['email'])->count();

            if($validacion > 0 ) {
                return response()->json(['error'=>true,'message'=>'Este correo electronico ya fue registrado anterior mente.'],201);
            }

            $client = User::create([
                'nombre' => $data['nombre'],
                'email' => $data['email'],
                'password' => $data['password'],
                'tipo_usuario' => 'cliente',
                'estatus' => 'inactivo'
            ]);

            return response()->json([
                'error'=> false,
                'respuesta' => 'Cliente creado correctamente',
                'code' => 201
            ]);
        }

        return response()->json(['error'=>'No autorizado'],201);
    }

    // funcion para iniciar sesión
    public function login(Request $request) {

        $token = '';

        if ($request->isJson() ) {
            $data = $request->json()->all();

            $user = User::where('email',$data['email'])->where('password',$data['password'])->first();

            if( $user ) {

                $client = User::findOrFail($user->id);
                $client->token = str_random(50);
                $token = $client->token;
                $client->update();

                return response()->json([
                    'error'=>false,
                    'message' => 'Bienvenido al sistema',
                    'usuario' => $user,
                    'token' => $token
                ],201);
            }else {
                return response()->json([
                    'error'=>true,
                    'message' => 'Los datos proporcionados no coinciden con nuestra base de datos.'
                ],201);
            }

        }
        return response()->json([
            'error'=>true,
            'message' => 'No autorizado'
        ],401);
    }

    // funcion para obtener los datos del usuario
    public function perfil(Request $request,$id,$token) {

        if ($request->isJson() ) {
            

            $user = User::where('id',$id)->where('token',$token)->first();

            if ( $user ) {
                return response()->json([
                    'error'=>false,
                    'message' => 'Consulta exitosa',
                    'data' => $user
                ],201);
            } else {
                return response()->json([
                    'error'=>true,
                    'message' => 'Parece que algunos datos no coinciden, favor de verificarlos.'
                ],400);
            }

        }

        return response()->json([
            'error'=>true,
            'message' => 'No autorizado'
        ],401);
    }

    // funcion para actualizar los datos del perfil del usuario
    // Enviar todos los campos aunque vengan en null
    public function actualizar_perfil(Request $request,$id,$token) {

        if ($request->isJson() ) {

            $data = $request->json()->all();

            $user = User::where('id',$id)->where('token',$token)->first();

            if ( $user ) {

                $client = User::findOrFail($id);
                $client->nombre = ($data['nombre']) == null ? $client->nombre : $data['nombre'];
                $client->direccion = $data['direccion'] == null ? $client->direccion : $data['direccion'];
                $client->cuidad = $data['cuidad'] == null ? $client->cuidad : $data['cuidad'];
                $client->telefono = $data['telefono'] == null ? $client->telefono : $data['telefono'];
                $client->dni = $data['dni'] == null ? $client->dni : $data['dni'];
                $client->img_perfil = $data['img_perfil'] == null ? $client->img_perfil : $data['img_perfil'];
                $client->update();

                return response()->json([
                    'error'=>false,
                    'message' => 'Datos actualizados correctamente',
                    'data' => $client
                ],201);

            } else {
                return response()->json([
                    'error'=>true,
                    'message' => 'Consulta Erronea.'
                ],400);
            }

        }

        return response()->json([
            'error'=>true,
            'message' => 'No autorizado'
        ],401);

    }

}
