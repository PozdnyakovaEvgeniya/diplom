<?php
	include_once "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/employee.php";
	require_once('../vendor/autoload.php');
	require_once('../config/core.php');
	
	use Firebase\JWT\JWT;
	
	$database = new Database();
	$db = $database->getConnection();

	$employee = new Employee($db);

	$data = json_decode(file_get_contents("php://input"));

	$employee->number = $data->number;
	$employee_exists = $employee->findNumber();
		
	if ($employee_exists && password_verify($data->password, $employee->password)) {
		$token = array(
			"iss" => $iss,
			"aud" => $aud,
			"iat" => $iat,
			"nbf" => $nbf,
			"data" => array(
				"id" => $employee->id,
				"number" => $employee->number,
				"status" => $employee->status,
				"job_title" => $employee->job_title,
				"department_id" => $employee->department_id,
				"short_name" => $employee->getShortName(),
			)
		);   
		
		http_response_code(200);
		
		$jwt = JWT::encode($token, $key, 'HS256');
		 
		echo json_encode(
			array(
				"message" => "success",
				"jwt" => $jwt
			)
		);
	} else {
		http_response_code(401);
		echo json_encode(array("message" => "Неверный логин или пароль"));
	}
?>