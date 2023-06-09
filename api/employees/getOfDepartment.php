<?php
	include "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/employee.php";
	
	$database = new Database();
	$db = $database->getConnection();

	$employee = new Employee($db);
    $employee->department_id = $_GET['id'];
	$stmt = $employee->getOfDepartment();
    $num = $stmt->rowCount();

	$employees = array();
	
	if ($num > 0) {        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $employee_item = array(
                "id" => $id,
                "number" => $number,
                "name" => $surname.' '.$name.' '.$patronymic,
                "shift_id" => $shift_id,
                "job_title" => $job_title,
				"status" => $status,
            );
            array_push($employees, $employee_item);
        }
	} 	

	http_response_code(200);
	echo json_encode($employees);
?>