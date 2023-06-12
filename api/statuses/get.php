<?php
	include "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/status.php";

	$database = new Database();
	$db = $database->getConnection();

    $status = new Status($db);
	$stmt = $status->get();
    $num = $stmt->rowCount();

    $statuses = array();

	if ($num > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $status_item = array(
                "id" => $id,
                "name" => $name,
                "short_name" => $hours,
                "hourly" => $hourly,
            );
            array_push($statuses, $status_item);
        }
    } 

    http_response_code(200);
    echo json_encode($statuses);
?>