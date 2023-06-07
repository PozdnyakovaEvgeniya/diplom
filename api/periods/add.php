<?php
	include "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/period.php";

	$database = new Database();
	$db = $database->getConnection();

    $period = new Period($db);

    $data = json_decode(file_get_contents("php://input"));

    $period->status = $data->status;
    $period->employee_id = $data->employee_id;
    $period->start = $data->start;
    $period->end = $data->end;
    $period->hours = $data->hours;

    $period->add();

    if ($period->add()) {
        http_response_code(200);
    } else {
        http_response_code(400);
    };
?>