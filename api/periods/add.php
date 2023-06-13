<?php
	include "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/period.php";
	include_once "../objects/employee.php";

	$database = new Database();
	$db = $database->getConnection();

    $period = new Period($db);

    $period->status_id = $_GET['status_id'];
    $period->employee_id = $_GET['employee_id'];
    $period->start = $_GET['start'];
    $period->end = $_GET['end'];
    $period->hours = $_GET['hours'] == "null" ? NULL : $_GET['hours'];
    
    $period->add();

    if ($period->status_id == 1) {
        $employee = new Employee($db);
        $employee->id = $period->employee_id;
        $employee->getOne();

        $employee->overtime = $employee->overtime - $period->hours;
        $employee->update();
    }
    
    http_response_code(200);
?>