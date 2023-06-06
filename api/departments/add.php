<?php
	include "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/department.php";

	$database = new Database();
	$db = $database->getConnection();

    $department = new Department($db);

    $data = json_decode(file_get_contents("php://input"));

    $department->name = $data->name;

    $department->add();

	// if ($shift->add()) {
    //     // http_response_code(200);
    // } else {
    //     // http_response_code(400);
    // };
?>