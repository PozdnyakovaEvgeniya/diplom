<?php
	include "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/period.php";
	include_once "../objects/employee.php";

	$database = new Database();
	$db = $database->getConnection();

    $period = new Period($db);

    $data = json_decode(file_get_contents("php://input"));

    $period->status_id = $data->status_id;
    $period->employee_id = $data->employee_id;
    $period->start = $data->start;
    $period->end = $data->end;
    $period->hours = $data->hours;
    
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