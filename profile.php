<?php 

require('dbconnect.php');


$username = "";
$nickname = "";
$email = "";
$course = "";
$course_p = "";
$course_e = "";
$datepicker = "";
$datepicker2 = "";
$password = "";

$sql = 'SELECT * FROM `batch_users` WHERE 1';

$data = array();
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

      $record = $stmt->fetch(PDO::FETCH_ASSOC);

      



 ?>


 <!DOCTYPE html>
 <html lang="ja">
 <head>
 	<meta charset="utf-8">
 	<title>マイプロフィール画面</title>
 </head>
 <body>
 hoge
 </body>
 </html>