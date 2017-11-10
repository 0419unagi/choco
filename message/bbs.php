<?php
//データベースの読み込み
require('dbconnect.php');

//初期値の設定
$user = '';
$message = '';
$record = [
	'user' => '',
	'message' =>''
];




//インサート文作成
//mode = 0 の場合にcreatを実行
if ($_GET['mode']=="0") {
	//main.jsから取得した配列をそれぞれの変数へ格納
	// error_log(print_r($_GET,true),"3","../../../../../logs/error_log");
	$user = $_GET['user'];
	$message = $_GET['message'];
	//データベースから取得したデータを以下のフォーマットにする
	$input_data = "<div class='left_balloon'>".$message."</div>";

	// var_dump($input_data."<br>");

	// error_log(print_r($input_data,true),"3","../../../../../logs/error_log");

 
	$sql = 'INSERT INTO `message` SET `user`=?,
							          `message`=?, 
							          `created_at`=NOW()';

	$data = [$user,$message];
	error_log(print_r($data,true),"3","../../../../../logs/error_log");

	$stmt = $dbh->prepare($sql);
	$result = $stmt->execute($data);
	// error_log(print_r('success',true),"3","../../../../../logs/error_log");
	// error_log(print_r($result,true),"3","../../../../../logs/error_log");
	echo $input_data;



}


//読み込み処理作成
//mode = 1 の場合にreadを実行
if ($_GET['mode']=="1") {
	$sql = 'SELECT * FROM `message` ORDER BY created_at;';
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
		$inputValue[] = "<div class='left_balloon'>".$record['message']."</div>";
		

		// error_log(print_r($inputValue,true),"3","../../../logs/debug.log");
	}

	foreach ($inputValue as  $value) {
		echo $value;
	}

}
