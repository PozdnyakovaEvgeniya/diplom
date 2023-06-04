<?php
	include "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/employee.php";

	$database = new Database();
	$db = $database->getConnection();

    $employee = new Employee($db);

    $employee->id = $_GET['id'];

	if ($employee->delete()) {
        http_response_code(200);
    } else {
        http_response_code(400);
    };
?>