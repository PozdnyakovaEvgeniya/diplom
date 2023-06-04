<?php
	include "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/date.php";
	include_once "../objects/hour.php";
	include_once "../objects/employee.php";

	$database = new Database();
	$db = $database->getConnection();

    $date = new Date($db);

    $date->date = $_GET['date'];
    $date->shift_id = $_GET['shift_id'];
    $date->hours = $_GET['hours'];
    $date->status = $_GET['status'];

	if ($date->add()) {
        $date->getOne();

        $employee = new Employee($db);
        $employee->shift_id = $date->shift_id;
        $stmt = $employee->getOfShift();   
        $num = $stmt->rowCount();

        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $hour = new Hour($db);
                $hour->date_id = $date->id;
                $hour->employee_id = $row['id'];
                $hour->add();
            }
        }     
        http_response_code(200);      
    } else {
        http_response_code(400);
    }
?>