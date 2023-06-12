<?php 
  include "../config/headers.php";
  include_once "../config/database.php";
  include_once "../objects/employee.php";

  $database = new Database();
  $db = $database->getConnection();

  $employee = new Employee($db);

  $employee->id = $_GET['id'];
  $employee->getOne();

  $password = "";

  if (empty($_GET['password'])) {
    if ($_GET['status'] == 0) {
      $password = $_GET['password'];
    } else {
      http_response_code(400);

      echo json_encode(array("message" => "Данному пользователю пароль обязателен"));
      exit();
    }
  } elseif ($_GET['password'] == $employee->password) {
    $password = $_GET['password'];
  } elseif ($_GET['password'] != $employee->password) {
    $password = password_hash($_GET['password'], PASSWORD_BCRYPT);
  }

  $employee->number = $_GET['number'];
  $employee->surname = $_GET['surname'];
  $employee->name = $_GET['name'];
  $employee->patronymic = empty($_GET['patronymic']) ? NULL : $_GET['patronymic'];
  $employee->job_title = $_GET['job_title'];
  $employee->department_id = $_GET['department_id'];
  $employee->shift_id = $_GET['shift_id'];
  $employee->status = $_GET['status'];
  $employee->password = $password;

  $stmt = $employee->update();
  http_response_code(200);

  echo json_encode(array("message" => "success"));
?>