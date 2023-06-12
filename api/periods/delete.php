<?php
	include "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/period.php";
	include_once "../objects/employee.php";

	$database = new Database();
	$db = $database->getConnection();

    $period = new Period($db);

    $period->id = $_GET['id'];

	$period->getOfId();

    if ($period->status_id == 1) {
        $employee = new Employee($db);
        $employee->id = $period->employee_id;
        $employee->getOne();
        print_r($employee);

        $employee->overtime = $employee->overtime + $period->hours;
        $employee->update();
    }
        
    $period->delete();
    http_response_code(200);
?>