<?php
//データベースの読み込み
require('../dbconnect.php');
	
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

	

//テキストの場合
//インサート文作成
//mode = 0 の場合にcreatを実行
if ($_GET['mode']=="0") {
	//main.jsから取得した配列をそれぞれの変数へ格納
	$user_id = $_GET['user_id'];
	$other_id = $_GET['other_id'];
	$content = $_GET['content'];
	$uplode_image = 'NULL';

	//ファイル名を取得する際に、不要な文字列が付くので、削除
	//(再考)ファイルパスを指定
	$uplode_image = mb_substr($_GET['uplode_image'],12);
	// error_log(print_r('success',true),"3","../../../../../logs/error_log");


	//データベースから取得したデータを以下のフォーマットにする
	$input_data = "<div class='right_balloon'>".$content."</div>";

 
	$sql = 'INSERT INTO `message` SET `user_id`=?,
									  `other_id`=?, 
							          `content`=?, 
							          `uplode_image`=?, 
							          `created_at`=NOW()';

	$data = [$user_id,$other_id,$content,$uplode_image];
	$stmt = $dbh->prepare($sql);
	$result = $stmt->execute($data);

	echo $input_data;
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

		if ($record == false) {
			break;
		}
		//データベースから取得したデータを以下のフォーマットにする
		$inputValue[] = "<div class='left_balloon'>".$record['content']."</div>";
		
	}
	foreach ($inputValue as  $value) {
		echo $value;
	}
}

//データベース切断
$dbh = null;



