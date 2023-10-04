<?
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: POST, GET, DELETE, UPDATE, OPTIONS");

include_once 'config.php';
$data = file_get_contents("php://input");
$ret = [];
$i = 0;
$arr = json_decode($data);
$user_id = $arr->user_id;
$sql = mysqli_query($link,"SELECT * FROM student WHERE id='$user_id'");	
$fetch = mysqli_fetch_assoc($sql);
if($sql){
	$result = mysqli_query($link,"SELECT distinct stud.*, 
	par.party_name, 
	les.start_time, les.end_time, 
	tra.days as training_days FROM student stud 
	inner join party par on stud.party_id = par.id 
	inner join lesson_time les on les.id = stud.class_time_id 
	inner join training_days tra on tra.id = stud.training_days_id where stud.id = $user_id" 
	);
	$data = $result->fetch_all(MYSQLI_ASSOC);
	$ret = $data;
}
else{
	$ret += ["statusCode" => 400, "message" => "Нет данных", "data"=> $fetch ];
}
echo json_encode($ret);
?>