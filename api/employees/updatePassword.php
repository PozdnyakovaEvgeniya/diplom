<?php 
  include "../config/headers.php";
  include_once "../config/database.php";
  include_once "../objects/employee.php";
  include_once "../objects/token.php";

  $database = new Database();
  $db = $database->getConnection();

  $employee = new Employee($db);

  $employee->id = $_GET['id'];
  $employee->getOne();

  if (password_verify($_GET['password_old'], $employee->password)) {
    if ($_GET['password_new'] == $_GET['password_confirm']) {
      $employee->password = password_hash($_GET['password_new'], PASSWORD_BCRYPT);
      
      $stmt = $employee->update();
      $token = new Token($db);
      $token->employee_id = $_GET['id'];
      $token->delete();
      
      $token = new Token($db);
      $token->employee_id = $_GET['id'];
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