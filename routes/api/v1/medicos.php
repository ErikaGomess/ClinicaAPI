<?php

use App\Http\Response;
use App\Controller;

$obRouter->get('/api/v1/medicos', [
    'middlewares' => [
    ],
    function ($request) {
        return new Response(200, Controller\Medicos::getMedicos($request), 'application/json');
    }
]);

$obRouter->get('/api/v1/medico/{id}', [
    'middlewares' => [
    ],
    function ($request, $id) {
        return new Response(200, Controller\Medicos::getMedico($request, $id), 'application/json');
    }
]);

$obRouter->post('/api/v1/medico', [
    'middlewares' => [],
    function ($request) {
        return new Response(200, Controller\Medicos::setNewMedico($request), 'application/json');
    }
]);

$obRouter->put('/api/v1/medico/{id}', [
    'middlewares' => [],
    function ($request, $id) {
        return new Response(200, Controller\Medicos::setEditMedico($request, $id), 'application/json');
    }
]);

$obRouter->delete('/api/v1/medico/{id}', [
    'middlewares' => [],
    function ($request, $id) {
        return new Response(200, Controller\Medicos::setDeleteMedico($request, $id), 'application/json');
    }
]);
