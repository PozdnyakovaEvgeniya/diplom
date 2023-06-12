<?php 
  include "../config/headers.php";
  include_once "../config/database.php";
  include_once "../objects/employee.php";

  $database = new Database();
  $db = $database->getConnection();

  $employee = new Employee($db);

	$data = json_decode(file_get_contents("php://input"));

  $employee->id = $data->id;
  $employee->getOne();

  $employee->shift_id = $data->shift_id;
  
  $employee->update();
  http_response_code(200);
?>