<?php 
require('../part/header.php');
// データベース呼び出し
require('../dbconnect.php');

$user_id = $_SESSION['login_user']['id'] ;
$other_id = '';

//サイドバーでトークしたいユーザーを選択した場合に、そのユーザーとのトーク履歴を表示する 
if (isset($_GET['id'])) {
	$other_id = $_GET['id'];
}

if (isset($_GET['other_id'])) {
	$_SESSION['other_id'] = $_GET['other_id'];
	echo $_SESSION['other_id'];
	$other_id = $_SESSION['other_id'];
}


 // error_log(print_r($user_id,true),"3","../../../../../logs/error_log");



//初期値の設定
$record = [
	'user' => '',
	'message' =>''
];
$inputValue = [];

//ユーザーデータ読み出し
require('model/selectUser.php');
 ?>

<?php  ?>
<link rel="stylesheet" type="text/css" href="../assets/css/custom.css">
<script src="../assets/js/jquery-2.1.4.min.js"></script>
<script src="../assets/js/main.js"></script>
<!-- <script src="../assets/js/dist/jquery.quicksearch.js"></script> -->
<script src="../assets/js/dist/jquery.searcher.js"></script>
<!-- <script src="../assets/js/dist/jquery.searcher.min.js"></script> -->



<!-- <div id="sampletakuya" value="今日の感想"></div>	
<script>
	var sample = $('div#sampletakuya').val(); 
	console.log(sample);
</script> -->


<div class="container">
	<!-- <div class="header"></div> -->
	<div class="contents">
		<div class="sidebar">
			<!-- 出来たら、JSで実現する	 -->

			<!-- 検索欄 -->
			<div id="search">
				<i class="fa fa-search" aria-hidden="true" id="search_icon"></i>
				<input type="search" name="mes_search"  id="mes_search" placeholder="Search Message">
			</div>
			<!-- 下記保留 -->
			<div id="bar"></div>

			<!-- ユーザー履歴一覧 -->
			<div class="user_list">
				<?php foreach ($talking_user as $user) { ?>
					<div class="tom" id="talk_history" value="<?php echo $user['other_id']; ?>" >
						<img src="../assets/img/icon.png" alt="icon" id="mes_icon">
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
			<!-- 以下検索	 -->
			<div id="mes_footer">				
				<!-- イメージ図選択ボタン		 -->

				<!-- テキスト内容 -->
				<form id="foo">
					<div id="image" >
						<input type="file" name="image_uplode" id="file" style="display:none;" onchange="img_up()">
						<img src="../assets/img/img_up.png" id="uplode_image" name="image_uplode" value="" onClick="$('#file').click();">
					</div>

					<?php //error_log(print_r($user_info,true),"3","../../../../../logs/error_log"); ?>
 					<div id="textbox" >
						<!-- 隠しデータで配列を送信する -->
						<?php if (!empty($user_info)): ?>
							<?php foreach ($user_info as $k => $v) { ?>
									<input type="hidden" class="ins" id="<?php echo $k ?>" value="<?php echo $v ?>">
							<?php } ?>
						<?php endif ; ?>
							
						<!-- 下記は仮ユーザー -->
						<!-- 下記のvalueについて確認 -->
						<input type="text" name="message" id="text_input">
					</div>

					<!-- 送信ボタン -->
					<div id="push" >
						<img src="../assets/img/post.png" id="submit" onClick="$('#submit').click();">
					</div>	

				</form>	
			</div>
		</div>
	</div>
</div>

	
	
</body>
</html> 