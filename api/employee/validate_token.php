<?php
  include_once "../config/headers.php";   
  include_once "../config/core.php";
	include_once "../libs/php-jwt/src/BeforeValidException.php";
	include_once "../libs/php-jwt/src/CachedKeySet.php";
	include_once "../libs/php-jwt/src/ExpiredException.php";
	include_once "../libs/php-jwt/src/SignatureInvalidException.php";
	include_once "../libs/php-jwt/src/JWT.php";
	include_once "../libs/php-jwt/src/Key.php";
  use \Firebase\JWT\JWT;
  use \Firebase\JWT\Key;

	$data = json_decode(file_get_contents("php://input")); 
  $jwt = $data->jwt;  
  
  if ($jwt) {    
    try {
      $decoded = JWT::decode($jwt, new Key($key, 'HS256')); 
      
      http_response_code(200);
      
      echo json_encode(array(
        "message" => "success",
        "user" => $decoded->data
      ));
    }
    
    catch (Exception $e) { 
      http_response_code(401);
      
      echo json_encode(array(
        "message" => "Вам доступ закрыт",
        "error" => $e->getMessage()
      ));
    }
  }
  
  else {
    http_response_code(401);
    
    echo json_encode(array("message" => "Доступ запрещён"));
  }
?>