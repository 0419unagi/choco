<?php 


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
         	WHERE message.user_id =1
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
	if ($record == false) {
		break;
	}
	$talking_user[] =$record;
}

// echo "<pre>";
// var_dump($talking_user);


//もしトークが初めての場合に、ログインユーザーと相手ユーザーを呼び出す
	$query_1 = 'SELECT `id`,`username` FROM `batch_users` WHERE `id` = ?';
	$data = [$user_id];
	$stmt = $dbh->prepare($query_1);
	$stmt->execute($data);
	$res_1 = $stmt->fetch(PDO::FETCH_ASSOC);

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

