
<?php

//phpinfo();exit;
require __DIR__ . '/includes/app.php';

use \App\Http\Router;

//INICIA O ROUTER
$obRouter = new Router(URL);

//INCLUI AS ROTAS DE PÁGINAS
include __DIR__ . '/routes/pages.php';

include __DIR__ . '/routes/api.php';

//imprime o response da rota
$obRouter->run()->sendResponse();

