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
			"name" => $employee->getFullName(),
			"job_title" => $employee->job_title,
			"working_mode" => $employee->working_mode,
			"overtime" => $employee->overtime,
		);

		http_response_code(200);
		echo json_encode($employee);
	} else {
		http_response_code(404);
	}
?>