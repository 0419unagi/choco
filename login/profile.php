  <?php 
  require('../part/header.php');

  // SESSIONチェック
  if (!isset($_SESSION['login_user']['id'])) {
    header('Locaton:index.php');
    exit;
  }

  $sql = 'SELECT * FROM `batch_users` WHERE `id` = ?';
  // ?の分だけ配列の中に入る
  $data = array($_GET['id']);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);


  $user_info = array();
  while (true) {
      $data = $stmt->fetch(PDO::FETCH_ASSOC);
      if (!$data) {
        break;
      }
      $user_info[] = $data;
  }

  // 初期値
  $content = '';
  // POSTチェック
  if (!empty($_POST)) {
    $content = htmlspecialchars($_POST['content']);

    $errors = array();

      if ($content == '') {
        $errors['content'] = 'blank';
      }
      // contentのバリデーションここまで

      // 画像のバリデーション
      $fileName = $_FILES['post_image']['name'];
      if (!empty($fileName)) {
          $ext = substr($fileName, -3);
          $ext = strtolower($ext);

          if ($ext != 'jpg' && $ext != 'png' && $ext != 'gif') {
            $errors['post_image'] = 'extention';
          }
            // errorsにblankが入ってたのが問題！
            // エラーが空の時、画像を保存する
            if (empty($errors)) {
                move_uploaded_file($_FILES['post_image']['tmp_name'],'../post_image/'. $_FILES['post_image']['name']);
            }
      }
          // 画像のバリデーションここまで

          // 投稿のインサート
          // 画像の変数は$fileNameしか定義されてないから当然それが入る
          // 画像はPOST送信できない！
          $users_id = $_SESSION['login_user']['id'];
          $content = $_POST['content'];
          $image = $fileName;

          $sql = 'INSERT INTO `post` SET `users_id` = ?,
                                         `content` = ?,
                                         `image` = ?,
                                         `created` = NOW()';
          $data = array($users_id,$content,$image);
          $stmt = $dbh->prepare($sql);
          $stmt->execute($data);

  }

  // ログインユーザーのpostを引っ張ってきたい
  // プロフィールと投稿者を一致させたい

$sql = 'SELECT `post`.`id` AS "post_id",
                `post`.`content` AS "content",
                `post`.`image` AS "post_image",
                `post`.`created` AS "created",
                 `batch_users`.`id`,
                 `batch_users`.`nickname`,
                 `batch_users`.`image`
          FROM `post`
          LEFT JOIN `batch_users`
          ON `post`.`users_id` =`batch_users`.`id`
          WHERE `post`.`users_id` = ?
          ORDER BY `post`.`created` DESC';


  $record = array($_GET['id']);
  // error_log(print_r('test',true),"3","../../../../../logs/error_log");
  // error_log(print_r($record,true),"3","../../../../../logs/error_log");

  $stmt = $dbh->prepare($sql);
  $stmt->execute($record);

  $post = array();

  // var_dump($post);

  while (true) {
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($record == false) {
      break;
    }
    $post[] = $record;
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
    
    <!-- アニメーション --> 
    <link href="../assets/css/animate.css" rel="stylesheet">
  <script src="../assets/js/wow.min.js"></script>
  <script>
  new WOW().init();
  </script>
    
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="../assets/js/chart.js"></script>
    
    <link href="../assets/css/jquery.bxslider.css" rel="stylesheet" type="text/css">
    <script src="../assets/js/jquery.bxslider.js"></script>
    <script src="../assets/js/jquery.easing.1.3.js"></script>
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


  <link rel="stylesheet" href="../assets/css/lightbox.css">
  <script src="../assets/js/lightbox.js"></script>
  </head>

  <body>
    <?php foreach ($user_info as $data) { ?>


  <main id="profilePg">
  <div class="container">
  <div id="wrp">
  <div class="prfClm col-xs-4">

  <img src="../image/<?php echo $data['image']; ?>" width="100%" height="auto" alt=profileimage>
   
   <div class="prfBox">
   <p class="nickname"><?php echo $data['nickname']; ?></p>
   <p class="name"><?php echo $data['username']; ?></p>
   <p class="study"><?php echo $data['datepicker'] . '〜' . $data['datepicker2'] ; ?></p>
   <p class="course"><?php echo $data['course']; ?></p>
   <p class="birthday"><span>Birthday : </span><?php echo $data['year'] .'.'. $data['month'] . '.'. $data['day'] ; ?></p>
   <p class="from"><span>from : </span><?php echo $data['birthplace']; ?></p>
   <p class="hobby"><span>hobby : </span><?php echo $data['hobby']; ?></p>
   <p class="cmm"><?php echo $data['intro']; ?></p>
   <a href="#"><div class="message"><img src="../assets/img/message_w.png" width="17" height="13" alt=""/> メッセージを送る</div></a>
   </div>
  </div>
  <?php   } ?>

   <div class="feedClm col-xs-8">
      <!-- 以下のコードはログインユーザーのプロフィール画面の場合に表示   -->

      <?php if ($_GET['id'] == $_SESSION['login_user']['id']) : ?>
       <div id="contributeBox">
       <form method="POST" action="" enctype="multipart/form-data">
        <textarea name="content" rows="7" cols="89%" placeholder="ここから投稿します"></textarea>
        <input type="file" name="post_image" accept="image/*">
        <input type="submit" id="content" value="送信">

       </form>
       <ul>
        <li><i class="fa fa-picture-o" aria-hidden="true"></i></li>
        <li><i class="fa fa-pencil" aria-hidden="true"></i></li>
       </ul>
       </div>
     <?php endif ; ?>
       <!-- ここまで -->



<?php foreach ($post as $content) { ?>

  <section>
    <?php 
      $test = $content['created'] ;
      $date = substr($test,0,10);
    ?>
     <p class="date"><?php echo $date ; ?></p>
     <div class="nameBox">
        <a href="#">
          <div class="selfClm"><img src="../image/<?php echo $content['image']; ?>" width="80" height="80" alt=""/>
            <?php echo $content['nickname'] ; ?>
          </div>
        </a>
        <div class="badgeClm"><img src="../assets/img/badge.png" width="13" height="16" alt=""/>000</div>
     </div>
     <div class="row">
       <div class="picClm col-xs-6">
         <div class="slider">
            <a class="example-image-link" href="../post_image/<?php echo $content['post_image']; ?>" data-lightbox="example">
              <img class="example-image" src="../post_image/<?php echo $content['post_image']; ?>" width="100%" height="auto" alt=""/>
            </a>
         </div>
       </div>
         <div class="txtClm col-xs-6">
            <p class="sentence"><?php echo $content['content']; ?></p>
            <div class="commentBox">
               <a href="#"><img src="../assets/img/profile.jpg" width="35" height="35" alt=""/></a>
               <p class="txt">コメント</p>
            </div>
            <div class="postBox">
               <a href="#"><img src="../assets/img/profile.jpg" width="35" height="35" alt=""/></a>
               <p class="txt">コメント</p>
               <i class="fa fa-pencil" aria-hidden="true"></i>
            </div>
         </div>
       </div>
       <?php //削除ボタン　?>
          <?php if ($_SESSION['login_user']['id'] == $content['id']) : ?>
            <a href="delete.php?id=<?php echo $content['post_id']; ?>" class="square_btn">削除する</a>
          <?php endif ;?>
  </section>
   <?php } ?>
   
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
