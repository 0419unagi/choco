<?php 
// データベース呼び出し
require('dbconnect.php');

//仮想的にSESSIONからユーザー取得
//	想定：$user_id = $_SESSION['id'] ;
$user_id = 1 ; //ユーザー名：takuya
$other_id = 2; //ユーザー名：sample

//初期値の設定
$user = '';
$message = '';
$record = [
	'user' => '',
	'message' =>''
];
$inputValue = [];

//main.jsに情報を渡すためのクエリを作成
$sql = 'SELECT
		 x.user_id AS "user_id",
		 NAME AS "user_name",
		 x.other_id AS "other_id",
		 batch_users.username AS "other_name"
		 FROM ( 
		 	SELECT 
		 	message.user_id AS "user_id",
		 	message.other_id AS "other_id",
		 	batch_users.username AS "NAME"
		 	FROM message 
		 	JOIN batch_users 
		 	ON message.user_id = batch_users.id 
		 	WHERE message.user_id = ? 
		 	AND message.other_id = ?
		 ) x 
		 JOIN batch_users 
		 ON x.other_id = batch_users.id
		;';
$data = [$user_id,$other_id];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$user_info = $stmt->fetch(PDO::FETCH_ASSOC);

// echo "<pre>";
// var_dump($user_info);



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


	error_log(print_r($inputValue,true),"3","../../../../../logs/error_log");
}

// echo "<pre>";
// var_dump($user_info);
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
				<p id="his_name"><?php echo $user_info['other_name']; ?></p>
				
				<p id="his_time">15:00</p>
			</div>
			

		</div>

		<div class="content">
			<!-- トーク中のユーザー名表示 -->
			<div id="mes_head">
				<?php echo $user_info['other_name']; ?>
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

				<!-- テキスト内容 -->
				<form id="foo" method="GET" action="message.php">
					<div id="image" >
						<input type="file" name="image_uplode" id="file" style="display:none;" onchange="img_up()">
						<img src="../assets/img/img_up.png" id="uplode_image" name="image_uplode" value="" onClick="$('#file').click();">
					</div>
					<div id="textbox" >
						<!-- 隠しデータで配列を送信する -->
						<?php if (!empty($user_info)): ?>
							<?php foreach ($user_info as $k => $v) { ?>
								<input type="hidden" id="<?php echo $k ?>" value="<?php echo $v ?>">
							<?php } ?>
						<?php endif ; ?>
							
						<!-- 下記は仮ユーザー -->
						<!-- 下記のvalueについて確認 -->
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
</html> -->