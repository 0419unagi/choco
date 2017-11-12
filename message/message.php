<?php 
// データベース呼び出し
require('dbconnect.php');

//仮想的にSESSIONからユーザー取得
//	想定：$user_id = $_SESSION['id'] ;
$user_id = 1 ; //ユーザー名：takuya
$other_id = 2; //ユーザー名：sample

//初期値の設定
$record = [
	'user' => '',
	'message' =>''
];
$inputValue = [];

//ユーザーデータ読み出し
require('model/selectUser.php');
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