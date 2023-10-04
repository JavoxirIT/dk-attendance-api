<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	header("Access-Control-Allow-Methods: POST, GET, DELETE, UPDATE, OPTIONS");
	
	include_once 'config.php';
	$data = file_get_contents("php://input");
	$ret = [];
	$res= [];
	$arr = json_decode($data);
	if($arr){
			$days = $arr->days;
			$sql = mysqli_query($link,"INSERT INTO training_days (days) VALUES ('$days')");
			$sql2 = mysqli_query($link,"SELECT * FROM training_days ");
			$i = 0;
			while($fetch = mysqli_fetch_assoc($sql2)){
				$res[$i]["id"] = $fetch['id'];
				$res[$i]["days"] = $fetch['days'];
				$i++;
			}
			if($sql){
				$ret += ["statusCode" => 201, "message" => "Успешно создана", "data" => $res ];
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