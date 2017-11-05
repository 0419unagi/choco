<?php 

	session_start();

	require('../dbconnect.php');

	$email = '';
	$password = '';

	echo "<pre>";
	var_dump($_POST);
	echo "</pre>";

	if(!empty($_POST)){
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	$errors = array();

		if($email == ''){
			$errors['email'] = 'blank';
		}

		if($password == ''){
			$errors['password'] = 'blank';
		}elseif(strlen($password) >= 9 ){
			$errors['password'] = 'length';
		}elseif(strlen($password) < 4 ){
			$errors['password'] = 'length';
		}

    if(empty($errors)){
    	// エラーがなかったら、ログインできるかをチェック
    	$sql = 'SELECT * FROM `batch_users` WHERE `email` = ? AND `password` = ?';

    	// ?マークを代入する
    	$data = array($email,$password);
    	$stmt = $dbh->prepare($sql);
    	$stmt->execute($data);

    	// セレクト文を実行した結果を取得する。

		$record = $stmt->fetch(PDO::FETCH_ASSOC);
		// 全件取得させる場合はループさせて、配列に入れる
		// セレクトした内容の一番上(エクセルの表の一番上のみ)だけ取得して存在するかどうかチェックすれば、ログイン判定可能

		// var_dump($record);

		if($record){
			// echo 'ログインできました。タイムラインへ移動します。<br>';
			// 一致した場合はログインする。
			$_SESSION['login_user'] = $record;
			header('Location: top.php');
			exit();
		}else{
			// ログインできなかった場合
			$errors['login'] = 'NG';
		}
    }
	}
 ?>



<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>Batch ログイン画面</title>
	<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
</head>
<body>

<!-- 新規登録 -->}
}
<form method="POST" action="new.php" >
	<label >新規登録</label><br>
	<input type="submit" value="登録する">
	<br><br></form>

<!-- ログイン -->
<form method="POST" action="" >

	<?php if(isset($errors['login']) ){ ?>
      <div class="alert alert-danger">
        メールアドレスまたはパスワードが違います。
      </div>
    <?php } ?>

	<label >ログイン</label><br>
	<input type="email" name="email" placeholder="メールアドレスを入力" value="<?php echo $email; ?>">
	<br>

	<?php if (isset($errors['email']) && $errors['email'] == 'blank'){
		echo "メールアドレスを入力してください".'<br>';
	}

		?>

		<input type="password" name="password" placeholder="パスワードを入力" value="<?php echo $password; ?>">
	<br> 


	<?php if (isset($errors['password']) && $errors['password'] == 'blank'){
		 echo 'パスワードは4文字以上8文字以内で入力してください。';
	}elseif(isset($errors['password']) && $errors['password'] == 'length'){
		echo 'パスワードは4文字以上8文字以内で入力してください。';
	
	}

	 ?>
	<br>
	<input type="submit" value="ログイン">





</form>


</body>
</html>