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
		$array = array();
		$i = 0;
		$oy_id = $arr->oy_id;
		$yil_id = $arr->yil_id;
		$sql = mysqli_query($link,"SELECT * FROM visit WHERE yil='$yil_id' AND oy='$oy_id'");

		$sqll = mysqli_query($link,"SELECT d1,d2,d3,d4,d5,d6,d7,d8,d9,d10,d11,d12,d13,d14,d15,d16,d17,d18,d19,d20,d21,d22,d23,d24,d25,d26,d27,d28,d29,d30,d31 FROM visit WHERE yil='$yil_id' AND oy='$oy_id'");
		$fetchs = mysqli_fetch_assoc($sqll);
		
		while ($fetch = mysqli_fetch_assoc($sql)) {		
			$studet_id = $fetch['user_id'];
			$sql2 = mysqli_query($link,"SELECT * FROM student WHERE id='$studet_id'");
			$fetch2 = mysqli_fetch_assoc($sql2);
			$array[$i]['user_id'] = $fetch['user_id'];
			$array[$i]['username'] = $fetch2['fio'];
			$array[$i]['yil'] = $fetch['yil'];
			$array[$i]['oy'] = $fetch['oy'];
			unset($fetch['yil']);
			unset($fetch['oy']);
			$array[$i]['data'] = $fetchs;
			// $array[$i]['data2'] = $fetchs;
			$i++;
		}
		$ret['data'] = $array;
	}
	else{
		$ret += ["statusCode" => 400, "message" => "Нет данных"];
	}

	echo json_encode($ret);
?>