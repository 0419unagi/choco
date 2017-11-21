<?php 


//サイドバーにトーク中のユーザーを表示
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


//トーク履歴を表示するためのクエリ
$sql = 'SELECT
		 x.user_id AS "user_id",
		 NAME AS "user_name",
		 x.other_id AS "other_id",
		 batch_users.username AS "other_name",
		 CONTENT AS "content",
		 x.uplode_image AS "uplode_image"
		 FROM ( 
		 	SELECT 
		 	message.user_id AS "user_id",
		 	message.other_id AS "other_id",
		 	batch_users.username AS "NAME",
		 	message.content AS "CONTENT",
		 	message.uplode_image AS"uplode_image" 
		 	FROM message 
		 	JOIN batch_users 
		 	ON message.user_id = batch_users.id 
		 	WHERE (
		 			message.user_id = ? 
		 			AND message.other_id = ?
		 		  ) 
		 	OR (
		 			message.user_id = ? 
		 			AND message.other_id = ?
		 		  )
		 ) x 
		 JOIN batch_users 
		 ON x.other_id = batch_users.id
		;';
			
$data = [$user_id,$other_id,$other_id,$user_id];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

// データベース切断
$dbh = null;



// セレクト文で実行した結果を取得する
while (true) {
	$record = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($record == false) {
		break;
	}

	// 投稿は画像かコメントか
	if ($record['content'] !== 'NULL') {	
		//投稿はログインユーザーかチェック
		if ($user_id == $record['user_id']) {
			$inputValue[] = "<div class='right_balloon'>".$record['content']."</div>";		
		}else{
			$inputValue[] = "<div class='left_balloon'>".$record['content']."</div>";		
		}
	}else{
		//投稿はログインユーザーかチェック
		if ($user_id == $record['user_id']) {
			$inputValue[] = "<img src=image_uplode/".$record['uplode_image']." class='right_img_uplode'>";		
		}else{
			$inputValue[] = "<img src=image_uplode/".$record['uplode_image']." class='left_img_uplode'>";
		}
	}


	// error_log(print_r($inputValue,true),"3","../../../../../logs/error_log");
}

