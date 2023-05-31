<?php
	include_once "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/employee.php";
	include_once "../objects/date.php";
	include_once "../objects/hour.php";
	$database = new Database();
	$db = $database->getConnection();

	$employee = new Employee($db);
    $employee->department_id = $_GET['id'];
	$stmt = $employee->getOfDepartment();
    $num = $stmt->rowCount();

	if ($num > 0) {
        $employees = array();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $employee_item = array(
                "id" => $id,
                "number" => $number,
                "name" => $surname.' '.$name.' '.$patronymic,
                "shift_id" => $shift_id,
                "job_title" => $job_title,
            );
            array_push($employees, $employee_item);
        }

		for($i = 0; $i < count($employees); $i++) {
			$date = new Date($db);
			$date->shift_id = $employees[$i]['shift_id'];
			$start = $_GET['start'];
			$end = $_GET['end'];

			$stmt = $date->getOfMonth($start, $end);
			$num = $stmt->rowCount();

			if ($num > 0) {
				$dates = array();
				
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					extract($row);
					$date_item = array(
						"id" => $id,
						"date" => $date,
						"plan_hours" => $hours,
						"date_status" => $status,
					);
					array_push($dates, $date_item);
				}

				for ($j = 0; $j < count($dates); $j++) {
					$hour = new Hour($db);
					$hour->employee_id = $_GET['id'];
					$hour->date_id = $dates[$j]['id'];

					$stmt = $hour->getOne();

					$dates[$j]['hours'] = $hour->hours ? $hour->hours : 0;
					$dates[$j]['overtime'] = $hour->overtime ? $hour->overtime : 0;
					$dates[$j]['time_off'] = $hour->time_off ? $hour->time_off : 0;
					$dates[$j]['status'] = $hour->status ? $hour->status : 0;
				}
			} else {
				$dates = array();
			}

			$employees[$i]['dates'] = $dates;
		}
		http_response_code(200);
		echo json_encode($employees);
	}		
?>