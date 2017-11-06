<?php 
	// echo "<pre>";
	// var_dump($_POST);
	// echo "</pre>";
	session_start();

	if(!isset($_SESSION['login_user']['id'])){
		header('Location: index.php');
		exit();
}


 ?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>Batch トップページ</title>
</head>
<body>

<h3>マイページ</h3>
	ようこそ。<?php echo $_SESSION['login_user']['nickname'] ?>さん。

	<a href="logout.php" class="btn btn-danger">ログアウト</a>

</body>
</html>