<?php 
	// MySQLの接続情報
	$dsn = 'mysql:dbname=BATCH;host=localhost';
	$user = 'root';
	$password = '';
	$dbh = new PDO($dsn,$user,$password);
	$dbh->query('SET NAMES utf8');

 ?>