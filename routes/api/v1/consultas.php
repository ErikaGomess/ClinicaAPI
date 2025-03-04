<?php


use App\Http\Response;
use App\Controller;

$obRouter->get('/api/v1/consultas',[
        'middlewares' =>[
           
        ],
        function ($request){
            return new Response(200, Controller\Consultas::getConsultas($request), 'application/json');
        }
]);

$obRouter->get('/api/v1/consulta/{id}',[
        'middlewares' =>[
           
        ],
        function ($request, $id){
            return new Response(200, Controller\Consultas::getConsulta($request,$id), 'application/json');
        }
]);

$obRouter->post('/api/v1/consulta',[
        'middlewares' =>[],
        function ($request){
            return new Response(200, Controller\Consultas::setNewConsulta($request), 'application/json');
        }
]);

$obRouter->put('/api/v1/consulta/{id}',[
        'middlewares' =>[],
        function ($request, $id){
            return new Response(200, Controller\Consultas::setEditConsulta($request, $id), 'application/json');
        }
]);

$obRouter->delete('/api/v1/consulta/{id}',[
        'middlewares' =>[],
        function ($request, $id){
            return new Response(200, Controller\Consultas::setDeleteConsulta($request, $id), 'application/json');
        }
]);
