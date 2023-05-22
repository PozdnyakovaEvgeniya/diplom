<?php
	include_once "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/employee.php";
	include_once "../objects/token.php";

	
	$database = new Database();
	$db = $database->getConnection();

	$employee = new Employee($db);

	$data = json_decode(file_get_contents("php://input"));

	$employee->number = $data->number;
	$employee_exists = $employee->findNumber();
		
	if ($employee_exists && password_verify($data->password, $employee->password)) {
		$token = new Token($db);


		$token->employee_id = $employee->id;
		$token->create();

		http_response_code(200);
		echo json_encode(array(
			"token" => $token->token,
		)); 
	} else {
		http_response_code(401);
		echo json_encode(array(
			"message" => "Неверный логин или пароль",
		));
	}
?>