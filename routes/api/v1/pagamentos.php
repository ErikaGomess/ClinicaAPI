<?php


use App\Http\Response;
use App\Controller;

$obRouter->get('/api/v1/pagamentos',[
        'middlewares' =>[
           
        ],
        function ($request){
            return new Response(200, Controller\Pagamento::getPagamentos($request), 'application/json');
        }
]);

$obRouter->get('/api/v1/pagamento/{id}',[
        'middlewares' =>[
           
        ],
        function ($request, $id){
            return new Response(200, Controller\Pagamento::getPagamento($request,$id), 'application/json');
        }
]);

$obRouter->post('/api/v1/pagamento',[
        'middlewares' =>[],
        function ($request){
            return new Response(200, Controller\Pagamento::setNewPagamento($request), 'application/json');
        }
]);

$obRouter->put('/api/v1/pagamento/{id}',[
        'middlewares' =>[],
        function ($request, $id){
            return new Response(200, Controller\Pagamento::setEditPagamento($request, $id), 'application/json');
        }
]);

$obRouter->delete('/api/v1/pagamento/{id}',[
        'middlewares' =>[],
        function ($request, $id){
            return new Response(200, Controller\Pagamento::setDeletePagamento($request, $id), 'application/json');
        }
]);
