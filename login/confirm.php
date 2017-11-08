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
  <link rel="stylesheet" type="text/css" href="../assets/css/login.css">
  <title>登録確認画面</title>
</head>
<body>

  <div id="tablecell">
  <div class="container">
    <div class="row">
      <div class="col-xs-3"></div>

      <div class="col-xs-3">
        <div class="batch">
          <img src="../assets/img/ill_hand.png" alt="hand_logo" >
          <h1>BATCH</h1>
          <p>make a history together!</p>
          <br>
          <h2>Sign up</h2>
        </div>
      </div>

  <div class="check">
   <div class="col-xs-3" style="width: 300px;"><br><br>
    下記の情報で登録してもよろしいですか？<br>
    <br><br><br>
    
    <div class="top">FULLNAME<br>
    <div class="text">
    <?php echo $_SESSION['login_user']['username']; ?> 
    </div>
    </div><br>
    

    <div class="top">NICKNAME<br>
    <div class="text">
    <?php echo $_SESSION['login_user']['nickname']; ?>
    </div>
    </div><br>


    <div class="top">EMAIL<br>
    <div class="text">
    <?php echo $_SESSION['login_user']['email']; ?>
    </div>
    </div><br>


    <div class="top">COURSE<br>
    <div class="text">
    <?php echo $_SESSION['login_user']['course']; ?>
    </div>
    </div><br>


    <div class="top">ENTRANCE<br>
    <div class="text">
    <?php echo $_SESSION['login_user']['datepicker']; ?>
    </div>
    </div><br>


    <div class="top">GRADUATION<br>
    <div class="text">
    <?php echo $_SESSION['login_user']['datepicker2'];?>
    </div>
    </div><br>

    <div class="top">PASSWORD<br>
    <div class="text">
    <?php echo $_SESSION['login_user']['password']; ?>
    </div>
    </div><br><br><br><br><br>
   
   </div>
  </div>

  <br>
  <div class="position">
  <form method="POST" action="">
    <input type="hidden" name="batch_users" value="batch_users">
    <input class="login" type="submit" value="SIGN UP">
  </form>
  <br>
  <input class="login" type="button" value="BACK" onclick="history.back()">
  </div>

    </div>
  </div>
  </div>




</body>
</html>