<?php
  // セッションを呼び出す 
  // session_start();
  // // データベース
  // require('dbconnect.php');
  

  require('../part/header.php');

  // セッションデータがなければお帰りいただく
  if(!isset($_SESSION['login_user']['id'])){
    header('Location: index.php');
    exit();
  }

// いいねのデータを表示
  // $sql = 'SELECT * FROM `like` WHERE user_id=? AND post_id=?'
  // $data = array($_SESSION['login_user']['id'],$_REQUEST['post_id']);
  // $stmt = $dbh->prepare($sql);
  // $stmt->execute($data);


// いいねのデータ挿入
  // $sql = 'INSERT INTO `like` WHERE user_id=? AND post_id=?'
  // $data = array($_SESSION['login_user']['id'],$_REQUEST['post_id']);
  // $stmt = $dbh->prepare($sql);
  // $stmt->execute($data);


// いいねのデータ削除
  // $sql = 'DELETE `like` WHERE user_id=? AND post_id=?'
  // $data = array($_SESSION['login_user']['id'],$_REQUEST['post_id']);
  // $stmt = $dbh->prepare($sql);
  // $stmt->execute($data);



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

    // echo '<pre>';
    // var_dump($data);
    // echo '</pre>';
  }
  // batch_usersとpostをjoin
  $sql = 'SELECT `post`. * ,`batch_users`.`id`, `batch_users`.`nickname`,`batch_users`.`image`
          FROM `post`
          LEFT JOIN `batch_users`
          ON `post`.`users_id` = `batch_users`.`id`
          WHERE 1
          ORDER BY `post`. `created` DESC';
  $data = array(); 
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);

  $post = array();
  while(true){
  $data = $stmt->fetch(PDO::FETCH_ASSOC);
  if(!$data){
    // ここに入ったらループを止めてあげる
    break;
  }
  $post[] = $data;
  }
  // error_log(print_r('$tweets',true),"3","../../../../../logs/error_log");

// echo '<pre>';
// var_dump($data);
// echo '</pre>';


  // POSTチェック
if(!empty($_POST)){
  // バリデーションチェック
  $errors = array();

  if(isset($_POST['comment'])){
    // ツイートするを押すと個々の処理が走ります。
  $comment = htmlspecialchars($_POST['comment']);

  // バリデーション
  if($comment==''){
    $errors['comment']='blank';
    }

  if(empty($errors)){

  // コメント記入の為のINSERT
  $sql = "INSERT INTO `comment` SET `post_id` =?, `comment`=?";
  $data = array($post,$comment);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);

  header('Location: timeline.php');
  exit();
  }
  }
}

 // ユーザー情報とコメントをjoin
 $sql = 'SELECT `comment`. * ,`batch_users`.`id`,`batch_users`.`image`
          FROM `comment`
          LEFT JOIN `batch_users`
          ON `comment`.`users_id` = `batch_users`.`id`
          WHERE 1';
  $data = array(); 
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);

  $users = array();
  while(true){
  $data = $stmt->fetch(PDO::FETCH_ASSOC);
  if(!$data){
    // ここに入ったらループを止めてあげる
    break;
  }
  $users[] = $data;
  }

 // $sql = 'SELECT `comment`. * ,`post`.`id`
 //          FROM `comment`
 //          LEFT JOIN `post`
 //          ON `comment`.`post_id` = `post`.`id`
 //          WHERE 1';
 //  $data = array(); 
 //  $stmt = $dbh->prepare($sql);
 //  $stmt->execute($data);

 //  $comment = array();
 //  while(true){
 //  $data = $stmt->fetch(PDO::FETCH_ASSOC);
 //  if(!$data){
 //    // ここに入ったらループを止めてあげる
 //    break;
 //  }
 //  $comment[] = $data;
 //  }


 ?>



<!doctype html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>TOP</title>
  <link href="../assets/css/reset.css" rel="stylesheet">
  <link href="../assets/css/bootstrap.css" rel="stylesheet">
  <link href="../assets/css/font-awesome.min.css" rel="stylesheet">
  <link href="../assets/css/profile.css" rel="stylesheet" type="text/css">
  
  <!-- アニメーション --> 
  <link href="../assets/css/animate.css" rel="stylesheet">
    <script src="../assets/js/wow.min.js"></script>
  <script>
  new WOW().init();
  </script>
  
  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="../assets/js/chart.js"></script>
<link rel="stylesheet" href="../assets/css/lightbox.css">
<script src="../assets/js/lightbox.js"></script>
</head>

<body>
 
<!-- ログインユーザーの情報を表示 -->
<?php foreach($userdata as $data) {?>
  <main id="profilePg">
    <div class="container">
      <div class="wrp">
        <div class="prfClm">
          <div class="picBox">
            <!-- $dataにimageがあれば表示、なければデフォルト画像表示 -->
            <?php if(!empty($data['image'])){ ?>
              <img class="pic" src="../image/<?php echo $data['image'] ;?>" width="100%" height="auto" alt=""/>
            <?php }else{ ?>
              <img src="../assets/img/damy.jpg" width="100%" height="auto" alt=""/>
            <?php } ?>
              <img class="gra" src="../assets/img/gra.png" width="100%" height="auto" alt=""/>
          </div>

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
            <a href="#">
              <div class="message">
                <img src="../assets/img/message_w.png" width="17" height="13" alt=""/> メッセージを送る
              </div>
            </a>
          </div>
        </div>
<?php } ?>


<!-- 全ユーザーのタイムラインを表示 -->
<div class="feedClm">
  <h1 style="text-align: center;">All TIMELINE</h1>
    <br><br>
  <?php foreach($post as $content){ ?>
    <section>
 
      <!-- 日時 -->
        <p class="date"><?php echo $content['created']; ?></p>
          <div class="nameBox">
 
            <!-- 投稿ユーザーのページへ遷移 -->
            <a href="profile.php?id=<?php echo $content['id'] ;?>">
 
              <!-- ユーザー画像＆ニックネーム -->
              <div class="selfClm"><img src="../image/<?php echo $content['image'];?>" width="80" height="80" alt=""/>
                <?php echo $content['nickname']; ?>
              </div>
            </a>
              <!-- いいね -->
              <div class="badgeClm"><img src="../assets/img/badge.png" width="13" height="16" alt=""/>050</div>
          </div>

    <div class="row">
      <div class="picClm col-xs-6">
        <?php if(!empty($content['post_image'])){ ?>
          <!-- 投稿画像 -->
            <a class="example-image-link" href="../post_image/<?php echo $content['post_image']?>" data-lightbox="example">
              <img class="example-image" src="../post_image/<?php echo $content['post_image']?>" width="100%" height="auto" alt=""/></a>
        <?php }else{ ?>
            <a class="example-image-link" href="../assets/img/img_dumy6.jpg" data-lightbox="example">
              <img class="example-image" src="../assets/img/img_dumy6.jpg" width="100%" height="auto" alt=""/>
            </a>
        <?php } ?>
      </div>


 <div class="txtClm col-xs-6">
 <p class="sentence"><?php echo $content['content']; ?></p>
 
 <!-- コメント表示 -->
<?php foreach($users as $reply){ ?>
  <div class="commentBox">
      <a href="profile.php?id=<?php echo $reply['id'] ;?>">
    <?php if(!empty($reply['image'])){ ?>
      <img src="../image/<?php echo $reply['image'];?>" width="35" height="35" alt=""/></a>
    <?php }else{ ?>
      <a href="profile.php?id=<?php echo $reply['id'] ;?>">
      <img src="../assets/img/damy.jpg" width="35" height="35" alt=""/></a>
    <?php } ?>
  <p class="txt"><?php echo $reply['comment']; ?></p>
  </div>
<?php } ?>

  <!-- コメント投稿欄 -->
<div class="postBox">
  <?php if(!empty($data['image'])){ ?>
    <a href="profile.php?id=<?php echo $data['id'] ;?>">
    <img src="../image/<?php echo $_SESSION['login_user']['image'];?>" width="35" height="35" alt=""/></a>
  <?php }else{ ?>
    <img src="../assets/img/damy.jpg" width="35" height="35" alt=""/>
   <?php } ?>
  <form method="POST" action="">
    <input style="border:none; outline: 0;width:230px;" class="text" type="txt" name="comment" placeholder="Write a Comment" value="">
      <?php if(isset($errors['comment']) ){ ?>
        <div class="alert alert-danger">投稿内容を入力してください。</div>
      <?php } ?>
    <input type="submit" value="送信">
    <!-- <i class="fa fa-pencil" aria-hidden="true"></i> -->
  </form>
</div>
</div>
</div>


</section>
<?php } ?>
 
 <div>
  
 </div>
 
 
</div>
</div>
 </div>

</main>

<footer>
 <!-- <small>copyright ©︎chocomallow.All rights reserved.</small> -->
 <?php require('../part/footer.php') ;?>

</footer>

</body>
</html>
