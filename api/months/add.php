<?php
	include "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/month.php";

	$database = new Database();
	$db = $database->getConnection();

    $month = new Month($db);

    $data = json_decode(file_get_contents("php://input"));

    $month->department_id = $data->department_id;
    $month->year = $data->year;
    $month->month = $data->month;
    $month->add();
   
    http_response_code(200);    
?>