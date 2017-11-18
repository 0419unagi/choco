<?php 
require('../dbconnect.php');
session_start();

error_log(print_r('updat.php',true),"3","../../../../../../logs/error_log");


$user_id = $_SESSION['user_id'];
// $other_id = $_GET['other_id'];

// $sql = 'SELECT
// 		 x.user_id AS "user_id",
// 		 x.user_name AS "user_name",
// 		 x.other_id AS "other_id",
// 		 batch_users.username AS "other_name",
// 		 x.time AS "time"
// 		 FROM ( 
// 		 	SELECT 
// 		 	message.user_id AS "user_id",
// 		 	message.other_id AS "other_id",
// 		 	batch_users.username AS "user_name",
//          	MAX(message.created_at) AS "time"
// 		 	FROM message 
// 		 	JOIN batch_users 
// 		 	ON message.user_id = batch_users.id
//          	WHERE message.user_id = ?
// 			GROUP BY message.other_id DESC
// 		 ) x 
// 		 JOIN batch_users 
// 		 ON x.other_id = batch_users.id
//          ORDER BY time DESC
// 		;';
// $data = [$user_id];
// $stmt = $dbh->prepare($sql);
// $stmt->execute($data);
// while (true) {
// 	$record = $stmt->fetch(PDO::FETCH_ASSOC);
// 	error_log(print_r($record,true),"3","../../../../../logs/error_log");
// 	if ($record == false) {
// 		break;
// 	}
// 	//時間表記変更
// 	foreach ($record as $key => $value) {
// 		if ($key =='time') {
// 			error_log(print_r($value,true),"3","../../../../../logs/error_log");
// 			$time = $value;
// 			$month = substr($time,5,2);
// 			$day = substr($time,8,2);
// 			$time1 = substr($time,11,5);
// 			$time_final = $month.'/'.$day.' '.$time1;
// 			$record['time'] = $time_final;
// 		}
// 	}
// 	$talking_user[] =$record;	
// }


$sample = 
'<div class="user_list">
<div class="tom" id="talk_history" value="<?php echo $user['other_id']; ?>" >
<img src="../assets/img/icon.png" alt="icon" id="mes_icon">
<p id="his_name"><?php  echo $user['other_name']; ?></p>
<p id="his_time"><?php echo $user['time']; ?></p>
</div>
</div>' ;




// $test = implode('',$inputValue);


// $usre_name = $record;

// $output_data = json_encode($inputValue);
// echo $output_data;





