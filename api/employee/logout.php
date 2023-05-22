<?php 
  include_once "../config/headers.php";
  include_once "../config/database.php";
  include_once "../objects/token.php";

  $database = new Database();
  $db = $database->getConnection();
  
  $data = json_decode(file_get_contents("php://input"));

  $token = new Token($db);
  $token->token = $data->token;
  
  if ($token->remove()) {
    http_response_code(200);
    echo json_encode(array("message" => "Вы вышли из системы"), JSON_UNESCAPED_UNICODE);
}
else {
    http_response_code(503);
    echo json_encode(array("message" => "Не удалось выйти"));
}
?>