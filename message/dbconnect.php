<?php 
// MySQLの接続情報
$dsn = 'mysql:dbname=batch_sns;host=localhost';
$user = 'root';
$password = '';
$dbh = new PDO($dsn,$user,$password);
//下記のquery関数の引数は、SQLのクエリなので、"utf8"のようにハイフン(-)は入れない
$dbh->query('SET NAMES utf8');

 ?>