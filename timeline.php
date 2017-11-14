<?php 
// データベース接続


// セッションスタート


// セッションでSESSION[login_user']['id]がなければログインページへお帰りいただく。




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