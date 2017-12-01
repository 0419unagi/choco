<?php 
//データベースの読み込み
require('../dbconnect.php');
	

// //仮想的にSESSIONからユーザー取得
// //	想定：$user_id = $_SESSION['id'] ;
// $user_id = 1 ; //ユーザー名：takuya
// $other_id = 2; //ユーザー名：sample


//初期値の設定
$user_id = '';
$other_id = '';
$content = '';
$uplode_image = null;
$errors = [];
$input_data = "";

$record = [
	'content' =>''
];


// error_log(print_r($_GET,true),"3","../../../../../logs/error_log");

//ファイルを指定のディレクトリへ移動
$user_data = array_keys($_GET);
//main.jsから取得したユーザーデータのオブジェクト
$userData = json_decode($user_data[0]);

$user_id = $userData->user_id;
$other_id = $userData->other_id;
$content = $userData->content;
$uplode_image = changeImgName($userData->uplode_image);

// error_log(print_r($uplode_image,true),"3","../../../../../logs/error_log");	
$sql = 'INSERT INTO `message` SET `user_id`=?,
									  `other_id`=?, 
							          `content`=?, 
							          `uplode_image`=?, 
							          `created_at`=NOW()';

$data = [$user_id,$other_id,$content,$uplode_image];
$stmt = $dbh->prepare($sql);
$result = $stmt->execute($data);

$input_data = "<img src=image_uplode/".$uplode_image." class='right_img_uplode'>";

echo $input_data;

//データベース切断
$dbh = null;


//拡張子の前に着いている'_'を'.'へ変換
function changeImgName($input_data){
	$uplode_image = mb_substr($input_data,12);
	// 拡張子を取得し、拡張子の前に'.'を追加
	$ext = '.'.substr($uplode_image,-3);
	// 拡張子の前にある'_'までを取得
	$cut_ext = substr($uplode_image,-4);
	$com_img = str_replace($cut_ext,$ext,$uplode_image);
	return $com_img;
}


