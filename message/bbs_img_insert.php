<?php 
//データベースの読み込み
require('dbconnect.php');
	
//初期値の設定
$user_id = '';
$user_name = '';
$other_id = '';
$other_name ='';
$content = '';
$uplode_image = null;
$errors = [];
$input_data = "";

$record = [
	'user_name' => '',
	'content' =>''
];


// error_log(print_r($_GET,true),"3","../../../../../logs/error_log");


//ファイルを指定のディレクトリへ移動
$user_data = array_keys($_GET);
//main.jsから取得したユーザーデータのオブジェクト
$userData = json_decode($user_data[0]);

$user_id = $userData->user_id;
$user_name = $userData->user_name;
$other_id = $userData->other_id;
$other_name = $userData->other_name;
$content = $userData->content;
$uplode_image = mb_substr($userData->uplode_image,12);
// error_log(print_r($uplode_image,true),"3","../../../../../logs/error_log");

$sql = 'INSERT INTO `message` SET `user_id`=?,
									  `other_id`=?, 
							          `content`=?, 
							          `uplode_image`=?, 
							          `created_at`=NOW()';

$data = [$user_id,$other_id,$content,$uplode_image];
$stmt = $dbh->prepare($sql);
$result = $stmt->execute($data);

$input_data = "<img src=image_uplode/".$uplode_image." class='image_uplode' style='width: 100px;'>";

echo $input_data;


//データベース切断
$dbh = null;



