<?php
	include "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/shift.php";

	$database = new Database();
	$db = $database->getConnection();

    $shift = new Shift($db);
	$shift->id = isset($_GET["id"]) ? $_GET["id"]: die();

	$shift->getOne();

	if ($shift->id != null) {
		$shift = array(
			"id" => $shift->id,
			"name" => $shift->name,
		);

		http_response_code(200);
		echo json_encode($shift);
	} else {
		http_response_code(404);
	}
?>