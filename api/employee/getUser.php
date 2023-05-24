<?php
  
	include_once "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/employee.php";
	include_once "../objects/token.php";
	
	$database = new Database();
	$db = $database->getConnection();

	$data = json_decode(file_get_contents("php://input")); 
  
  $token = new Token($db);
  $token->token = $data->token;
  $token->getOfToken();

	$employee = new Employee($db);
  $employee->id = $token->employee_id;
  $employee->getOne();

  if ($employee->number != null) {
		$employee = array(
			"id" => $employee->id,
			"number" => $employee->number,
			"short_name" => $employee->getShortName(),
      		"status" => $employee->status,
			"department_id" => $employee->department_id,
			"job_title" => $employee->job_title,
		);

		// http_response_code(200);
		echo json_encode($employee);
	} else {
		// http_response_code(404);
		echo json_encode(array("message" => "Доступ запрещен"), JSON_UNESCAPED_UNICODE);
	}
?>