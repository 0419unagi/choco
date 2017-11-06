<?php  
  var_dump($_POST);
  echo"<br>";

  session_start();

  require('../dbconnect.php');



  // 初期値
  $username = "";
  $nickname = "";
  $email = "";
  $course = "";
  $course_p = "";
  $course_e = "";
  $datepicker = "";
  $datepicker2 = "";
  $password = "";

  if (!empty($_POST)) {
    $username = htmlspecialchars($_POST["username"]);
    $nickname = htmlspecialchars($_POST["nickname"]);
    $email = htmlspecialchars($_POST["email"]);
    if(isset($_POST["course"])){
      $course = htmlspecialchars($_POST["course"]); 
    }
    $datepicker = htmlspecialchars($_POST["datepicker"]);
    $datepicker2 = htmlspecialchars($_POST["datepicker2"]);
    $password = htmlspecialchars($_POST["password"]);

    $errors = array();

    if ($username == "") {
      $errors["username"] = "blank";
    }
    if ($nickname == "") {
      $errors["nickname"] = "blank";
    }
    if ($email == "") {
      $errors["email"] = "blank";
    }
    if ($course == "") {
      $errors["course"] = "blank";
    }
    elseif($course =="programming"){
        $course_p = "checked";
    }
    elseif($course =="english"){
        $course_e = "checked";
    }
    if ($datepicker == "") {
      $errors["datepicker"] = "blank";
    }
    if ($datepicker2 == "") {
      $errors["datepicker2"] = "blank";
    }
    if ($password == "") {
      $errors["password"] = "blank";
    }
    elseif (strlen($password) < 4 ) {
      $errors["password"] = "length";
    }
    elseif (strlen($password) > 8 ) {
      $errors["password"] = "length";
    }

    if (empty($errors)) {
      echo "エラーなし！ok！";

      $_SESSION["login_user"]["id"] = 1;
      $_SESSION["login_user"]["username"] = $username;
      $_SESSION["login_user"]["nickname"] = $nickname;
      $_SESSION["login_user"]["email"] = $email;
      $_SESSION["login_user"]["course"] = $course;
      $_SESSION["login_user"]["course_p"] = $course_p;
      $_SESSION["login_user"]["course_e"] = $course_e;
      $_SESSION["login_user"]["datepicker"] = $datepicker;
      $_SESSION["login_user"]["datepicker2"] = $datepicker2;
      $_SESSION["login_user"]["password"] = $password;

      $sql = 'INSERT INTO `batch_users` SET `username` = ?, `nickname` = ?, `email` =? , `course` =? , `datepicker` =? , `datepicker2` =? , `password` = ?,`create` = NOW()';

      $data = array($username,$nickname,$email,$course,$datepicker,$datepicker2,$password);
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

      header("Location:confirm.php");
      exit();
      }

    }

?>



<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>jQuery UI Datepicker - Default functionality</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
    $(function() {
    $("#datepicker,#datepicker2").datepicker().datepicker2();
  } );
  </script>



  <title>新規登録</title>
</head>
<body>
  <form method="POST" action="" enctype="multipart/form-data">

    <label>名前</label><br>
    <input type="text" name="username" placeholder="シードくん" value="<?php echo $username; ?>">
    <br><br>
    <?php if (isset($errors["username"]) 
      && $errors["username"] == "blank"): ?>
      <div class="alert alert-danger">
        *名前を入力してください
      </div>
    <?php endif; ?>


    <label>ニックネーム</label><br>
    <input type="text" name="nickname" placeholder="シード" value="<?php echo $nickname; ?>">
    <br><br>
    <?php if (isset($errors["nickname"]) 
    && $errors["nickname"] == "blank"): ?>
      <div class="alert alert-danger">*ニックネームを入力してください
      </div>
    <?php endif; ?>


    <label>メールアドレス</label><br>
    <input type="email" name="email" placeholder="seed@com" value="<?php echo $email; ?>">
    <br><br>
    <?php if (isset($errors["email"]) 
      && $errors["email"] == "blank"): ?>
      <div class="alert alert-danger">
        *メールアドレスを入力してください
      </div>
    <?php endif; ?>


    <label>コース</label><br>
    <input type="radio" name="course" value="programming" <?php echo $course_p; ?> >プログラミング(Web/iOS)
    <input type="radio" name="course" value="english" <?php echo $course_e; ?> >英語
    <br><br>
    <?php if (isset($errors["course"]) 
      && $errors["course"] == "blank"): ?>
      <div class="alert alert-danger">
        *コースを選択してください
      </div>
    <?php endif; ?>


    <label>留学期間</label><br>
    <input type="text" name="datepicker" id="datepicker" value="<?php echo $datepicker; ?>">〜<input type="text" name="datepicker2" id="datepicker2" value="<?php echo $datepicker2; ?>">
    <br><br>

    <?php if (isset($errors["datepicker"]) && (isset($errors["datepicker2"])) && $errors["datepicker"] == "blank" && $errors["datepicker2"] == "blank"): ?>
      <div class="alert alert-danger">
        *留学期間を選択してください
      </div>
    <?php endif; ?>

    <?php if (isset($errors["datepicker"]) 
      && $errors["datepicker"] == "blank" && (!empty($datepicker2))): ?>
      <div class="alert alert-danger">
        *留学開始日を選択してください
      </div>
    <?php endif; ?>
    <?php if (isset($errors["datepicker2"]) 
      && $errors["datepicker2"] == "blank" && (!empty($datepicker))): ?>
      <div class="alert alert-danger">
        *留学終了日を選択してください
      </div>
    <?php endif; ?>


    <label>パスワード</label><br>
    <input type="password" name="password" value="<?php echo $password; ?>">
    <br><br>
    <?php if (isset($errors["password"]) 
      && $errors["password"] == "blank"): ?>
      <div class="alert alert-danger">
        *パスワードを入力してください
      </div>
    <?php endif; ?>
    <?php if(isset($errors["password"]) 
    && $errors["password"] == "length"): ?>
      <div class="alert alert-danger">
        *パスワードは4文字以上8文字以内で入力してください
      </div>
    <?php endif; ?>


    <input type="submit" value="確認画面へ"><br>



  </form>

</body>
</html>



