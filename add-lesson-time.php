<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	header("Access-Control-Allow-Methods: POST, GET, DELETE, UPDATE, OPTIONS");
	
	include_once 'config.php';
	$data = file_get_contents("php://input");
	$ret = [];
	$arr = json_decode($data);
	if($arr){
		$start_time = $arr->start_time;
	    $end_time = $arr->end_time;
			$sql = mysqli_query($link,"INSERT INTO lesson_time (start_time, end_time) VALUES ('$start_time','$end_time')");
			if($sql){
				$ret += ["statusCode" => 201, "message" => "Новое время урока добавлена"];
			}
			else{
				$ret += ["statusCode" => 405, "message" => "Ошибка при сохранении", "arr"=>$arr];
			}
	}
	else{
		$ret += ["statusCode" => 400, "message" => "Нет данных"];
	}
	echo json_encode($ret);
?>