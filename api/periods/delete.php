<?php
	include "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/period.php";

	$database = new Database();
	$db = $database->getConnection();

    $period = new Period($db);

    $period->id = $_GET['id'];

	if ($period->delete()) {
        http_response_code(200);
    } else {
        http_response_code(400);
    };
?>