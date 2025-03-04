<?php

use App\Http\Response;
use App\Controller;

$obRouter->get('/api/v1/especialidades', [
    'middlewares' => [
    ],
    function ($request) {
        return new Response(200, Controller\Especialidades::getEspecialidades($request), 'application/json');
    }
]);

$obRouter->get('/api/v1/especialidade/{id}', [
    'middlewares' => [
    ],
    function ($request, $id) {
        return new Response(200, Controller\Especialidades::getEspecialidade($request, $id), 'application/json');
    }
]);

$obRouter->post('/api/v1/especialidade', [
    'middlewares' => [],
    function ($request) {
        return new Response(200, Controller\Especialidades::setNewEspecialidade($request), 'application/json');
    }
]);

$obRouter->put('/api/v1/especialidade/{id}', [
    'middlewares' => [],
    function ($request, $id) {
        return new Response(200, Controller\Especialidades::setEditEspecialidade($request, $id), 'application/json');
    }
]);

$obRouter->delete('/api/v1/especialidade/{id}', [
    'middlewares' => [],
    function ($request, $id) {
        return new Response(200, Controller\Especialidades::setDeleteEspecialidade($request, $id), 'application/json');
    }
]);
