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

$record = [
	'user_name' => '',
	'content' =>''
];

	$sample = $_FILES['image_uplode']['tmp_name'];
	move_uploaded_file($sample, 'image_uplode/1_'.$_FILES['image_uplode']['name']);


//インサート文作成
//mode = 0 の場合にcreatを実行
if ($_GET['mode']=="0") {
	//main.jsから取得した配列をそれぞれの変数へ格納
	// error_log(print_r($_GET,true),"3","../../../../../logs/error_log");


	
	$user_id = $_GET['user_id'];
	$user_name = $_GET['user_name'];
	$other_id = $_GET['other_id'];
	$other_name = $_GET['user_name'];
	$content = $_GET['content'];
	$sample = $_FILES['image_uplode']['tmp_name'];


	// error_log(print_r($sample,true),"3","../../../../../logs/error_log");

	//ファイル名を取得する際に、不要な文字列が付くので、削除
	$uplode_image = mb_substr($_GET['uplode_image'],12);
	// ファイルを指定の場所へ移動
	var_dump($sample, 'image_uplode/'.$user_id.'_'.$_FILES);exit;
	move_uploaded_file($sample, 'image_uplode/'.$user_id.'_'.$_FILES['image_uplode']['name']);

	error_log(print_r('^^^^^^^^^^^^^^^^^^^ <br>',true),"3","../../../../../logs/error_log");

	error_log(print_r($result,true),"3","../../../../../logs/error_log");



	//データベースから取得したデータを以下のフォーマットにする
	$input_data = "<div class='left_balloon'>".$content."</div>";

	// var_dump($input_data."<br>");

	// error_log(print_r($input_data,true),"3","../../../../../logs/error_log");

 
	$sql = 'INSERT INTO `message` SET `user_id`=?,
									  `other_id`=?, 
							          `content`=?, 
							          `uplode_image`=?, 
							          `created_at`=NOW()';

	$data = [$user_id,$other_id,$content,$uplode_image];
	// error_log(print_r($data,true),"3","../../../../../logs/error_log");

	$stmt = $dbh->prepare($sql);
	$result = $stmt->execute($data);
	// error_log(print_r('success',true),"3","../../../../../logs/error_log");
	// error_log(print_r($result,true),"3","../../../../../logs/error_log");
	echo $input_data;

}


function image_uplode(){
	// move_upload_file(設定1,設定2)関数;



}


//読み込み処理作成
//mode = 1 の場合にreadを実行
if ($_GET['mode']=="1") {
	$sql = 'SELECT * FROM `content` ORDER BY created_at;';
	$data = [];
	$stmt = $dbh->prepare($sql);
	$stmt->execute($data);

	// セレクト文で実行した結果を取得する
	while (true) {
		$record = $stmt->fetch(PDO::FETCH_ASSOC);

		//デバッグ
		// error_log(print_r($record,true),"3","../../../logs/debug.log");

		if ($record == false) {
			break;
		}

		//データベースから取得したデータを以下のフォーマットにする
		$inputValue[] = "<div class='left_balloon'>".$record['content']."</div>";
		

		// error_log(print_r($inputValue,true),"3","../../../logs/debug.log");
	}

	foreach ($inputValue as  $value) {
		echo $value;
	}

}
