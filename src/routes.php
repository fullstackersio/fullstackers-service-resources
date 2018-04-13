<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/', function (Request $request, Response $response, array $args) {
    $this->logger->info("Testing");

    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get('/resources', Fullstackersio\Controller\ResourceController::class . ':list');


/*
/v0/presentations
/v0/presentations/{id}

/v0/resources
/v0/resources/{id}
*/