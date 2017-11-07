<?php 
// データベース呼び出し
require('dbconnect.php');

//初期値の設定
$user = '';
$message = '';
$record = [
	'user' => '',
	'message' =>''
];

// サンプルSQL
// SELECT
// NAME AS "name", 
// CONTENT AS "content",
// x.image AS "image",
// batch_users.username AS "other_name" 
// FROM (
//     SELECT
//     batch_users.username AS "NAME",
//     message.content AS "CONTENT",
//     message.uplode_image AS"image", 
//     message.other_id AS other_id 
//     FROM message
//     JOIN batch_users 
//     ON message.user_id = batch_users.id 
// ) x
// JOIN batch_users 
// ON x.other_id = batch_users.id;

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

 ?>

<?php require('../part/header.php'); ?>
<script src="../assets/js/jquery-2.1.4.min.js"></script>
<script src="../assets/js/main.js"></script>

<div class="container">
	<div class="header">
			
	</div>

	<div class="contents">
		<div class="sidebar">
			<!-- 検索欄 -->
			<div id="search">
				<i class="fa fa-search" aria-hidden="true" id="search_icon"></i>
				<input type="search" name="mes_search"  id="mes_search" placeholder="Search Message">
			</div>
			<!-- 下記保留 -->
			<div id="bar"></div>

			<!-- ユーザー履歴一覧	 -->
			<div id="talk_history">
				<img src="../assets/img/icon.png" alt="icon" id="mes_icon">
				<p id="his_name">SAM</p>
				
				<p id="his_time">15:00</p>
				<!-- <p id="his_comment">あなた：お疲れ</p> -->
			</div>
			

		</div>

		<div class="content">
			<!-- トーク中のユーザー名表示 -->
			<div id="mes_head">
				Sam
			</div>

			<!-- トーク内容 -->
			<div id="talk_content">
				<div id="talkField">
					<div id="result">
						<?php foreach ($inputValue as  $value) {
							echo $value;
						} ?>
					</div>
					<br class="clear_balloon"/>
					<div id="end"></div>
				</div>

			</div>

			<!-- 入力バー -->
			<!-- 以下検索	 -->
			<div id="mes_footer">
				<!-- イメージ図選択ボタン		 -->
				<!-- <div id="image" >
					<img src="../assets/img/img_up.png" alt="">
				</div> -->

	<!-- <label>画像アップロード</label>
		<input type="file" name="profile_image" accept="image/*">
		<br>
		<?php if (isset($errors['profile_image']) && $errors['profile_image']=='blank') { ?>
			<div class="alert alert-danger">
				プロフィール画像を選択してください
			</div>
		<?php }elseif(isset($errors['profile_image']) && $errors['profile_image']=='extension'){ ?>
			<div class="alert alert-danger">
				アップロード使用できる拡張子は、「jpg」または「png」または「gif」のみです。
			</div>
		<?php } ?>

 -->
				<!-- テキスト内容 -->
				<form method="GET" action="message.php">
					<!-- イメージ図選択ボタン		 -->
					<div id="image" >
						<input type="file" id="file" style="display:none;" onchange="$('#fake_input_file').val($(this).val())">
						<input type="image" src="../assets/img/img_up.png" id="uplode_image" value="ファイル選択" onClick="$('#file').click();">
						<input id="fake_input_file" readonly type="text" value=""  onClick="$('#file').click();">
					</div>



					<div id="textbox" >
						<!-- 下記は仮ユーザー -->
						<input type="hidden" id="user_name" name="user" value="takuya">
						<input type="text" name="message" id="text_input">
					</div>
					
					<!-- 送信ボタン -->
					<div id="push" >
						<input type="image" src="../assets/img/post.png"  id="submit">
					</div>	
				</form>	
		</div>

		</div>
	</div>
</div>

	
	
</body>
</html>