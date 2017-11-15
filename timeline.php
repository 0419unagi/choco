<?php
  // セッションを呼び出す 
  session_start();
  // データベース
  require('dbconnect.php');
  

  // require('part/header.php');

  // セッションデータがなければお帰りいただく
  if(!isset($_SESSION['login_user']['id'])){
    header('Location: index.php');
    exit();
  }


  //ユーザーデータをSELECTする
  $sql = 'SELECT * FROM `batch_users` WHERE id=?';
  $data = array($_SESSION['login_user']['id']);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);

  $userdata = array();
  while(true){
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!$data){
      break;
    }

    $userdata[] = $data;

    echo '<pre>';
    var_dump($data);
    echo '</pre>';


  }

 
 ?>



<!doctype html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>TOP</title>
  <link href="assets/css/reset.css" rel="stylesheet">
  <link href="assets/css/bootstrap.css" rel="stylesheet">
  <link href="assets/css/font-awesome.min.css" rel="stylesheet">
  <link href="assets/css/profile.css" rel="stylesheet" type="text/css">
  
  <!-- アニメーション --> 
  <link href="assets/css/animate.css" rel="stylesheet">
<script src="assets/js/wow.min.js"></script>
<script>
new WOW().init();
</script>
  
  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="assets/js/chart.js"></script>
  
  <link href="assets/css/jquery.bxslider.css" rel="stylesheet" type="text/css">
  <script src="assets/js/jquery.bxslider.js"></script>
  <script src="assets/js/jquery.easing.1.3.js"></script>
  <script type="text/javascript">
$(function(){
	$('.slider').bxSlider({
		auto:true,
		speed:4000,
		mode: 'fade',
		controls:false, //コントロール（Next, Prev）を有無
		pager:true, //ページャーの有無
		captions: false
	});
});
</script>


<link rel="stylesheet" href="assets/css/lightbox.css">
<script src="assets/js/lightbox.js"></script>
</head>

<body>
 
 <?php foreach($userdata as $data) {?>
<main id="profilePg">
<div class="container">
<div id="wrp">
<div class="prfClm col-xs-4">
  <!-- 　写真 -->
  <p style="background-image: <?php echo $data['image'] ;?>;"></p>
 <div class="prfBox">
  <!-- ニックネーム -->
 <p class="nickname"><?php echo $data['nickname'] ;?></p>
 <!-- ユーザーネーム -->
 <p class="name"><?php echo $data['username'] ;?></p>
 <!-- 留学期間 -->
 <p class="study"><?php echo $data['datepicker'] ;?>~<?php echo $data['datepicker2'] ;?></p>
 <!-- コース -->
 <p class="course"><?php echo $data['course'] ;?></p>

 <!-- 誕生日 -->
 <p class="birthday"><span>Birthday : </span><?php echo $data['year'] ;?>/<?php echo $data['month'] ;?>/<?php echo $data['day'] ;?></p>
 <!-- 出身 -->
 <p class="from"><span>from : </span><?php echo $data['birthplace'] ;?></p>
 <!-- 趣味 -->
 <p class="hobby"><span>hobby : </span><?php echo $data['hobby'] ;?></p>
 <!-- 自己紹介 -->
 <p class="cmm"><?php echo $data['intro'] ;?></p>
 <!-- メッセージ -->
 <a href="#"><div class="message"><img src="assets/img/message_w.png" width="17" height="13" alt=""/> メッセージを送る</div></a>
 </div>
</div>
<?php } ?>




 <div class="feedClm col-xs-8">
    <!-- 以下のコードはログインユーザーのプロフィール画面の場合に表示   -->
     <div id="contributeBox">
     <form method="" action="">
      <textarea rows="7" cols="89%" placeholder="ここから投稿します"></textarea>
     </form>
     <ul>
      <li><i class="fa fa-picture-o" aria-hidden="true"></i></li>
      <li><i class="fa fa-pencil" aria-hidden="true"></i></li>
     </ul>
     </div>
     <!-- ここまで -->

 <section>
 <p class="date">2017.9.18</p>
 <div class="nameBox">
  <a href="#">
  <div class="selfClm"><img src="assets/img/profile.jpg" width="80" height="80" alt=""/>
  nickname</div></a>
  <div class="badgeClm"><img src="assets/img/badge.png" width="13" height="16" alt=""/>000</div>
 </div>
 <div class="row">
 <div class="picClm col-xs-6">
 <div class="slider">
  <a class="example-image-link" href="assets/img/img_damy1.jpg" data-lightbox="example">
  <img class="example-image" src="assets/img/img_damy1.jpg" width="100%" height="auto" alt=""/></a>
  <a class="example-image-link" href="assets/img/img_damy2.jpg" data-lightbox="example">
  <img class="example-image" src="assets/img/img_damy2.jpg" width="100%" height="auto" alt=""/></a>
  <a class="example-image-link" href="assets/img/img_damy3.jpg" data-lightbox="example">
  <img class="example-image" src="assets/img/img_damy3.jpg" width="100%" height="auto" alt=""/></a>
 </div>
 </div>

 <div class="txtClm col-xs-6">
 <p class="sentence">ここにテキストが入ります。文字数・行間・フォントなどご確認ください。この文章はダミーです。ここにテキストが入ります。文字数・行間・フォントなどご確認ください。この文章はダミーです。ここにテキストが入ります。文字数・行間・フォントなどご確認ください。この文章はダミーです。</p>
 
  <div class="commentBox">
   <a href="#"><img src="assets/img/profile.jpg" width="35" height="35" alt=""/></a>
   <p class="txt">コメント</p>
  </div>
  
  <div class="postBox">
   <a href="#"><img src="assets/img/profile.jpg" width="35" height="35" alt=""/></a>
   <p class="txt">コメント</p>
   <i class="fa fa-pencil" aria-hidden="true"></i> </div>
 </div>
</div>
</section>
 
 
 <div>
  
 </div>
 
 
</div>
</div>
 </div>

</main>

<footer>
 <small>copyright ©︎chocomallow.All rights reserved.</small>
</footer>

</body>
</html>
