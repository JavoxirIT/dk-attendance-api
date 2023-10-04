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
			$i = 0;
			$party_name = $arr->party_name;
			$sql = mysqli_query($link,"INSERT INTO party (party_name) VALUES ('$party_name')");
			$sql = mysqli_query($link,"SELECT * FROM party ");
			$i = 0;
			while($fetch = mysqli_fetch_assoc($sql)){
				$res[$i]["id"] = $fetch['id'];
				$res[$i]["group_name"] = $fetch['party_name'];
				$i++;
			}
			if($sql){
				$ret += ["statusCode" => 200, "message" => "Новая группа создана", "data" => $res ];
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