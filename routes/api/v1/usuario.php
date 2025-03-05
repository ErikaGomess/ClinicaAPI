<?php


use App\Http\Response;
use App\Controller;

$obRouter->get('/api/v1/usuarios',[
        'middlewares' =>[
           
        ],
        function ($request){
            return new Response(200, Controller\Usuarios::getUsuarios($request), 'application/json');
        }
]);

$obRouter->get('/api/v1/usuario/{id}',[
        'middlewares' =>[
           
        ],
        function ($request, $id){
            return new Response(200, Controller\Usuarios::getUsuario($request,$id), 'application/json');
        }
]);

$obRouter->post('/api/v1/usuario',[
        'middlewares' =>[],
        function ($request){
            return new Response(200, Controller\Usuarios::setNewUsuario($request), 'application/json');
        }
]);

$obRouter->put('/api/v1/usuario/{id}',[
        'middlewares' =>[],
        function ($request, $id){
            return new Response(200, Controller\Usuarios::setEditUsuario($request, $id), 'application/json');
        }
]);

$obRouter->delete('/api/v1/usuario/{id}',[
        'middlewares' =>[],
        function ($request, $id){
            return new Response(200, Controller\Usuarios::setDeleteUsuario($request, $id), 'application/json');
        }
]);
