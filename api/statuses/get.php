<?php
	include "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/status.php";

	$database = new Database();
	$db = $database->getConnection();

    $status = new Status($db);

	$stmt = $status->get();
    $num = $stmt->rowCount();

	if ($num > 0) {
        $statuses = array();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $status_item = array(
                "id" => $id,
                "name" => $name,
            );
            array_push($statuses, $status_item);
        }
    
        http_response_code(200);
        echo json_encode($statuses);
    }		
?>