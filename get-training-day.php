<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	header("Access-Control-Allow-Methods: GET, POST");

	include_once 'config.php';
	$sql = mysqli_query($link,"SELECT * FROM training_days");
	if($sql){
		$i = 0;
		while($fetch = mysqli_fetch_assoc($sql)){
			$ret[$i]["id"] = $fetch['id'];
			$ret[$i]["days"] = $fetch['days'];
			$i++;
		}
	}
	else{
		$ret += ["statusCode" => 400, "message" => "Нет данных", "data"=> $fetch ];
	}
	echo json_encode($ret);
?>