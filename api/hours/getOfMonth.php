<?php
	include_once "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/hour.php";

	$database = new Database();
	$db = $database->getConnection();

    $hour = new Hour($db);
    $hour->employee_id = $_GET['id'];
	$start = $_GET['start'];
	$end = $_GET['end'];

	$stmt = $hour->getOfMonth($start, $end);
    $num = $stmt->rowCount();

	if ($num > 0) {
        $hours_arr = array();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $hour_item = array(
                "date" => $date,
                "hours" => $hours,
                "overtime" => $overtime,
                "time_off" => $time_off,
            );
            array_push($hours_arr, $hour_item);
        }
    
        http_response_code(200);
        echo json_encode($hours_arr);
    }
		
?>