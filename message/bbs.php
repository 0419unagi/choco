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

$record = [
	'user_name' => '',
	'content' =>''
];

// error_log(print_r($_FILES,true),"3","../../../../../logs/error_log");

//ファイルを指定のディレクトリへ移動
	//画像ファイル名を変更する必要？
	//同じファイルがアップされた場合の対策
	// └ ファイルの前にユーザー名と番号を振るか。
	// if ($_GET['mode']=="3") {
	//ファイルのアップロードチェック
if (isset($_FILES['image_uplode']['tmp_name'])) {
	$fileName = $_FILES['image_uplode']['name'];
	//画像ファイルチェック
	//(To Do)エラーに応じたメッセージ
	if (!empty($fileName)) {
			// 後ろから3文字、文字を抜き出す
			$ext = substr($fileName,-3);
			// アルファベットを全て小文字にする
			$ext = strtolower($ext);
			echo "拡張子は".$ext."です<br>";

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
		error_log(print_r($_FILES,true),"3","../../../../../logs/error_log");
		move_uploaded_file($sample, 'image_uplode/1_'.$_FILES['image_uplode']['name']);

		// ②データベースへ反映
		//main.jsから取得した配列をそれぞれの変数へ格納
		$user_id = $_GET['user_id'];
		$user_name = $_GET['user_name'];
		$other_id = $_GET['other_id'];
		$other_name = $_GET['user_name'];
		$content = $_GET['content'];
		$uplode_image = $_FILES['image_uplode']['name'];

		//データベースから取得したデータを以下のフォーマットにする
		$input_data = "<img src=image_uplode/".$_FILES['image_uplode']['name']."class='image_uplode' style='width: 100px;'>";
	 
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
		error_log(print_r($input_data,true),"3","../../../../../logs/error_log");

		echo $input_data;



		// ③画像をトークへ反映


	}
}	
// }


//テキストの場合
//インサート文作成
//mode = 0 の場合にcreatを実行
if ($_GET['mode']=="0") {
	//main.jsから取得した配列をそれぞれの変数へ格納
	$user_id = $_GET['user_id'];
	$user_name = $_GET['user_name'];
	$other_id = $_GET['other_id'];
	$other_name = $_GET['user_name'];
	$content = $_GET['content'];

	//ファイル名を取得する際に、不要な文字列が付くので、削除
	//(再考)ファイルパスを指定
	$uplode_image = mb_substr($_GET['uplode_image'],12);
	// $img_path = 


	//データベースから取得したデータを以下のフォーマットにする
	$input_data = "<div class='left_balloon'>".$content."</div>";

 
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
// error_log(print_r($sample,true),"3","../../../../../logs/error_log");
}


//データベース切断
$dbh = null;



