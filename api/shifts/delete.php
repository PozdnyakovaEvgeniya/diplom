<?php
	include "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/shift.php";

	$database = new Database();
	$db = $database->getConnection();

    $shift = new Shift($db);

    $shift->id = $_GET['id'];

	if ($shift->delete()) {
        http_response_code(200);
    } else {
        http_response_code(400);
    };
?>