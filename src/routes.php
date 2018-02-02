<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/', function (Request $request, Response $response, array $args) {
    $this->logger->info("Testing");

    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get('/test_pdo', function($request, $response, $args) {
    $user = 'root';
    $pass = '';
    $db = new PDO('mysql:host=localhost;dbname=fullstackers', $user, $pass);
    foreach($db->query('SELECT * FROM test') as $row) {
        echo $row['name'] . '<br>';
    }
});