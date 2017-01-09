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
          // $payload = json_encode($data);
          $payload = $data;

          $response = new stdClass();
          $response->success = TRUE;
          $response->status = 200;
          $response->message = "Records retrieved.";
          $response->payload = $payload;

          echo json_encode($response, JSON_NUMERIC_CHECK);
      }

});


// 2. POST /tasks
$app->post('/tasks', function (Request $request, Response $response)
{

  $response = $request->getParsedBody();
  $title = $response['title'];
  $desc = $response['description'];

  $host = "localhost";
  $user = "postgres";
  $pass = "";
  $dbname = "fullstacker";
  $db = pg_connect("host=localhost dbname=fullstacker user=postgres")
                or die('Could not connect: ' . pg_last_error());

      $query = "INSERT INTO tasks (title, description) VALUES ('" . $title . "', '" . $desc . "') RETURNING task_id;";
      $stmt = pg_query($query);
      $result = pg_fetch_row($stmt);
      $id = $result[0];

      /* RETURN Result to Client */
      $query = "SELECT task_id AS id, title, description, complete_ind FROM tasks WHERE task_id = " . $id . ";";

      $result = pg_query($db, $query);

      while($row = pg_fetch_assoc($result))
      {
          $row['complete_ind'] = ($row['complete_ind'] == 't') ? true : false;
          $data[] = $row;
      }

      if(isset($data))
      {
          header('Content-Type: application/json');

          $payload = $data;

          $response = new stdClass();
          $response->success = TRUE;
          $response->status = 200;
          $response->message = "Record created.";
          $response->payload = $payload;

          echo json_encode($response, JSON_NUMERIC_CHECK);
      }

});



// 3. PUT /tasks/1
$app->put('/tasks/{name}', function (Request $request, Response $response)
{

  $name = $request->getAttribute('name');

  $response = $request->getParsedBody();
  $title = $response['title'];
  $desc = $response['description'];
  $complete_ind = $response['status_type'];

  $host = "localhost";
  $user = "postgres";
  $pass = "";
  $dbname = "fullstacker";
  $db = pg_connect("host=localhost dbname=fullstacker user=postgres")
                or die('Could not connect: ' . pg_last_error());

      $query = "UPDATE tasks SET title = '" . $title . "', description = '" . $desc . "', complete_ind = '" . $complete_ind . "' WHERE task_id = " . $name . ";";
      $stmt = pg_query($query);
      $result = pg_fetch_row($stmt);

      /* RETURN Result to Client */
      $query = "SELECT task_id AS id, title, description, complete_ind FROM tasks WHERE task_id = " . $name . ";";

      $result = pg_query($db, $query);

      while($row = pg_fetch_assoc($result))
      {
          $row['complete_ind'] = ($row['complete_ind'] == 't') ? true : false;
          $data[] = $row;
      }

      if(isset($data))
      {
          header('Content-Type: application/json');

          $payload = $data;

          $response = new stdClass();
          $response->success = TRUE;
          $response->status = 200;
          $response->message = "Record updated.";
          $response->payload = $payload;

          echo json_encode($response, JSON_NUMERIC_CHECK);
      }

});



// 4. DELETE /tasks/1
$app->delete('/tasks/{name}', function (Request $request, Response $response)
{

  $name = $request->getAttribute('name');

  $host = "localhost";
  $user = "postgres";
  $pass = "";
  $dbname = "fullstacker";
  $db = pg_connect("host=localhost dbname=fullstacker user=postgres")
                or die('Could not connect: ' . pg_last_error());

      $query = "UPDATE tasks SET active_ind = 0  WHERE task_id = " . $name . ";";
      $stmt = pg_query($query);
      $result = pg_fetch_row($stmt);

      /* RETURN Result to Client */
      $query = "SELECT task_id AS id, title, description, complete_ind FROM tasks WHERE task_id = " . $name . ";";

      $result = pg_query($db, $query);

      while($row = pg_fetch_assoc($result))
      {
          $row['complete_ind'] = ($row['complete_ind'] == 't') ? true : false;
          $data[] = $row;
      }

      if(isset($data))
      {
          header('Content-Type: application/json');

          $payload = $data;

          $response = new stdClass();
          $response->success = TRUE;
          $response->status = 200;
          $response->message = "Record deleted.";
          $response->payload = $payload;

          echo json_encode($response, JSON_NUMERIC_CHECK);
      }

});


// Run the application
$app->run();

