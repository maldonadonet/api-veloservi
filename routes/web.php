<?php

// *********************************************************************************************************
// Rutas Cliente
// 1.- Register
$router->post('/register',['uses'=>'UserController@register']);

// 2.- Login
$router->post('/login',['uses'=>'UserController@login']);

// 3.- Obtener los datos del cliente
$router->get('perfil/{id}/{token}',['uses'=>'UserController@perfil']);

// 4.- Editar los datos del cliente
$router->post('actualizar_perfil/{id}/{token}',['uses'=>'UserController@actualizar_perfil']);
// *********************************************************************************************************

// *********************************************************************************************************
// Rutas: Productos
// 1.- Obtener la lista de productos
$router->get('/listado_productos/{id}/{token}',['uses'=>'ProductosController@list_products']);

// 2.- Filtrar productos por categoria
$router->get('/filtrar_cat/{id}/{token}/{categoria}',['uses'=>'ProductosController@filtrar_categoria']);

// 3.- filtrar productos por sucursal
$router->get('filtrar_suc/{id}/{token}',['uses'=>'ProductosController@filtrar_sucursal']);

// 4.- busqueda de productos
$router->get('buscar/{id}/{token}',['uses'=>'ProductosController@buscar']);
// *********************************************************************************************************

// *********************************************************************************************************
// Rutas: Pedidos
// 1.- Crear un nuevo pedido Ya quedo
$router->post('/crear_pedido/{id}/{token}',['uses'=>'PedidosController@create']);

// 2.- Ver el listado de pedidos de un usuario
$router->get('/historial_pedidos/{id}/{token}',['uses'=>'PedidosController@historial']);

// 3.- Crear un pedido especial
$router->post('/crear_pedido_especial/{id}/{token}',['uses'=>'PedidosController@create_especial']);





























// Rutas protegidas ****************************************************************************************************
// $router->group(['middleware' => ['auth']], function () use ($router){
//     // Get users
//     //$router->get('/users',['uses'=>'UserController@index']);

//     // Post create users
//     $router->post('/users',['uses'=>'UserController@createUser']);
// });
// *********************************************************************************************************************

// Rutas publicas ******************************************************************************************************

// Login
// $router->post('/users/login',['uses'=>'UserController@getToken']);

// Version
// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });

// Generate key app laravel
// $router->get('/key', function(){
//     return str_random(32);
// });

// *********************************************************************************************************************

// $router->get('/clientes',['uses'=>'UserController@get_client']);
