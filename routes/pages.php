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

