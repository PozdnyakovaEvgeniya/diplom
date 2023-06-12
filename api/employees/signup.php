<?php 
  include "../config/headers.php";
  include_once "../config/database.php";
  include_once "../objects/employee.php";

  $database = new Database();
  $db = $database->getConnection();

  $employee = new Employee($db);

  $password = "";

  if (empty($_GET['password'])) {
    if ($_GET['status'] == 0) {
      $password = NULL;
    } else {
      http_response_code(400);

      echo json_encode(array("message" => "Данному пользователю пароль обязателен"));
      exit();
    }
  } else {
    $password = $_GET['password'];
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

  if (
    !$employee->findNumber()
  ) {
    $stmt = $employee->add();

    http_response_code(200);
    echo json_encode(array("message" => "success"));
  } else {
    http_response_code(400);
    echo json_encode(array("message" => "Работник с таким табельным номером уже существует"));
  }
?>