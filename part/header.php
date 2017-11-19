<?php 

session_start();
// データベースの接続情報
require('../dbconnect.php');

// PHPでDBへアクセスして、SQLを実行する
/// $data = array($_SESSION['login_user']['id']);
// $stmt = $dbh->prepare($sql);
// $stmt->execute($data);

// $userdata = array();
// while(true){
//   $data = $stmt->fetch(PDO::FETCH_ASSOC);
//   if(!$data){
//     break;
//   }

//   $userdata[] = $data;
  // echo '<pre>';
  // var_dump($data);
  // echo '</pre>';
  
// }S


 ?>


<!doctype html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>BATCH</title>

<!-- cssファイルの読み込み -->
  <link href="../assets/css/reset.css" rel="stylesheet">
  <link href="../assets/css/bootstrap.css" rel="stylesheet">
  <link href="../assets/css/font-awesome.min.css" rel="stylesheet">
  <link href="../assets/css/top.css" rel="stylesheet" type="text/css">
<!--   <link rel="stylesheet" type="text/css" href="../assets/css/custom.css"> -->
  
  <!-- アニメーション --> 
  <link href="../assets/css/animate.css" rel="stylesheet">
<script src="../assets/js/wow.min.js"></script>
<script>
new WOW().init();
</script>
  
  
  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="../assets/js/chart.js"></script>
 
</head>

<body>
<header>
  
  <div id="clm_l">
   <div id="prf">
    <a href="../login/profile.php?id=<?php echo $_SESSION['login_user']['id'] ?>">
    <img id="ill" class="wow slideInDown" data-wow-duration="0.8s" src="../assets/img/ill_hand.png" width="133" alt=""/>
    <img id="pic" src="../image/<?php echo $_SESSION['login_user']['image']; ?>" width="70" height="70" alt=""/>
    </a>
   </div>
  
  <div id="logo" class="wow pulse" data-wow-duration="0.5s">
   <a href="../login/top.php">

   <img src="../assets/img/logo.png" width="120" height="45" alt=""/>
   </a>
  </div>
 </div>
  
 <div id="clm_r">
   <div id="tBox">
 <!--   <div id="reserch">
    <i class="fa fa-search" aria-hidden="true"></i><input type="text" value="Search BATCH" size="30">
   </div> -->
  
 <div class="bBox">
  <ul id="icon">
   <li>
    <a href="../login/top.php"><img class="roll" src="../assets/img/nenpyo.png" width="21" height="13" alt=""/>
    <p>TOP PAGE</p></a>
   </li>
   <li>
    <a href="../login/timeline.php"><img class="roll" src="../assets/img/time.png" width="13" height="13" alt=""/>
    <p>TIME LINE</p></a>
   </li>
   <li>
    <a href="../message/message.php"><img class="roll" src="../assets/img/message.png" width="17" height="13" alt=""/>
    <p>MESSAGE</p></a>
   </li>
  </ul>
 </div> 

  <ul id="tab">
   <li><a href="edit.php">EDIT</a></li>
   <li> <a href="logout.php">LOGOUT</a></li>
  </ul>
  </div>

 
 </div> 
 </header>
