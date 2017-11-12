<?php 
// 投稿フォーム




 // $fileName = $_FILES['image']['name'];


 //    if(!empty($fileName)){
 //        $ext = substr($fileName,-3);
 //        $ext = strtolower($ext);
 //        echo '拡張子は'. $ext .'です<br>';
 //        if($ext != 'jpg' && $ext != 'png' && $ext != 'gif'){
 //            $errors['image'] = 'extension';
 //        }




// データベース接続
// require('dbconnect.php');

// if(!empty($_POST)){

//       $content = $_POST['content'];
      
//       $sql = 'INSERT INTO `post` SET `content` = ?, `image` =?, `create` =NOW()';

//       $data = array($content,$image);
//       $stmt = $dbh->prepare($sql);
//       $stmt->execute($data);
//     }


 ?>




<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>timeline</title>
</head>
<body>


<form method="POST" action="">
	<textarea name="content" cols="100" rows="20"></textarea>
	<br>
    <input type="file" name="post_image" accept="image/*">
    <br>
    <?php if(isset($errors['post_image']) 
                && $errors['post_image'] == 'blank'){ ?>
      <div class="alert alert-danger">
        プロフィール画像を選択してください。
      </div>
    <?php }elseif(isset($errors['image'])
                && $errors['post_image'] == 'extension'){ ?>
      <div class="alert alert-danger">
        使用できる拡張子は「jpg」または「png」または「gif」のみです。
      </div>
    <?php } ?>
    <input type="submit" value="投稿">
</form>

</body>
</html>