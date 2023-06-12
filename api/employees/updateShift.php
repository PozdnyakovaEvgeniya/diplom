<?php 
  include "../config/headers.php";
  include_once "../config/database.php";
  include_once "../objects/employee.php";

  $database = new Database();
  $db = $database->getConnection();

  $employee = new Employee($db);

  $employee->id = $_GET['id'];
  $employee->getOne();

  $employee->shift_id = $_GET['shift_id'];
  
  $employee->update();
  http_response_code(200);
?>