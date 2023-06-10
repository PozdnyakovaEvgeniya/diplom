<?php 
  include "../config/headers.php";
  include_once "../config/database.php";
  include_once "../objects/token.php";

  $database = new Database();
  $db = $database->getConnection();
  
  $data = json_decode(file_get_contents("php://input"));

  $token = new Token($db);
  $token->employee_id = $data->id;  
  $token->delete();

  $token = new Token($db);
  $token->employee_id = $data->id;  
  $token->create();

  http_response_code(200);
  echo json_encode(array("token" => $token->token), JSON_UNESCAPED_UNICODE);
?>