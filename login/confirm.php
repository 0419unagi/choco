<?php 

    session_start();
    require('../dbconnect.php');

    if (empty($_SESSION)) {
      echo 'データを入力してください。';
      header('Location: index.php');
    exit();
    }
    
    if (!empty($_POST)) {
      echo "エラーなし！ok！";


    $username = ($_SESSION["login_user"]['username']);
    $nickname = ($_SESSION["login_user"]['nickname']);
    $email = ($_SESSION["login_user"]['email']);
    $course = ($_SESSION["login_user"]["course"]);
    $datepicker = ($_SESSION["login_user"]["datepicker"]);
    $datepicker2 = ($_SESSION["login_user"]["datepicker2"]);
    $password = ($_SESSION["login_user"]["password"]);

    $sql = 'INSERT INTO `batch_users` SET `username` = ?, `nickname` = ?, `email` =? , `course` =? , `datepicker` =? , `datepicker2` =? , `password` = ?,`created` = NOW()';

    $data = array($username,$nickname,$email,$course,$datepicker,$datepicker2,$password);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

     header("Location:top.php");
     exit();

   }

 ?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
  <title></title>
</head>
<body>
  <div>
    下記の情報で登録してもよろしいでしょうか。<br>
    <br>
    ユーザー名 : <?php echo $_SESSION['login_user']['username']; ?> <br>
    ニックネーム :<?php echo $_SESSION['login_user']['nickname']; ?><br>
    メールアドレス : <?php echo $_SESSION['login_user']['email']; ?> <br>
    コース : <?php echo $_SESSION['login_user']['course']; ?> <br>
    入学日 : <?php echo $_SESSION['login_user']['datepicker']; ?> <br>
    卒業日:<?php echo $_SESSION['login_user']['datepicker2']; ?><br>
    パスワード :<?php echo $_SESSION['login_user']['password']; ?> <br>


  </div>
  <br>
  <form method="POST" action="">
    <input type="hidden" name="aaaa" value="aaaa">
    <input type="submit" value="ユーザー登録">
  </form>
  <br>
  <input type="button" value="戻る" onclick="history.back()">

</body>
</html>