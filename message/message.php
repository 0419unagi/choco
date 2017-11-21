<?php 
require('../part/header.php');
// データベース呼び出し
require('../dbconnect.php');

$user_id = $_SESSION['login_user']['id'] ;
$other_id = '';


// トーク履歴表示パターン
// 1.リロードした時に、最後にみたユーザーとのトーク履歴を表示
// 　└$_SESSION['other_id']を利用
// 2.timeline.phpからトークしたいユーザーを選択
// 　└$_GET['id']を利用
// 3.サイドバーからトークしたいユーザーを選択
// 　└$_SESSION['other_id']を利用
// 4.ヘッダーのmessageボタンから来た場合、サイドバーの一番上のユーザーを表示

// 問題
// 1.timeline.phpからトークしたいユーザーを選択し、リロードするとURLのgetのIDが表示
//   





//timeline.phpでトークしたいユーザーを選択した場合に、そのユーザーとのトーク履歴を表示する 
if (isset($_GET['id'])) {
	// $other_id = $_GET['id'];
	//timeline.phpからユーザー選択された場合、そのユーザーのIDだけセッションに保存。
	//そして、URLに記載されているIDを削除
	$_SESSION['other_id'] = $_GET['id'];
	//URLのGETパラメータを削除
	header('Location:message.php');
	exit();
	error_log(print_r($_GET['id'],true),"3","../../../../../logs/error_log");
}
// else{
// 	//$_GET['id']の値が存在しない場合、
// 	//サイドバーの一番上のユーザーとのトーク履歴を表示するクエリを発行する。	
// 	$sql = 'SELECT 
// 		 	message.user_id AS "user_id",
// 		 	message.other_id AS "other_id",
// 		 	MAX(message.created_at) AS "time"
// 		 	FROM message 
// 		 	JOIN batch_users 
// 		 	ON message.user_id = batch_users.id
//          	WHERE message.user_id = ?
// 			GROUP BY message.other_id 
// 		  ';

// 	$data = [$user_id];
// 	$stmt = $dbh->prepare($sql);
// 	$stmt->execute($data);
// 	$record = $stmt->fetch(PDO::FETCH_ASSOC);
// 	$_SESSION['other_id'] = $record['other_id'];
// 	// error_log(print_r($other_id,true),"3","../../../../../logs/error_log");
// 	}


//サイドバーから選択したユーザーのIDを取得
//　main.jsからgetリクエストでoter_idを取得する
if (isset($_GET['other_id'])) {
	$_SESSION['other_id'] = $_GET['other_id'];
	// echo $_SESSION['other_id'];
	// $other_id = $_SESSION['other_id'];
}

//リロードした時に、現在見ているユーザーとのトーク履歴を表示
if (isset($_SESSION['other_id'])) {
	$other_id = $_SESSION['other_id'];
}



 // error_log(print_r($other_id,true),"3","../../../../../logs/error_log");


//初期値の設定
$record = [
	'user' => '',
	'message' =>''
];
$inputValue = [];

//ユーザーデータ読み出し
require('model/selectUser.php');
 ?>

<link rel="stylesheet" type="text/css" href="../assets/css/custom.css">
<script src="../assets/js/jquery-2.1.4.min.js"></script>
<script src="../assets/js/main.js"></script>
<script src="../assets/js/dist/jquery.searcher.js"></script>


<div class="container">
	<div class="contents">
		<div class="sidebar">
			<!-- 検索欄 -->
			<div id="search">
				<i class="fa fa-search" aria-hidden="true" id="search_icon"></i>
				<input type="search" name="mes_search"  id="mes_search" placeholder="Search Message">
			</div>
			<!-- Search Message検索フォームのアンダーバー	 -->
			<div id="bar"></div>
			<!-- ユーザー履歴一覧 -->
			<div class="user_list" id="user_list">
				<?php foreach ($talking_user as $user) { ?>
					<div class="tom" id="talk_history" value="<?php echo $user['other_id']; ?>" >
						<img src="../image/<?php echo $user['other_image'] ?>" alt="icon" id="mes_icon">
						<p id="his_name"><?php echo $user['other_name']; ?></p>
						<p id="his_time"><?php echo $user['time']; ?></p>
					</div>
				<?php } ?>
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
			<div id="mes_footer">
				<!-- イメージ図選択ボタン		 -->
				<form id="foo" action="bbs.php" method="GET">
					<div id="image" >
						<input type="file" name="image_uplode" id="file" style="display:none;" onchange="img_up()">
						<img src="../assets/img/img_up.png" id="uplode_image" name="image_uplode" value="" onClick="$('#file').click();">
					</div>

					<!-- テキスト内容 -->
 					<div id="textbox" >
						<!-- 隠しデータで配列を送信する -->
						<?php if (!empty($user_info)): ?>
							<?php foreach ($user_info as $k => $v) { ?>
									<input type="hidden" class="ins" id="<?php echo $k ?>" value="<?php echo $v ?>">
							<?php } ?>
						<?php endif ; ?>
						<input type="text" name="message" id="text_input">
					</div>

					<!-- 送信ボタン -->
					<div id="push" >
<!-- 						<img src="../assets/img/post.png" id="submit" onClick="$('#submit').click();"> -->

						<!-- 下記コード、保留 -->
						<!-- <img src="../assets/img/post.png" id="submit"> -->
						<input type="image" src="../assets/img/post.png" id="submit" >
					</div>	
				</form>	
			</div>
		</div>
	</div>
</div>

	
	
</body>
</html> 