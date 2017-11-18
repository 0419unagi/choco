<?php
//データベースの読み込み
require('dbconnect.php');
	

//サイドバーにトーク中のユーザーを表示
$sql = 'SELECT
		 x.user_id AS "user_id",
		 x.user_name AS "user_name",
		 x.other_id AS "other_id",
		 batch_users.username AS "other_name",
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
	error_log(print_r($record,true),"3","../../../../../logs/error_log");
	if ($record == false) {
		break;
	}
	//時間表記変更
	foreach ($record as $key => $value) {
		if ($key =='time') {
			error_log(print_r($value,true),"3","../../../../../logs/error_log");
			$time = $value;
			$month = substr($time,5,2);
			$day = substr($time,8,2);
			$time1 = substr($time,11,5);
			$time_final = $month.'/'.$day.' '.$time1;
			$record['time'] = $time_final;
		}
	}
	$talking_user[] =$record;	
}



//もしトークが初めての場合に、ログインユーザーと相手ユーザーを呼び出す
	$query_1 = 'SELECT `id`,`username` FROM `batch_users` WHERE `id` = ?';
	$data = [$user_id];
	$stmt = $dbh->prepare($query_1);
	$stmt->execute($data);
	$res_1 = $stmt->fetch(PDO::FETCH_ASSOC);

	// error_log(print_r($other_id,true),"3","../../../../../logs/error_log");


	$query_2 = 'SELECT `id`,`username` FROM `batch_users` WHERE `id` = ?';
	$data = [$other_id];
	$stmt = $dbh->prepare($query_2);
	$stmt->execute($data);
	$res_2 = $stmt->fetch(PDO::FETCH_ASSOC);
	$user_info = [
		'user_id' => $res_1['id'],
		'user_name' => $res_1['username'],		
		'other_id' => $res_2['id'],
		'other_name' => $res_2['username']
	];
// error_log(print_r($user_info,true),"3","../../../../../logs/error_log");


// データベース切断
$dbh = null;





