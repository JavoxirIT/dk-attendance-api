<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	header("Access-Control-Allow-Methods: POST, GET, DELETE, UPDATE, OPTIONS");
	
	// SELECT distinct stud.*, par.party_name as g_name, les.start_time, les.end_time as l_name, tra.days as training_days FROM student stud inner join party par on stud.party_id = par.id inner join lesson_time les on les.id = stud.class_time_id inner join training_days tra on tra.id = stud.training_days_id where stud.id > 0 order by stud.id desc;

	include_once 'config.php';
	$data = file_get_contents("php://input");
	// $arr = json_decode($data);
	// $group_id = $arr->group_id;
	$ret = [];

	$result = mysqli_query($link,"SELECT distinct stud.*, 
			par.party_name, 
			les.start_time, les.end_time, 
			tra.days as training_days FROM student stud 
			inner join party par on stud.party_id = par.id 
			inner join lesson_time les on les.id = stud.class_time_id 
			inner join training_days tra on tra.id = stud.training_days_id where stud.party_id > 0" 
			);
	$data = $result->fetch_all(MYSQLI_ASSOC);

	if($data){
		$presentsByGroup = [];
		foreach ($data as $rows) {
			if ( !isset($presentsByGroup[$rows['party_id']])) {
				$presentsByGroup[$rows['party_id']] = (object) [
					'id' => $rows['party_id'],
					'group_name' => $rows['party_name'],
					'start_time' => $rows['start_time'],
					'end_time' => $rows['end_time'],
					'training_days' => $rows['training_days'],
				];
			}
			$presentsByGroup[$rows['party_id']]->students[] = $rows;
			$ret = $presentsByGroup;

		}
	}
	else{
		$ret += ["statusCode" => 400, "message" => "Нет данных", "data"=> $data];
	}
	echo json_encode($ret);
?>

