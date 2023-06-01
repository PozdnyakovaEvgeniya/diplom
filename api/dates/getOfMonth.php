<?php
	include_once "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/date.php";

	$database = new Database();
	$db = $database->getConnection();

    $date = new Date($db);
    $date->shift_id = $_GET['id'];
	$start = $_GET['start'];
	$end = $_GET['end'];

	$stmt = $date->getOfMonth($start, $end);
    $num = $stmt->rowCount();

	if ($num > 0) {
        $dates = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $date_item = array(
                "id" => $id,
                "date" => $date,
                "plan_hours" => $hours,
                "date_status" => $status,
            );
            array_push($dates, $date_item);
        }

        http_response_code(200);
        echo json_encode($dates);
    }
?>