<?php
	include_once "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/department.php";

	$database = new Database();
	$db = $database->getConnection();

    $department = new Department($db);
	$department->id = isset($_GET["id"]) ? $_GET["id"]: die();

	$department->readOne();

	if ($department->name != null) {
		$department = array(
			"id" => $department->id,
			"name" => $department->name,
		);

		http_response_code(200);
		echo json_encode($department);
	} else {
		http_response_code(404);
		echo json_encode(array("message" => "Отдел не существует"), JSON_UNESCAPED_UNICODE);
	}
?>