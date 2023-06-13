<?php
	include "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/status.php";

	$database = new Database();
	$db = $database->getConnection();

    $status = new Status($db);
    $status->name = $_GET['name'];
    $status->short_name = $_GET['short_name'];
    $status->hourly = $_GET['hourly'];

    $status->add();
    http_response_code(200);   
?>