
<?php
require('../part/header.php');
    // var_dump($_GET);exit;

if(!isset($_SESSION['login_user']['id'])){
    header('Location: index.php');
    exit();
}

  if(!isset($_GET['id'])){
    header('Location: timeline.php');
    exit();
  }
  
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

header('Location: timeline.php');
exit();

 ?>

