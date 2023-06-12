<?php
	include "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/department.php";
	include_once "../objects/shift.php";

	$database = new Database();
	$db = $database->getConnection();

    $department = new Department($db);

    $department->id = $_GET["id"];
    $department->name = $_GET["name"];
    $department->getOneOfName();

    if (!empty($department->id) && $department->id != $data->id) {
        http_response_code(400);
        echo json_encode(array("message" => "Отдел с таким названием уже существует"));
    } else {
        $department->id = $_GET["id"];
        $department->name = $_GET["name"];
        $department->update();
        http_response_code(200);
    }
?>