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

    $sql = 'SELECT * FROM `batch_users` WHERE email=?';
    $data = array($_SESSION['login_user']['email']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $_SESSION['login_user']['id']=$data['id'];
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
  <div class="container">

      <div class="clmWrp">
       
        <div class="clm" id="clm_1">
            <div id="logoBox">
              <img src="../assets/img/logomark.png" alt="hand_logo" width="81" height="135" id="logo" >
              <h1>BATCH</h1>
              <p id="sub">make a history together</p>
            </div>
            <div id="ctgBox">
              <div class="line"></div>
              <h2>SIGN UP</h2>
              <div class="line"></div>
          </div>
        </div>
      
     
      <div class="clm" id="clm_2">
       <p class="catch">下記の情報で登録してもよろしいですか？</p>

       <div class="list">
         <p class="ttl">FULLNAME</p>
         <p class="text"><?php echo $_SESSION['login_user']['username']; ?></p>
       </div>

        <div class="list">
         <p class="ttl">NICKNAME</p>
         <p class="text"><?php echo $_SESSION['login_user']['nickname']; ?></p>
        </div>

        <div class="list">
          <p class="ttl">EMAIL</p>
          <p class="text"><?php echo $_SESSION['login_user']['email']; ?></p>
        </div>

       <div class="list">
         <p class="ttl">COURSE</p>
         <p class="text"><?php echo $_SESSION['login_user']['course']; ?></p>
       </div>

       <div class="list">
         <p class="ttl">ENTRANCE</p>
         <p class="text"><?php echo $_SESSION['login_user']['datepicker']; ?></p>
       </div>

       <div class="list">
         <p class="ttl">GRADUATION</p>
         <p class="text"><?php echo $_SESSION['login_user']['datepicker2'];?></p>
       </div>

       <div class="list">
         <p class="ttl">PASSWORD</p>
         <p class="text"><?php echo $_SESSION['login_user']['password']; ?></p>
       </div>
     </div>


     <div class="clm" id="clm_3">
      <div class="position"  id="submitBox">
       <form method="POST" action="">
         <input type="hidden" name="batch_users" value="batch_users">
         <input class="login" type="submit" value="SIGN UP">
         <input class="login" type="button" value="BACK" onclick="history.back()">
       </form>
     </div>
    </div>
    
  </div>

</body>
</html>