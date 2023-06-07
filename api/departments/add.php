<?php
	include "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/department.php";
	include_once "../objects/shift.php";

	$database = new Database();
	$db = $database->getConnection();

    $department = new Department($db);

    $data = json_decode(file_get_contents("php://input"));
    $department->name = $data->name;
    $department->getOneOfName();

    if ($department->id == null) {
        $department->name = $data->name;
        $department->add();
        
        $department->name = $data->name;
        $department->getOneOfName();

        $shift = new Shift($db);
        $shift->name = "Стандартная";
        $shift->department_id = $department->id;
        $shift->add();

        http_response_code(200);
        echo json_encode(array("id" => $department->id));
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Отдел с таким названием уже существует"));
    }
?>