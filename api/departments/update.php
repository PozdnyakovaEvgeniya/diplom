<?php
	include "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/department.php";
	include_once "../objects/shift.php";

	$database = new Database();
	$db = $database->getConnection();

    $department = new Department($db);

    $data = json_decode(file_get_contents("php://input"));
    $department->id = $data->id;
    $department->name = $data->name;
    $department->getOneOfName();

    if (!empty($department->id) && $department->id != $data->id) {
        http_response_code(400);
        echo json_encode(array("message" => "Отдел с таким названием уже существует"));
    } else {
        print_r(1);
        $department->id = $data->id;
        $department->name = $data->name;
        $department->update();
        http_response_code(200);
    }
?>