<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	header("Access-Control-Allow-Methods: POST, GET, DELETE, UPDATE, OPTIONS");
	
	
	include_once 'config.php';
	$data = file_get_contents("php://input");
	$ret = [];
	$arr = json_decode($data);
	$kun = intval($arr->authDate[8].$arr->authDate[9]);
	$oy = intval($arr->authDate[5].$arr->authDate[6]);
	$yil = intval($arr->authDate[0].$arr->authDate[1].$arr->authDate[2].$arr->authDate[3]);
	$authtime = $arr->authTime;
	$authDate = $arr->authDate;
	$personId = $arr->personId;
	

	if($personId>0){
		$sql3 = mysqli_query($link,"SELECT * FROM visit WHERE user_id='$personId' AND yil='$yil' AND oy='$oy'");
			$fetch3 = mysqli_fetch_assoc($sql3);
			$k = "d".$kun;
			$time = $authtime;
			$arr2 = ['vaqt' => $time];
			$json = json_encode($arr2);
			if($fetch3['id']>0){										
				// $id = $fetch['id'];	

				if($fetch3[$k]==""){
					$id = $fetch3['id'];
					$sql4 = mysqli_query($link,"UPDATE visit SET $k='$json' WHERE id='$id'");

					if($sql4){
						$ret += ["statusCode" => 201, "message" => "Время прихода учиника отмечена"];
					}
					else{
						$ret += ["statusCode" => 400, "message" => "Какие-то проблемы ..("];
					}
				}
				else{
					$jsar = json_decode($fetch3[$k]);
					$jsar = (array) $jsar;
					if(count($jsar)!=2){
						$jsar += ['vaqt2' => $time];
						$id = $fetch3['id'];
						$json = json_encode($jsar);
						$sql5 = mysqli_query($link, "UPDATE visit SET $k='$json' WHERE id='$id'");
						if($sql5){
							$ret += ["statusCode" => 201, "message" => "Время ухода учиника отмечена"];
						}
						else{
							$ret += ["statusCode" => 400, "message" => "Какие-то проблемы ..("];
						}
					}
				}					
			}
			else{
				$sql4 = mysqli_query($link,"INSERT INTO visit ($k,oy,yil,user_id) VALUES ('$json','$oy','$yil','$personId')");
			}
	}
	else{
		$ret += ["statusCode" => 400, "message" => "Нет данных"];
	}

	echo json_encode($ret);
?>