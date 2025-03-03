<?php

use App\Http\Response;
use App\Controller;

//Rota home
$obRouter->get('/',[
        'middlewares' =>[
           
        ],
        function ($request){
            return new Response(200, Controller\Api::getDetails($request), 'application/json');
        }
]);

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

