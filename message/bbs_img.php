<?php 	
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


// error_log(print_r($_FILES,true),"3","../../../../../logs/error_log");

//ファイルを指定のディレクトリへ移動
	//画像ファイル名を変更する必要？
	//同じファイルがアップされた場合の対策
	// └ ファイルの前にユーザー名と番号を振るか。
	//ファイルのアップロードチェック
if (isset($_FILES['image_uplode']['tmp_name'])) {
	// error_log(print_r('success',true),"3","../../../../../logs/error_log");
	$fileName = $_FILES['image_uplode']['name'];

	//画像ファイルチェック
	//(To Do)エラーに応じたメッセージ
	if (!empty($fileName)) {
			// 後ろから3文字、文字を抜き出す
			$ext = substr($fileName,-3);
			// アルファベットを全て小文字にする
			$ext = strtolower($ext);

			if ($ext != 'jpg' && $ext != 'png' && $ext != 'gif') {
				//ここに入れば、拡張子が[jpg,png,gif]以外である
				$errors['profile_image'] = 'extension';
			}
	}else{
		//画像を選択しなかった場合
		$errors['profile_image'] = 'blank';
	}

	// エラーが無い場合のみ
	// 画像ファイルを指定のディレクトリへ移動
	if (empty($errors)) {
		// ①画像ファイルを指定のディレクトリへ移動
		$sample = $_FILES['image_uplode']['tmp_name'];
		$imageName = $_FILES['image_uplode']['name'];

		//指定のディレクトリに画像ファイルを移動
		move_uploaded_file($sample, 'image_uplode/'.$imageName);
	}
}
