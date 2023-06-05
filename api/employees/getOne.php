<?php
	include "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/employee.php";

	$database = new Database();
	$db = $database->getConnection();

    $employee = new Employee($db);
	$employee->id = isset($_GET["id"]) ? $_GET["id"]: die();

	$employee->getOne();

	if ($employee->number != null) {
		$employee = array(
			"id" => $employee->id,
			"number" => $employee->number,
			"surname" => $employee->surname,
			"name" => $employee->name,
			"patronymic" => $employee->patronymic,
			"fullName" => $employee->getFullName(),
			"job_title" => $employee->job_title,
			"department_id" => $employee->department_id,
			"shift_id" => $employee->shift_id,
			"status" => $employee->status,
			"overtime" => $employee->overtime,
			"password" => $employee->password,
		);

		http_response_code(200);
		echo json_encode($employee);
	} else {
		http_response_code(404);
	}
?>