<?php  
  // var_dump($_POST);
  // echo"<br>";

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


    $sql = 'SELECT `email` FROM `batch_users` WHERE email=?';
    $data = array($email);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    // $userdata = array();
    // while(true){
    $data = $stmt->fetch(PDO::FETCH_ASSOC);


    if ($username == "") {
      $errors["username"] = "blank";
    }
    if ($nickname == "") {
      $errors["nickname"] = "blank";
    }
    if ($email == "") {
      $errors["email"] = "blank";
    }elseif($email == $data['email']){
      $errors["email"] = "SAME";
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
  <title>BATCH ユーザー情報登録</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <link rel="stylesheet" href="../assets/css/login.css">
  <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
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
  <div id="tablecellboke">
  <div class="container">
    <div class="row">
      <div class="col-xs-3"></div>

      <div class="col-xs-3">
        <div class="batch">
          <!-- <br><br><br><br><br><br><br> -->
          <img src="../assets/img/logomark.png" alt="hand_logo" >
          <h1>BATCH</h1>
          <p>make a history together!</p>
          <br>
          <h2>Sign up</h2>
        </div>
      </div>
  
      <div class="col-xs-3">
        <form method="POST" action="" enctype="multipart/form-data">
        <br>
        <div class="top">FULLNAME</div><br>
        <input class="text" type="text" name="username" placeholder="小川　ともゆき" value="<?php echo $username; ?>">
        <br><br>
        <?php if (isset($errors["username"]) 
          && $errors["username"] == "blank"): ?>
          <div>
            *名前を入力してください
          </div><br>
        <?php endif; ?>


        <div class="top">NICKNAME</div><br>
        <input class="text" type="text" name="nickname" placeholder="tomtom" value="<?php echo $nickname; ?>">
        <br><br>
        <?php if (isset($errors["nickname"]) 
        && $errors["nickname"] == "blank"): ?>
          <div>
            *ニックネームを入力してください
          </div><br>
        <?php endif; ?>


        <div class="top">EMAIL ADDRESS</div><br>
        <input class="text" type="email" name="email" placeholder="seed@com" value="<?php echo $email; ?>">
        <br><br>
          <?php if (isset($errors["email"]) && $errors["email"] == "blank"){ ?>
            <div>
              *メールアドレスを入力してください
            </div><br>
              <?php }elseif(isset($errors['email']) && $errors['email'] == "SAME"){ ?>
            <div>
              <?php echo $data['email'] ;?>というアドレスは使えません。
            </div>
          <?php } ?>
        



        <div class="top">COURSE<br><br>
        <input type="radio" name="course" value="programming" <?php echo $course_p; ?> >Programming
        <input type="radio" name="course" value="english" <?php echo $course_e; ?> >English
        </div><br><br>
        <?php if (isset($errors["course"]) 
          && $errors["course"] == "blank"): ?>
          <div>
            *コースを選択してください
          </div><br>
        <?php endif; ?>


        <div class="top">ENTRANCE</div><br>
        <input class="text" type="text" name="datepicker" id="datepicker" value="<?php echo $datepicker; ?>">
        <br><br>
        <?php if (isset($errors["datepicker"]) 
          && $errors["datepicker"] == "blank" && (!empty($datepicker2))): ?>
          <div>
            *入学日を選択してください
          </div><br>
        <?php endif; ?>

        <div class="top">GRADUATION</div><br>
        <input class="text" type="text" name="datepicker2" id="datepicker2" value="<?php echo $datepicker2; ?>">
        <br><br>

        <?php if (isset($errors["datepicker"]) && (isset($errors["datepicker2"])) && $errors["datepicker"] == "blank" && $errors["datepicker2"] == "blank"): ?>
          <div>
            *入学日・卒業日を選択してください
          </div><br>
        <?php endif; ?>

          <?php if (isset($errors["datepicker2"]) 
          && $errors["datepicker2"] == "blank" && (!empty($datepicker))): ?>
          <div>
            *卒業日を選択してください
          </div>
        <?php endif; ?>


        <div class="top">PASSWORD</div><br>
        <input class="text" type="password" name="password" value="<?php echo $password; ?>">
        <br><br>
        <?php if (isset($errors["password"]) 
          && $errors["password"] == "blank"): ?>
          <div>
            *パスワードを入力してください
          </div>
        <?php endif; ?>
        <?php if(isset($errors["password"]) 
        && $errors["password"] == "length"): ?>
          <div>
            *パスワードは4文字以上8文字以内で入力してください
          </div>
          <br><br>
        <?php endif; ?>
      </div>
      <a class="back" href="index.php"><i class="fa fa-arrow-left" aria-hidden="true"></i>
</a>
      <div class="position">
      <div class="col-xs-3">
        <input class="login" type="submit" value="CHECK PAGE"><br>
      </div>
      </div>

      </form>
    </div>
  </div>
  </div>


</body>
</html>



