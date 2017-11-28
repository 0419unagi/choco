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
  $data = array($_GET['id']);
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



  // POSTチェック
if(!empty($_POST)){
  // バリデーションチェック
  $errors = array();

  if(isset($_POST['content'])){
    // ツイートするを押すと個々の処理が走ります。
  $content = htmlspecialchars($_POST['content']);
  $content = nl2br($content);
  // $content=str_replace("\n","<br>",$content);

  // var_dump($content);
    // バリデーション
    if($content==''){
      $errors['content']='blank';
    }
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
  // $users_id = $_SESSION['login_user']['id'];
  // $content = $_POST['content'];
  // $image = $fileName;

  $sql = 'INSERT INTO `post` SET `users_id` = ?,
                                 `content` = ?,
                                 `post_image` = ?,
                                 `created` = NOW()';
  $data = array($_SESSION['login_user']['id'],$_POST['content'],$fileName);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);




  if(isset($_POST['like'])){

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
    
    echo 'いいねの数は'.$like["con"].'です。<br>';

    // DBにいいね！の数を保存する(更新する)
    $sql = 'UPDATE `post` SET `like_count`=? WHERE `id`=?';
    $data = array($like['con'],$_POST['post_id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    // POST送信を破棄する
    header('Location: profile.php?id='.$_POST['user_id'].'#'.$_POST['post_id']);
    exit();

  }

  if(isset($_POST['comment'])){
    // ツイートするを押すと個々の処理が走ります。
  $comment = htmlspecialchars($_POST['comment']);

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

  header('Location: profile.php?id='.$_POST['user_id'].'#'.$_POST['post_id']);
  exit();
  }
  }
}


  // batch_usersとpostをjoin
  $sql = 'SELECT `post`. * ,`batch_users`.`id` AS user_id, `batch_users`.`nickname`,`batch_users`.`image`
          FROM `post`
          LEFT JOIN `batch_users`
          ON `post`.`users_id` = `batch_users`.`id`
          WHERE `post`.`users_id`=?
          ORDER BY `post`. `created` DESC';
  $data = array($_GET['id']); 
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
 
<!-- ユーザー情報を表示 -->
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


















<!-- 個人タイムラインを表示 -->
<div class="feedClm">

  <!-- 以下のコードはログインユーザーのプロフィール画面の場合に表示   -->

  <?php if ($_GET['id'] == $_SESSION['login_user']['id']) : ?>
    <div id="contributeBox">
    <form method="POST" action="" enctype="multipart/form-data">
      <textarea name="content" rows="7" cols="89%" placeholder="ここから投稿します"></textarea>
        

      <!--   <li><i class="fa fa-picture-o" aria-hidden="true"></i></li> -->
      <div id="sendWrp">
        <div class="imgBox">
          <input type="file" name="post_image" accept="image/*">
        </div>
        <div class="penBox">
          <input type="submit" id="content" value="">
          <i class="fa fa-pencil" aria-hidden="true"></i></li>
        </div>
      </div>
    </form>
    </div>
  <?php endif ; ?>
  <!-- ここまで -->


  <?php foreach($post as $content){ ?>
  <br><br>
    <section>
  <div id="<?php echo $content['id']; ?>"></div>
      <?php 
        // $time = $content['created'] ;
        // $date = substr($time,0,10);
      $day = new DateTime($content['created']);
      ?>

      <!-- 日時 -->
        <p class="date"><?php echo $day->format('Y年m月d日');?></p>
          <div class="nameBox">

            <!-- 投稿ユーザーのページへ遷移 -->
            <a href="profile.php?id=<?php echo $content['user_id'] ;?>">
 
              <!-- ユーザー画像＆ニックネーム -->
              <div class="selfClm"><img src="../image/<?php echo $content['image'];?>" width="80" height="80" alt=""/>
                <?php echo $content['nickname']; ?>
              </div>
            </a>

          <!-- いいね数表示 -->
          <div class="badgeClm"><img src="../assets/img/badge.png" width="13" height="16" alt=""/><?php echo $content['like_count']?>
          </div>
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

      <div id="<?php echo $content['id']; ?>"></div>
      <div id="btnWrp">
        <?php if(!$check){ ?>
          <input type="hidden" name="like" value="like">
          <input type="hidden" name="id" value="<?php echo $content['id']; ?>">
          <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_GET['id']); ?>">
          <div class="like">
            <input type="submit" value="いいね！" class="btn-xs">
            <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
          </div>
        <?php }else{ ?>
          <input type="hidden" name="id" value="<?php echo $content['id']; ?>">
          <input type="hidden" name="like" value="unlike">
          <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_GET['id']); ?>">
          <div class="like">
            <input type="submit" value="いいね取消" class="btn-xs">
            <i class="fa fa-thumbs-o-down" aria-hidden="true"></i>
          </div>
        <?php } ?>
      </form>
       <?php //削除ボタン　?>
          <?php if ($_SESSION['login_user']['id'] == $content['users_id']) : ?>
            <a href="delete.php?id=<?php echo $content['id']; ?>"><i class="fa fa-trash-o" aria-hidden="true"></i> 削除</a>
      　<?php endif ;?>
      </div>
    </div>


 <div class="txtClm col-xs-6">
 <p class="sentence"><?php echo nl2br($content['content']); ?></p>
 

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
    <a onclick="return confirm('削除してもよろしいでしょうか？')" href="delete_com.php?user_id=<?php echo htmlspecialchars($_GET['id']); ?>&id=<?php echo $reply['id']; ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
