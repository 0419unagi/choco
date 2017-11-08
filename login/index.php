<?php 

    session_start();

    require('../dbconnect.php');

    $email = '';
    $password = '';

    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";

    if(!empty($_POST)){
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $errors = array();

        if($email == ''){
            $errors['email'] = 'blank';
        }

        if($password == ''){
            $errors['password'] = 'blank';
        }elseif(strlen($password) >= 9 ){
            $errors['password'] = 'length';
        }elseif(strlen($password) < 4 ){
            $errors['password'] = 'length';
        }

    if(empty($errors)){
        // エラーがなかったら、ログインできるかをチェック
        $sql = 'SELECT * FROM `batch_users` WHERE `email` = ? AND `password` = ?';

        // ?マークを代入する
        $data = array($email,$password);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        // セレクト文を実行した結果を取得する。

        $record = $stmt->fetch(PDO::FETCH_ASSOC);
        // 全件取得させる場合はループさせて、配列に入れる
        // セレクトした内容の一番上(エクセルの表の一番上のみ)だけ取得して存在するかどうかチェックすれば、ログイン判定可能

        // var_dump($record);

        if($record){
            // echo 'ログインできました。タイムラインへ移動します。<br>';
            // 一致した場合はログインする。
            $_SESSION['login_user'] = $record;
            header('Location: top.php');
            exit();
        }else{
            // ログインできなかった場合
            $errors['login'] = 'NG';
        }
    }
    }
 ?>



<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Batch ログイン画面</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/login.css">

</head>
<body>

    <div id="tablecell" >
    <br><br>
    <img src="../assets/img/ill_hand.png" alt="hand_logo" >
    <br><br>
    <h1>BATCH</h1>
    <p>make a history together !</p>
    <br><br><br><br>



    <!-- ログイン -->
    <form method="POST" action="" >

        <?php if(isset($errors['login']) ){ ?>
          <div>
            メールアドレスまたはパスワードが違います。
          </div>
        <?php } ?>

        <br>
        <div class="top">EMAIL ADDRESS</div>
        <input class="text" type="email" name="email"  placeholder="chocomallow@jollibee" value="<?php echo $email; ?>">
        <br>

        <?php if (isset($errors['email']) && $errors['email'] == 'blank'){
            echo "メールアドレスを入力してください".'<br>';
        }
        ?>
        <br><br>
        <div class="top">PASSWORD</div>
        <input class="text" type="password" name="password" placeholder="●●●●●●●●" value="<?php echo $password; ?>">
        <br> 


        <?php if (isset($errors['password']) && $errors['password'] == 'blank'){
             echo 'パスワードは4文字以上8文字以内で入力してください。';
        }elseif(isset($errors['password']) && $errors['password'] == 'length'){
            echo 'パスワードは4文字以上8文字以内で入力してください。';
        }?>

        <br><br>
        <input class="login" type="submit" value="LOGIN">
    </form> 

    <!-- 新規登録 -->
    <br>
    <form method="POST" action="" >
        <a class="create" href="new.php">CREATE ACCOUNT</a>
        <br><br><br><br>
    </form>
    </div>



</body>
</html>