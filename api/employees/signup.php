<?php 
  include "../config/headers.php";
  include_once "../config/database.php";
  include_once "../objects/employee.php";

  $database = new Database();
  $db = $database->getConnection();

  $employee = new Employee($db);

	$data = json_decode(file_get_contents("php://input"));

  $password = "";

  if (empty($data->password)) {
    if ($data -> status == 0) {
      $password = $data->password;
    } else {
      http_response_code(400);

      echo json_encode(array("message" => "Данному пользователю пароль обязателен"));
      exit();
    }
  }

  $employee->number = $data->number;
  $employee->surname = $data->surname;
  $employee->name = $data->name;
  $employee->patronymic = empty($data->patronymic) ? NULL : $data->patronymic;
  $employee->job_title = $data->job_title;
  $employee->department_id = $data->department_id;
  $employee->shift_id = $data->shift_id;
  $employee->status = $data->status;
  $employee->password = empty($data->password) ? NULL : $data->password;

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