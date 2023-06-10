<?php 
  include "../config/headers.php";
  include_once "../config/database.php";
  include_once "../objects/employee.php";
  include_once "../objects/token.php";

  $database = new Database();
  $db = $database->getConnection();

  $employee = new Employee($db);

	$data = json_decode(file_get_contents("php://input"));

  $employee->id = $data->id;
  $employee->getOne();

  if (password_verify($data->password_old, $employee->password)) {
    if ($data->password_new == $data->password_confirm) {
      $employee->password = password_hash($data->password_new, PASSWORD_BCRYPT);
      
      $stmt = $employee->update();
      $token = new Token($db);
      $token->employee_id = $data->id;
      $token->delete();
      
      $token = new Token($db);
      $token->employee_id = $data->id;
      $token->create();      

      http_response_code(200);
  
      echo json_encode(array("token" => $token->token));

    } else {
      http_response_code(401);
      echo json_encode(array(
        "message" => "Пароли не совпадают",
      ));
    }
  } else {
		http_response_code(401);
		echo json_encode(array(
			"message" => "Неверный логин или пароль",
		));
  }
?>