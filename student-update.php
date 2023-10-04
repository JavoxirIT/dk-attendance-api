<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	header("Access-Control-Allow-Methods: POST, GET, DELETE, UPDATE, OPTIONS");



	// arrival_date:"2023-09-21"
	// class_time_id:"1"
	// fio:"Шарифбаев Махир"
	// party_id:"1"
	// tel:"+998 (99) 452-22-18"
	// training_days_id:"1"
	// user_id:"1"


	include_once 'config.php';
	$data = file_get_contents("php://input");
	$ret = [];
	$arr = json_decode($data);
	$user_id = $arr->user_id;
	$sql = mysqli_query($link,"SELECT * FROM student WHERE id='$user_id'");	
	$fetch = mysqli_fetch_assoc($sql);
	if($fetch['id']>0){		
		$new_arrival_date = $arr->arrival_date;
		$new_class_time_id = $arr->class_time_id;
		$new_fio = $arr->fio;
		$new_party_id = $arr->party_id;
		$new_tel = $arr->tel;
		$new_training_days_id = $arr->training_days_id;
		
		$sql = mysqli_query($link,"UPDATE student SET arrival_date='$new_arrival_date', class_time_id='$new_class_time_id' ,fio='$new_fio',party_id='$new_party_id',tel='$new_tel',training_days_id='$new_training_days_id'  WHERE id='$user_id'");

		if($sql){
			$result = mysqli_query($link,"SELECT distinct stud.*, 
			par.party_name, 
			les.start_time, les.end_time, 
			tra.days as training_days FROM student stud 
			inner join party par on stud.party_id = par.id 
			inner join lesson_time les on les.id = stud.class_time_id 
			inner join training_days tra on tra.id = stud.training_days_id where stud.id=$user_id ;" 
			);
			$data = $result->fetch_all(MYSQLI_ASSOC);
			$ret += ["statusCode" => 200, "message" => "Данные успешно изменины", "data" => $data ];
		}
		else{
			$ret += ["statusCode" => 405, "message" => "Ошибка при сохранении", "arr"=>$arr];
		}
	}
	else{
		$ret += ["statusCode" => 204, "message" => "Нет данных"];
	}
	echo json_encode($ret);
	?>