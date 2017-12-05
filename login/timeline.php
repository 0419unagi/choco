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

  }
  // batch_usersとpostをjoin
  $sql = 'SELECT `post`. * ,`batch_users`.`id` AS user_id, `batch_users`.`nickname`,`batch_users`.`image`
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


  // POSTチェック
if(!empty($_POST)){
  // バリデーションチェック
  $errors = array();

  if(isset($_POST['like'])){
    // echo 'いいねしました';

    if($_POST['like']){
      if($_POST['like'] == 'like'){

    // いいね！をDBへ登録する
    $sql = 'INSERT INTO `like` SET `post_id`=?,`users_id`=?,`created`=NOW()';
    $data = array($_POST['post_id'],$_SESSION['login_user']['id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

      }elseif($_POST['like'] == 'unlike'){
        // いいねを取り消した時
        $sql = 'DELETE FROM `like` WHERE `post_id`=? AND `users_id`=?';
        $data = array($_POST['post_id'],$_SESSION['login_user']['id']);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

      }
    }



    // いいね数をカウントする。
    $sql = 'SELECT count(*) AS `con` FROM `like` WHERE `post_id`=?';
    $data = array($_POST['post_id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $like = $stmt->fetch(PDO::FETCH_ASSOC);
    // var_dump($like);
    echo 'いいねの数は'.$like["con"].'です。<br>';

    // DBにいいね！の数を保存する(更新する)
    $sql = 'UPDATE `post` SET `like_count`=? WHERE `id`=?';
    $data = array($like['con'],$_POST['post_id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    // POST送信を破棄する
    header('Location: timeline.php#post_'.$_POST['post_id']);
    exit();

  }

  if(isset($_POST['comment'])){
    // ツイートするを押すと個々の処理が走ります。
  $comment = htmlspecialchars($_POST['comment']);
  // echo 'POST送信しました。';

  // バリデーション
  if($comment==''){
    $errors['comment']='blank';
      }elseif(strlen($comment) >= 51 ){
        $errors['comment'] = 'length';
  }


  if(empty($errors)){

  // コメント記入の為のINSERT
  $sql = "INSERT INTO `comment` SET `post_id` =?, `users_id`=?, `comment`=?,`created`=NOW()";
  $data = array($_POST['post_id'],$_SESSION['login_user']['id'],$comment);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);

  header('Location: timeline.php#post_'.$_POST['post_id']);
  exit();
  }
  }
}

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
  <link href="../assets/css/font-awesome.min.css">
  
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
 <h1 style="text-align: center; margin-top: 60px; margin-bottom: 30px; background-color: white; font-size: 35px; letter-spacing: 3px; padding-top: 20px; padding-bottom: 10px; line-height: 20px;">All TIMELINE<br><span style="font-size: 10px;">▼</span></h1>
    <br><br>
  <?php foreach($post as $content){ ?>
    <section>
      <div id="post_<?php echo $content['id']; ?>"></div>

      <?php 
        $test = $content['created'] ;
        $date = substr($test,0,10);
      ?>

      <!-- 日時 -->
        <p class="date"><?php echo $date; ?></p>
          <div class="nameBox">

            <!-- 投稿ユーザーのページへ遷移 -->
            <a href="profile.php?id=<?php echo $content['user_id'] ;?>">
 
              <!-- ユーザー画像＆ニックネーム -->
              <div class="selfClm"><img src="../image/<?php echo $content['image'];?>" width="80" height="80" alt=""/>
                <?php echo $content['nickname']; ?>
              </div>
            </a>
              <!-- いいね数表示 -->
              <div class="badgeClm"><img src="../assets/img/badge.png" width="13" height="16" alt=""/><?php echo $content['like_count']?></div>
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

      <!-- いいね -->
      <br><br>
      <form method="POST" action="">
        <input type="hidden" name="post_id" value="<?php echo $content['id'];?>">
        <input type="hidden" name="users_id" value="<?php echo $_SESSION['login_user']['id']?>">
        
        <?php 
        // 自分がいいねしたかどうかチェックする。
        $sql = 'SELECT * FROM `like` WHERE `post_id`=? AND `users_id`=?';
        $data = array($content['id'],$_SESSION['login_user']['id']);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        // データベースから1件取得して
        // 自分がいいねしてなかったら0が来るようにする
        $check = $stmt->fetch(PDO::FETCH_ASSOC);

        ?>


        <?php if(!$check){ ?>
          <input type="hidden" name="like" value="like">
          <input type="hidden" name="id" value="<?php echo $content['id']; ?>">
          <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_GET['id']); ?>">
          <div class="like">
            <input type="submit" value="いいね！" class="btn-xs">
            <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
          </div>
        <?php }else{ ?>
          <input type="hidden" name="like" value="unlike">
          <input type="hidden" name="like" value="unlike">
          <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_GET['id']); ?>">
          <div class="like">
            <input type="submit" value="いいね取消" class="btn-xs">
            <i class="fa fa-thumbs-o-down" aria-hidden="true"></i>
          </div>
        <?php } ?>
      </form>

      </div>


 <div class="txtClm col-xs-6">
 <p class="sentence"><?php echo $content['content']; ?></p>
 

<?php

 $sql = 'SELECT `comment`. * ,`batch_users`.`id` AS `user_id`,`batch_users`.`image`
         FROM `comment`
         LEFT JOIN `batch_users`
         ON `comment`.`users_id` = `batch_users`.`id`
         WHERE `post_id`=?';
  $data = array($content['id']); 
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

?>


 <!-- コメント表示 -->
<?php foreach($users as $reply){ ?>
  <div class="commentBox">
      <a href="profile.php?id=<?php echo $reply['user_id'] ;?>">
    <?php if(!empty($reply['image'])){ ?>
      <img src="../image/<?php echo $reply['image'];?>" width="35" height="35" alt=""/></a>
    <?php }else{ ?>
      <a href="profile.php?id=<?php echo $reply['user_id'] ;?>">
      <img src="../assets/img/damy.jpg" width="35" height="35" alt=""/></a>
    <?php } ?>
  <p class="txt"><?php echo $reply['comment']; ?></p>
  <!-- 削除-->
  <?php if($_SESSION['login_user']['id'] == $reply['user_id']){ ?>
    <a onclick="return confirm('削除してもよろしいでしょうか？')" href="delete_tl.php?id=<?php echo $reply['id']; ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
  <?php } ?>
  </div>
<?php } ?>


  <!-- コメント投稿欄 -->
<div class="postBox">
  <?php if(!empty($content['image'])){ ?>
    <a href="profile.php?id=<?php echo $_SESSION['login_user']['id'] ;?>">
    <img src="../image/<?php echo $_SESSION['login_user']['image'];?>" width="35" height="35" alt=""/></a>
  <?php }else{ ?>
    <img src="../assets/img/damy.jpg" width="35" height="35" alt=""/>
   <?php } ?>
  <form method="POST" action="">
    <input type="hidden" name="post_id" value="<?php echo $content['id'];?>">
    <input type="hidden" name="id" value="<?php echo $content['id']; ?>">
    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_GET['id']); ?>">

    <input style="border:none; outline: 0;width:230px;" class="text" type="txt" name="comment" placeholder="Write a Comment" value="">
      <?php if(isset($errors['comment']) && $errors['comment'] == 'blank'){ ?>
        <div class="alert alert-danger">投稿内容を入力してください。</div>
      <?php }elseif(isset($errors['comment']) && $errors['comment'] == 'length'){ ?>
        <div class="alert alert-danger">16文字以内で入力してください。</div>
      <?php } ?>

<div class="penBox">
    <input type="submit" value="" class="btn-xs">
    <i class="fa fa-pencil" aria-hidden="true"></i>
</div>
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
 <?php require('../part/footer.php') ;?>

</footer>

</body>
</html>
