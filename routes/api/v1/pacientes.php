<?php


use App\Http\Response;
use App\Controller;

$obRouter->get('/api/v1/pacientes',[
        'middlewares' =>[
           
        ],
        function ($request){
            return new Response(200, Controller\Pacientes::getPacientes($request), 'application/json');
        }
]);

$obRouter->get('/api/v1/paciente/{id}',[
        'middlewares' =>[
           
        ],
        function ($request, $id){
            return new Response(200, Controller\Pacientes::getPaciente($request,$id), 'application/json');
        }
]);

$obRouter->post('/api/v1/paciente',[
        'middlewares' =>[],
        function ($request){
            return new Response(200, Controller\Pacientes::setNewPaciente($request), 'application/json');
        }
]);

$obRouter->put('/api/v1/paciente/{id}',[
        'middlewares' =>[],
        function ($request, $id){
            return new Response(200, Controller\Pacientes::setEditPaciente($request, $id), 'application/json');
        }
]);

$obRouter->delete('/api/v1/paciente/{id}',[
        'middlewares' =>[],
        function ($request, $id){
            return new Response(200, Controller\Pacientes::setDeletePaciente($request, $id), 'application/json');
        }
]);
