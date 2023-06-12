<?php
	include "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/status.php";

	$database = new Database();
	$db = $database->getConnection();

    $status = new Status($db);

    $data = json_decode(file_get_contents("php://input"));
    $status->name = $data->name;
    $status->short_name = $data->short_name;
    $status->hourly = $data->hourly;

    $status->add();
    http_response_code(200);   
?>