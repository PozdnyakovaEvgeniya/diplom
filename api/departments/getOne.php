<?php
	include "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/department.php";

	$database = new Database();
	$db = $database->getConnection();

    $department = new Department($db);
	$department->id = isset($_GET["id"]) ? $_GET["id"]: die();

	$department->getOne();

	if ($department->id != null) {
		$department = array(
			"id" => $department->id,
			"name" => $department->name,
		);

		http_response_code(200);
		echo json_encode($department);
	} else {
		http_response_code(404);
	}
?>