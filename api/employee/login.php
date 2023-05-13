<?php
	include_once "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/employee.php";

	$database = new Database();
	$db = $database->getConnection();

	$employee = new Employee($db);

	$employee->number = $_POST['number'];
	$employee_exists = $employee->findNumber(); 
	
	include_once "../config/core.php";
	include_once "../libs/php-jwt/src/BeforeValidException.php";
	include_once "../libs/php-jwt/src/ExpiredException.php";
	include_once "../libs/php-jwt/src/SignatureInvalidException.php";
	include_once "../libs/php-jwt/src/JWT.php";
	use \Firebase\JWT\JWT;

	
	if ($employee_exists && password_verify($_POST['password'], $employee->password)) {
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