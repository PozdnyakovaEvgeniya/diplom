<?php
	include_once "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/date.php";

	$database = new Database();
	$db = $database->getConnection();

    $date = new Date($db);

    $date->date = $_GET['date'];
    $date->shift_id = $_GET['shift_id'];
    $date->hours = $_GET['hours'];
    $date->status = $_GET['status'];

	if ($date->add()) {
        http_response_code(200);
    } else {
        http_response_code(400);
    };
?>