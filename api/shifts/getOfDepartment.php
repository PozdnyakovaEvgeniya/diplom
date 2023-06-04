<?php
	include "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/shift.php";

	$database = new Database();
	$db = $database->getConnection();

    $shift = new Shift($db);
    $shift->department_id = $_GET['id'];

	$stmt = $shift->getOfDepartment();
    $num = $stmt->rowCount();

	if ($num > 0) {
        $shifts_arr = array();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $shift_item = array(
                "id" => $id,
                "name" => $name,
            );
            array_push($shifts_arr, $shift_item);
        }
    
        http_response_code(200);
        echo json_encode($shifts_arr);
    }		
?>