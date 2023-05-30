<?php
	include_once "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/hour.php";

	$database = new Database();
	$db = $database->getConnection();

    $hour = new Hour($db);
    $hour->employee_id = $_GET['employee_id'];
    $hour->date_id = $_GET['date_id'];

	$stmt = $hour->getOne();

	if ($hour->id != null) {
		$hour = array(
			"id" => $hour->id,
			"hour" => $employee->hour,
			"overtime" => $employee->overtime,
			"time_off" => $employee->time_off,
            "status" => $employee->status,
		);

		http_response_code(200);
		echo json_encode($hour);
	} else {
		http_response_code(404);
		echo json_encode(array("message" => "Не найден"), JSON_UNESCAPED_UNICODE);
	}		
?>