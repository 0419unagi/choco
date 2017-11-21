
<?php  
// 削除機能は押したら削除処理が走るだけ 
// 固有の画面は作らない 
require('../part/header.php'); 

// ログインチェック 
if(!isset($_SESSION['login_user']['id'])){ 
    header('Location: index.php'); 
    exit(); 
} 

  // ここはログインしたユーザーが通る 
  // パラメータチェック 
  if(!isset($_GET['id'])){ 
    header('Location: profile.php'); 
    exit(); 
  } 

    // 本人チェック (削除postが自分のpostかどうか) 
    // ログインユーザーは$_SESSION['login_user']['id']を保持している 
    // 削除するpostのusers_idのカラムが==$_SESSION['login_user']['id'] 
    // であれば削除できる。というif文で対策する。 
    // まずは、postテーブルのid=$_GET['id']のレコードを入手する 
    $sql = 'SELECT * FROM `post` WHERE `id`= ?'; 
    $data = array($_GET['id']); 
    $stmt = $dbh->prepare($sql); 
    $stmt->execute($data); 

    // 1件のみなので、Whileでループさせず、一件目のみFetchする 
    $record = $stmt->fetch(PDO::FETCH_ASSOC); 


    if ($record['users_id'] == $_SESSION['login_user']['id']){
      // 削除(DELETE文のSQLを記述で完了！) 
      $sql = 'DELETE FROM `post` WHERE `id`=?'; 
      $data = array($_GET['id']); 
      $stmt = $dbh->prepare($sql); 
      $stmt->execute($data); 
    }
// error_log(print_r($record,true),"3","../../../../../logs/error_log");

$users_id=$record['users_id']; 

// 削除終了後、profileに飛ばす 
header('Location: profile.php?id='.$users_id); 
exit(); 


 ?>

