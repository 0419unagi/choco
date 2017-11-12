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
$inputValue = [];

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
		) x
		JOIN batch_users 
		ON x.other_id = batch_users.id
		WHERE batch_users.username  = "sample";';
$data = [];
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

	$user_info[] = $record;

	//(To DO)
	// 以下のinputValueの配列に入れる作業を、画像とテキストに応じて別ける
	// 'NULL'の方を表示しない
	//データベースから取得したデータを以下のフォーマットにする
	if ($record['content'] !== 'NULL') {
		$inputValue[] = "<div class='left_balloon'>".$record['content']."</div>";	
	}else{
		$inputValue[] = "<img src=image_uplode/".$record['uplode_image']." class='left_img_uplode'>";
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
				<p id="his_name">SAM</p>
				
				<p id="his_time">15:00</p>
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

				<!-- テキスト内容 -->
				<form id="foo" method="GET" action="message.php">
					<div id="image" >
						<input type="file" name="image_uplode" id="file" style="display:none;" onchange="img_up()">
						<img src="../assets/img/img_up.png" id="uplode_image" name="image_uplode" value="" onClick="$('#file').click();">
					</div>
					<div id="textbox" >
						<!-- 隠しデータで配列を送信する -->
						<?php if (!empty($user_info)): ?>
							<?php foreach ($user_info as $value) { ?>
								<?php foreach ($value as $k => $v) { ?>
									<input type="hidden" id="<?php echo $k ?>" value="<?php echo $v ?>">
								<?php } ?>
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