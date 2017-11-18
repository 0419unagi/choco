<?php 
require('../../dbconnect.php');
session_start();


$user_id = $_SESSION['login_user']['id'];
$other_id = $_GET['other_id'];
	// error_log(print_r($user_id,true),"3","../../../../../../logs/error_log");

$query = 'SELECT `id`,`username` FROM `batch_users` WHERE `id` = ?';
$data = [$other_id];
$stmt = $dbh->prepare($query);
$stmt->execute($data);
$res = $stmt->fetch(PDO::FETCH_ASSOC);
// error_log(print_r('sample',true),"3","../../../../../../logs/error_log");

$other_name = $res['username'];



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
	// error_log(print_r($record,true),"3","../../../../../../logs/error_log");

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
	
}
$inputValue[] = $other_name;

// $inputValue =['aaa','bbb'];
error_log(print_r($inputValue,true),"3","../../../../../../logs/error_log");
$test = implode('',$inputValue);


$usre_name = $record;

$output_data = json_encode($inputValue);
	echo $output_data;


