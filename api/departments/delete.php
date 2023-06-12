<?php
	include "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/department.php";
	include_once "../objects/employee.php";

	$database = new Database();
	$db = $database->getConnection();

    $department = new Department($db);

    $department->id = $_GET['id'];

    $employee = new Employee($db);
    $employee->department_id = $_GET['id'];
    $stmt = $employee->getOfDepartment();

    $num = $stmt->rowCount();

	if ($num == 0) {
        $department->delete();
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
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Невозможно удалить отдел с работниками"));
    };
?>