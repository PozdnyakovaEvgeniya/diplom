<?php
	include "../config/headers.php";
	include_once "../config/database.php";
	include_once "../objects/employee.php";
	include_once "../objects/date.php";
	include_once "../objects/hour.php";
	include_once "../objects/period.php";
	include_once "../objects/status.php";
	$database = new Database();
	$db = $database->getConnection();

	$employee = new Employee($db);
    $employee->department_id = $_GET['id'];
	$stmt = $employee->getOfDepartment();
    $num = $stmt->rowCount();

	$employees = array();
	
	if ($num > 0) {        
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
					$period = new Period($db);
					$period->employee_id = $employees[$i]['id'];
					
					$period->getOfDate($row['date']);

					$employee_status;

					if ($period->status_id) {
						$status = new Status($db);
						$status->id = $period->status_id;
						$status->getOne();

						$employee_status = $status->short_name;
					} elseif ($row['status'] == 1) {
						$employee_status = "В";
					} else {
						$employee_status = "Я";
					}					

					$date_item = array(
						"id" => $row['id'],
						"date" => $row['date'],
						"plan_hours" => $row['hours'],
						"date_status" => $row['status'],
						"employee_status" => $employee_status,
					);
					array_push($dates, $date_item);
				}

				for ($j = 0; $j < count($dates); $j++) {
					$hour = new Hour($db);
					$hour->employee_id = $employees[$i]['id'];
					$hour->date_id = $dates[$j]['id'];

					$stmt = $hour->getOne();

					$period = new Period($db);
					$period->employee_id = $employees[$i]['id'];
					$period->start = $dates[$j]['date'];
					$period->status_id = 1;
					
					$stmt = $period->getOne();

					$dates[$j]['hours'] = $hour->hours + $period->hours;
				}
			} else {
				$dates = array();
			}

			$employees[$i]['dates'] = $dates;
		}
	} 	

	http_response_code(200);
	echo json_encode($employees);
?>