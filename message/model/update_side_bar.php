<?php 
require('../../dbconnect.php');
session_start();

// error_log(print_r('update_side_bar.php',true),"3","../../../../../../logs/error_log");

$user_id = $_SESSION['login_user']['id'] ;
// $other_id = $_GET['other_id'];
error_log(print_r($user_id,true),"3","../../../../../../logs/error_log");


$sql = 'SELECT
		 x.user_id AS "user_id",
		 x.user_name AS "user_name",
		 x.other_id AS "other_id",
		 batch_users.username AS "other_name",
		 batch_users.image AS "other_image",
		 x.time AS "time"
		 FROM ( 
		 	SELECT 
		 	message.user_id AS "user_id",
		 	message.other_id AS "other_id",
		 	batch_users.username AS "user_name",
         	MAX(message.created_at) AS "time"
		 	FROM message 
		 	JOIN batch_users 
		 	ON message.user_id = batch_users.id
         	WHERE message.user_id = ?
			GROUP BY message.other_id DESC
		 ) x 
		 JOIN batch_users 
		 ON x.other_id = batch_users.id
         ORDER BY time DESC
		;';
$data = [$user_id];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
while (true) {
	$record = $stmt->fetch(PDO::FETCH_ASSOC);
	// error_log(print_r($record,true),"3","../../../../../logs/error_log");
	if ($record == false) {
		break;
	}
	//時間表記変更
	foreach ($record as $key => $value) {
		if ($key =='time') {
			// トーク時間取得(例:2017-11-21 10:19:58)
			$inputDate = $value;
			$year = substr($inputDate,0,4);
			$month = substr($inputDate,5,2);
			$day = substr($inputDate,8,2);
			$time = substr($inputDate,11,5);
			$talk_day = $year.'/'.$month.'/'.$day;
			// error_log(print_r($talk_day,true),"3","../../../../../logs/error_log");

			//今日の日付を取得
			$today = date("Y/m/d");
	

			//日付オブジェクトを作成
			$today_time = new DateTime($today);
			$talk_day_time = new DateTime($talk_day);
			 
			$diff = $today_time->diff($talk_day_time);
			
			//トーク時間と現在の時間の差を取得 
			$date_difference = (int)$diff->d;


			//日付のパターン別
			//1.当日の場合、日付のみ表示
			if ($date_difference== 0) {
				$record['time'] = $time;
			}
			//2.昨日の場合、yesterdayを表示
			elseif ($date_difference== 1) {
				$record['time'] = 'yesterday';
			}
			//3.一週間以内の場合、曜日(英語表記)で表示
			elseif (1<$date_difference && $date_difference<=6) {
				$date = $talk_day;
				$datetime = new DateTime($date);
				$week = ["Sun.", "Mon.", "Tue.", "Wed.", "Thu.", "Fri.", "Sat."];
				$w = (int)$datetime->format('w');
				$week = $week[$w];
				$record['time'] = $week;
				// error_log(print_r($week,true),"3","../../../../../logs/error_log");
			}
			//4.上記以外の場合、yyyy/mm/ddで表記
			else{
				$record['time'] = $talk_day;
			}
		}
	}
	$talking_user[] =$record;	
}
foreach ($talking_user as $user) {
	$inputValue[] = '<div class="tom" id="talk_history" value="'.$user['other_id'].'" ><img src="../image/'.$user['other_image'].'  " alt="icon" id="mes_icon"><p id="his_name">'.$user['other_name'].'</p><p id="his_time">'.$user['time'].'</p></div>';
} 




$inputValue = implode('',$inputValue);

$output_data = json_encode($inputValue);
echo $output_data;





