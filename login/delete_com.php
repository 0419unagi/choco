
<?php
require('../part/header.php');


if(!isset($_SESSION['login_user']['id'])){
    header('Location: index.php');
    exit();
}


  if(!isset($_GET['id'])){
    header('Location: profile.php');
    exit();
  }


// ここ直せば分かる。
  // トムさん教えてください
  // 最初で最後のお願いです。
    $sql = 'SELECT * FROM `batch_users` WHERE `id`= ?';
    $data = array($_GET['user_id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $postPass = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql = 'SELECT * FROM `comment` WHERE `id`= ?';
    $data = array($_GET['id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $record = $stmt->fetch(PDO::FETCH_ASSOC);


    if ($record['users_id'] == $_SESSION['login_user']['id']){

      $sql = 'DELETE FROM `comment` WHERE `id`=?';
      $data = array($_GET['id']);
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);
    }

    $users_id=$postPass['id'];
    $post_id=$record['post_id'];

header('Location: profile.php?id='.$users_id.'#'.$post_id);
exit();


 ?>