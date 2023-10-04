<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	header("Access-Control-Allow-Methods: POST, GET, DELETE, UPDATE, OPTIONS");
	
	include_once 'config.php';
	$data = file_get_contents("php://input");
	$ret = [];
	$sql = mysqli_query($link,"SELECT * FROM party ");
	
	if($sql){
		$i = 0;
		while($fetch = mysqli_fetch_assoc($sql)){
			$ret[$i]["id"] = $fetch['id'];
			$ret[$i]["group_name"] = $fetch['party_name'];
			$i++;
		}
	}
	else{
		$ret += ["statusCode" => 400, "message" => "Нет данных", "data"=> $fetch ];
	}
	echo json_encode($ret);
?>