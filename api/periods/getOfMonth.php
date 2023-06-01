<?php
	include_once "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/period.php";
	include_once "../objects/status.php";

	$database = new Database();
	$db = $database->getConnection();

    $period = new Period($db);
    $period->employee_id = $_GET['id'];

    $start = $_GET['start'];
    $end = $_GET['end'];

	$stmt = $period->getOfMonth($start, $end);
    $num = $stmt->rowCount();

	if ($num > 0) {
        $periods = array();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $status = new Status($db);
            $status->id = $status_id;

            $status->getOne();

            $period_item = array(
                "id" => $id,
                "status" => $status->name,
                "start" => $start,
                "end" => $end,
            );
            array_push($periods, $period_item);
        }
    
        http_response_code(200);
        echo json_encode($periods);
    }		
?>