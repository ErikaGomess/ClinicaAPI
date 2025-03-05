<?php


use App\Http\Response;
use App\Controller;

$obRouter->get('/api/v1/prontuarios',[
        'middlewares' =>[
           
        ],
        function ($request){
            return new Response(200, Controller\Prontuarios::getProntuarios($request), 'application/json');
        }
]);

$obRouter->get('/api/v1/prontuario/{id}',[
        'middlewares' =>[
           
        ],
        function ($request, $id){
            return new Response(200, Controller\Prontuarios::getProntuario($request,$id), 'application/json');
        }
]);

$obRouter->post('/api/v1/prontuario',[
        'middlewares' =>[],
        function ($request){
            return new Response(200, Controller\Prontuarios::setNewProntuario($request), 'application/json');
        }
]);

$obRouter->put('/api/v1/prontuario/{id}',[
        'middlewares' =>[],
        function ($request, $id){
            return new Response(200, Controller\Prontuarios::setEditProntuario($request, $id), 'application/json');
        }
]);

$obRouter->delete('/api/v1/prontuario/{id}',[
        'middlewares' =>[],
        function ($request, $id){
            return new Response(200, Controller\Prontuarios::setDeleteProntuario($request, $id), 'application/json');
        }
]);
