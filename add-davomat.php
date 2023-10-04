<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	header("Access-Control-Allow-Methods: POST, GET, DELETE, UPDATE, OPTIONS");

	include_once 'config.php';
	$data = file_get_contents("php://input");
	$ret = [];
	$arr = json_decode($data);
	$token = filter($arr->token);
	$sql = mysqli_query($link,"SELECT * FROM user WHERE token='$token'");	
	$fetch = mysqli_fetch_assoc($sql);
	if($fetch['id']>0 and time()-$fetch['tokentime']<86400){
		$sana = strtotime($arr->date);
		$day = date("d.m.Y", $sana);
		$sql = mysqli_query($link,"SELECT * FROM davomat WHERE day='$day'");
		$fetch = mysqli_fetch_assoc($sql);
		if($fetch['id']>0){
			$davomat_id = $fetch['id'];
		}
		else{
			$sql = mysqli_query($link,"INSERT INTO davomat (sana,day) VALUES ('$sana','$day')");
			$sql = mysqli_query($link,"SELECT * FROM davomat WHERE day='$day'");
			$fetch = mysqli_fetch_assoc($sql);
			$davomat_id = $fetch['id'];
		}
		unset($arr->date);
		unset($arr->token);
		foreach ($arr as $key => $value) {
			if($value === true){
				$status = 1;
			}
			else{
				$status = 0;
			}
			$worker_id = $key;
			$sql = mysqli_query($link,"SELECT * FROM yuqlama WHERE worker_id='$worker_id' AND davomat_id='$davomat_id'");
			$fetch = mysqli_fetch_assoc($sql);
			if($fetch['id']>0){

			}
			else{
				$sql = mysqli_query($link,"INSERT INTO yuqlama (davomat_id,worker_id,status) VALUES ('$davomat_id','$worker_id','$status')");	
			}			
		}		
		if($sql){
			$ret += ["error" => 0, "xabar" => "Muvaffaqqiyatli saqlandi"];
		}
		else{
			$ret += ["error" => 1, "xabar" => "Saqlanmadi ma'lumotlarda kamchilik bor"];
		}
	}
	else{
		$ret += ["error" => 1, "xabar" => "Kechirasiz token vaqti tugatilgan!!", "token" => $token];
	}

	echo json_encode($ret);
?>