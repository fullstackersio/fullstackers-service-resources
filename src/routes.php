<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/test_pdo', function($request, $response, $args) {
    $user = 'postgres';
    $pass = 'postgres';
    $db = new PDO('pgsql:host=localhost;port=5432;dbname=fullstackers', $user, $pass);
    foreach($db->query('SELECT * FROM test') as $row) {
        echo $row['col_1'] . '<br>';
    }
});


$app->get('/', function (Request $request, Response $response, array $args) {
    $this->logger->info("Testing");
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get('/resources', Fullstackersio\Controller\ResourceController::class . ':list');

$app->get('/test_json', function(Request $request, Response $response, array $args) {
    return $response->withJson(['test' => 'A', 'test2' => 'B']);
});

/*
/v0/presentations
/v0/presentations/{id}

/v0/resources
/v0/resources/{id}
*/