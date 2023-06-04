<?php
	include "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/department.php";

	$database = new Database();
	$db = $database->getConnection();

    $department = new Department($db);
	
    $stmt = $department->get();
    $num = $stmt->rowCount();

    $departments = array();

	if ($num > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $department_item = array(
                "id" => $id,
                "name" => $name,
            );
            array_push($departments, $department_item);
        }
    } 

    http_response_code(200);
    echo json_encode($departments);
?>