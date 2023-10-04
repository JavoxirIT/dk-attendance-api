<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	header("Access-Control-Allow-Methods: POST, GET, DELETE, UPDATE, OPTIONS");
	
	// SELECT distinct stud.*, par.party_name as g_name, les.start_time, les.end_time as l_name, tra.days as training_days FROM student stud inner join party par on stud.party_id = par.id inner join lesson_time les on les.id = stud.class_time_id inner join training_days tra on tra.id = stud.training_days_id where stud.id > 0 order by stud.id desc;

	include_once 'config.php';
	$data = file_get_contents("php://input");
	$ret = [];
	$result = mysqli_query($link,"SELECT distinct stud.*, 
		par.party_name, 
		les.start_time, les.end_time, 
		tra.days as training_days FROM student stud 
		inner join party par on stud.party_id = par.id 
		inner join lesson_time les on les.id = stud.class_time_id 
		inner join training_days tra on tra.id = stud.training_days_id where stud.id > 0 order by stud.id desc;" 
		);
	if($result){
		$ret = $result->fetch_all(MYSQLI_ASSOC);
	}
	else{
		$ret += ["statusCode" => 400, "message" => "Нет данных", "data"=> $result];
	}
	echo json_encode($ret);
?>

