<?php
	include "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/shift.php";

	$database = new Database();
	$db = $database->getConnection();

    $shift = new Shift($db);

    $shift->name = $_GET['name'];
    $shift->department_id = $_GET['department_id'];

    $shift->add();
    http_response_code(200);
?>