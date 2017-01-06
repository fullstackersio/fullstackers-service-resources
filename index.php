<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';

// Create a new Slim application
$app = new \Slim\App;

// 1. GET /tasks
$app->get('/tasks', function ($request, $response, $args)
{
  $host = "localhost";
  $user = "postgres";
  $pass = "";
  $dbname = "fullstacker";
  $db = pg_connect("host=localhost dbname=fullstacker user=postgres")
                or die('Could not connect: ' . pg_last_error());
  
  
      $query = "SELECT task_id AS id, title, description, complete_ind FROM tasks WHERE active_ind = 1;";
  
      $result = pg_query($db, $query);
  
      while($row = pg_fetch_assoc($result))
      {
          $row['complete_ind'] = ($row['complete_ind'] == 't') ? true : false;
          $data[] = $row;
      }
  
      if(isset($data))
      {
          header('Content-Type: application/json');
          // echo json_encode($data);

          $payload = $data;

          $response = new stdClass();
          $response->success = TRUE;
          $response->status = 200;
          $response->message = "Records retrieved.";
          $response->payload = $payload;

          echo json_encode($response, JSON_NUMERIC_CHECK);

      }

    // ORIGINAL :
    // return $response->write("All of the tasks, boss!");
});

// 2. GET /tasks/1
$app->get('/tasks/{name}', function ($request, $response, $args)
{
    return $response->write("TASK ID: " . $args['name']);
});

// 4. POST /tasks
$app->post('/tasks', function (Request $request, Response $response)
{
    $response = $request->getParsedBody();
    $title = $response['title'];
    $desc = $response['description'];
    return "TITLE : " . $title . " .... DESC : " . $desc;
});


// 5. PUT /tasks/1
$app->put('/tasks/{name}', function (Request $request, Response $response)
{
    $name = $request->getAttribute('name');
    $response = $request->getParsedBody();
    $title = $response['title'];
    $desc = $response['description'];
    $status = $response['status_type'];
    return "ID : " . $name . " .... TITLE : " . $title . " .... DESC : " . $desc . " .... STATUS : " . $status;
});


// 6. DELETE /tasks/1
$app->delete('/tasks/{name}', function (Request $request, Response $response)
{
    $name = $request->getAttribute('name');
    $response = $request->getParsedBody();
    $title = $response['title'];
    return "Deleting Task : " . $title . " (ID : " . $name . ")";
});


// Run the application
$app->run();
