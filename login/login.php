<?php 
	session_start();
	if (!empty($_GET)) {
		$_SESSION['user_id'] = $_GET['user_id'];
		$_SESSION['other_id'] = $_GET['other_id'];

		header('Location:message.php');
		exit();
	}
	

 ?>
 <!DOCTYPE html>
 <html lang="ja">
 <head>
 	<meta charset="utf-8">
 	<title>Login</title>
 </head>
 <body>
 	<h3>ログインフォーム</h3>
	<form action="login.php" method="get">
		<input type="text" name="user_id" ><br>
		<input type="text" name="other_id" ><br>
		<input type="submit" value="送信">
	</form>

 
 </body>
 </html>