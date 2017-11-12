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


error_log(print_r($_GET,true),"3","../../../../../logs/error_log");


//ファイルを指定のディレクトリへ移動
	//画像ファイル名を変更する必要？
	//同じファイルがアップされた場合の対策
	// └ ファイルの前にユーザー名と番号を振るか。
	// if ($_GET['mode']=="3") {
	//ファイルのアップロードチェック

//(疑問)以下のif文内でechoがmain.jsに反映されない
//      if文外で実行するとechoがmain.jsの返り値として出力
if (isset($_FILES['image_uplode']['tmp_name'])) {
	error_log(print_r('success',true),"3","../../../../../logs/error_log");
	$fileName = $_FILES['image_uplode']['name'];

	//画像ファイルチェック
	//(To Do)エラーに応じたメッセージ
	if (!empty($fileName)) {
			// 後ろから3文字、文字を抜き出す
			$ext = substr($fileName,-3);
			// アルファベットを全て小文字にする
			$ext = strtolower($ext);
			// echo "拡張子は".$ext."です<br>";

			if ($ext != 'jpg' && $ext != 'png' && $ext != 'gif') {
				//ここに入れば、拡張子が[jpg,png,gif]以外である
				$errors['profile_image'] = 'extension';
			}
	}else{
		//画像を選択しなかった場合
		$errors['profile_image'] = 'blank';
	}

	// エラーが無い場合のみ
	// ①画像ファイルを指定のディレクトリへ移動
	// ②データベースへ反映
	if (empty($errors)) {
		// ①画像ファイルを指定のディレクトリへ移動
		$sample = $_FILES['image_uplode']['tmp_name'];
		$imageName = $_FILES['image_uplode']['name'];

		//指定のディレクトリに画像ファイルを移動
		move_uploaded_file($sample, 'image_uplode/'.$imageName);

	}
}else{
	$user_data = array_keys($_GET);
	//main.jsから取得したユーザーデータのオブジェクト
	$userData = json_decode($user_data[0]);
	// error_log(print_r($userData,true),"3","../../../../../logs/error_log");

	$user_id = $userData->user_id;
	$user_name = $userData->user_name;
	$other_id = $userData->other_id;
	$other_name = $userData->other_name;
	$content = $userData->content;
	$uplode_image = mb_substr($userData->uplode_image,12);

	// error_log(print_r($uplode_image,true),"3","../../../../../logs/error_log");


	// $sql = 'INSERT INTO `message` SET `user_id`=?,
	// 									  `other_id`=?, 
	// 							          `content`=?, 
	// 							          `uplode_image`=?, 
	// 							          `created_at`=NOW()';

	// $data = [$user_id,$other_id,$content,$uplode_image];

	// $stmt = $dbh->prepare($sql);
	// $result = $stmt->execute($data);

	$input_data = "<img src=image_uplode/".$uplode_image." class='image_uplode' style='width: 100px;'>";
	error_log(print_r($input_data,true),"3","../../../../../logs/error_log");
	echo $input_data;

}



//データベース切断
$dbh = null;



