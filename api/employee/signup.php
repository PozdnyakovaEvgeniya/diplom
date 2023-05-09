<?php 
    include_once "../config/headers.php";
    include_once "../config/database.php";
    include_once "../objects/employee.php";

    $database = new Database();
    $db = $database->getConnection();

    $employee = new Employee($db);

    $employee->number = $_POST['number'];
    $employee->surname = $_POST['surname'];
    $employee->name = $_POST['name'];
    $employee->patronymic = empty($_POST['patronymic']) ? NULL : $_POST['patronymic'];
    $employee->job_title = $_POST['job_title'];
    $employee->department_id = $_POST['department_id'];
    $employee->status = empty($_POST['status']) ? 0 : $_POST['status'];
    $employee->working_mode = empty($_POST['working_mode']) ? 0 : $_POST['working_mode'];
    $employee->password = empty($_POST['password']) ? NULL : $_POST['password'];

    if (
        isset($employee->number) &&
        isset($employee->surname) &&
        isset($employee->name) &&
        isset($employee->job_title) &&
        isset($employee->department_id) &&
        isset($employee->status) &&
        isset($employee->working_mode) &&
        $employee->create()
    ) {
        http_response_code(200);

        echo json_encode(array("message" => "success"));
    } else {
        http_response_code(400);

        echo json_encode(array("message" => "Невозможно создать пользователя"));
    }
?>