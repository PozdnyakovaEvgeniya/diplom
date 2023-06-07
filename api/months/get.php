<?php
	include "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/month.php";

	$database = new Database();
	$db = $database->getConnection();

    $month = new Month($db);
    $month->department_id = $_GET['department_id'];
    $month->year = $_GET['year'];
    $month->month = $_GET['month'];
	
    $stmt = $month->getOne();
    $num = $stmt->rowCount();

    http_response_code(200);
    echo json_encode(array("count" => $num));
?>