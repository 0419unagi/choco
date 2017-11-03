<?php 

	session_start();

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

      $_SESSION['user_info']['email'] = $email;
      $_SESSION['user_info']['password'] = $password;

      header('Location: top.php');
      exit();
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

<!-- 新規登録 -->
<form method="POST" action="new.php" enctype="multipart/form-data">
	<label >新規登録</label><br>
	<input type="submit" value="登録する">
	<br><br></form>

<!-- ログイン -->
<form method="POST" action="" enctype="multipart/form-data">
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