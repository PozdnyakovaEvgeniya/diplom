<?php
	include "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/shift.php";

	$database = new Database();
	$db = $database->getConnection();

    $shift = new Shift($db);

    $data = json_decode(file_get_contents("php://input"));

    $shift->name = $data->name;
    $shift->department_id = $data->department_id;

    $shift->add();

	if ($shift->add()) {
        http_response_code(200);
    } else {
        http_response_code(400);
    };
?>