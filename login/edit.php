<?php
  // var_dump($_POST);
  // echo "<br><br>";

require('../dbconnect.php');

  session_start();
//初期値にnew.phpのデータベースから持ってくる？

  $username = ($_SESSION["login_user"]["username"]);
  $nickname = ($_SESSION["login_user"]['nickname']);
  $email = ($_SESSION["login_user"]['email']);
  $course = ($_SESSION["login_user"]["course"]);
  $datepicker = ($_SESSION["login_user"]["datepicker"]);
  $datepicker2 = ($_SESSION["login_user"]["datepicker2"]);
  $password = ($_SESSION["login_user"]["password"]);


  $course_p = "";
  $course_e = "";
  $image = "";
  $year = "";
  $birthplace = "";
  $hobby = "";
  $intro = "";

    if ($course =="programming"){
        $course_p = "checked";
    }
    elseif($course =="english"){
        $course_e = "checked";
    }

  if (!empty($_POST)) {
    $username = htmlspecialchars($_POST["username"]);
    $nickname = htmlspecialchars($_POST['nickname']);
    $email = htmlspecialchars($_POST['email']);
    $course = htmlspecialchars($_POST["course"]);
    $datepicker = htmlspecialchars($_POST["datepicker"]);
    $datepicker2 = htmlspecialchars($_POST["datepicker2"]);
    $password = htmlspecialchars($_POST["password"]);
    $year = htmlspecialchars($_POST["year"]);
    $birthplace = htmlspecialchars($_POST["birthplace"]);
    $hobby = htmlspecialchars($_POST["hobby"]);
    $intro = htmlspecialchars($_POST["intro"]);

    $errors = array();


    if ($course =="programming"){
        $course_p = "checked";
    }
    elseif($course =="english"){
        $course_e = "checked";
    }
    if ($year == "") {
      $errors["year"] = "blank";
    }
    if ($birthplace == "") {
      $errors["birthplace"] = "blank";
    }
    if ($hobby == "") {
      $errors["hobby"] = "blank";
    }
    if ($intro == "") {
      $errors["intro"] = "blank";
    }



    $fileName = $_FILES["image"]["name"];

    if (!empty($fileName)) {
      $ext = substr($fileName,-3);
      $ext = strtolower($ext);
      echo "拡張子は" . $ext . "です<br>";

    if ($ext != "jpg" && $ext != "png" && $ext != "gif") {
      $errors["image"] = "extention";
    }
 
    }else{
      $errors["image"] = "blank";
    }



    // if (empty($errors)) {
    //   move_uploaded_file($_FILES["image"]["tmp_name"],"image/" . $username . "_" . $_FILES["image"]["name"]);
    // }


    if (empty($errors)) {
      echo "エラーなし！ok！";

      $_SESSION["user_info"]["year"] = $year;
      $_SESSION["user_info"]["birthplace"] = $birthplace;
      $_SESSION["user_info"]["hobby"] = $hobby;
      $_SESSION["user_info"]["intro"] = $intro;
      $_SESSION["user_info"]["image"] = $username . "_" . $_FILES["image"]["name"];

      $sql ='UPDATE `batch_users` SET `username`=?,`nickname`=?,`email`=?,`course`=?,`datepicker`=?,`datepicker2`=?,`password`=?,`image`=?,`year`=?,`birthplace`=?,`hobby`=?,`intro`=? WHERE id=26';

      // $data = array($username,$nickname,$email,$course,$datepicker,$datepicker2,$password,$image,$year,$birthplace,$hobby,$intro);

      $data = array($_SESSION["login_user"]["username"],$_SESSION["login_user"]["nickname"],$_SESSION["login_user"]["email"],$_SESSION["login_user"]["course"],$_SESSION["login_user"]["datepicker"],$_SESSION["login_user"]["datepicker2"],$_SESSION["login_user"]["password"],$_SESSION["user_info"]["image"],$_SESSION["user_info"]["year"],$_SESSION["user_info"]["birthplace"],$_SESSION["user_info"]["hobby"],$_SESSION["user_info"]["intro"]);

 // var_dump($_SESSION["login_user"]["username"],$_SESSION["login_user"]["nickname"],$_SESSION["login_user"]["email"],$_SESSION["login_user"]["course"],$_SESSION["login_user"]["datepicker"],$_SESSION["login_user"]["datepicker2"],$_SESSION["login_user"]["password"],$_SESSION["user_info"]["image"],$_SESSION["user_info"]["year"],$_SESSION["user_info"]["birthplace"],$_SESSION["user_info"]["hobby"],$_SESSION["user_info"]["intro"],$_SESSION["login_user"]['id']);exit();


      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

      header("Location:edit.php");
      exit();

    }

  }


  function optionLoop($start, $end , $value = null){
    for ($i = $start; $i <= $end; $i++) { 
      if (isset($value) && $value == $i) {
        echo"<option value=\"{$i}\" selected=\"selected\">{$i}</option>";}
      else{
        echo"<option value=\"{$i}\">{$i}</option>";}
      }
    }

  $pref = ['1'=>'北海道','2'=>'青森県','3'=>'岩手県','4'=>'宮城県','5'=>'秋田県','6'=>'山形県','7'=>'福島県','8'=>'茨城県','9'=>'栃木県','10'=>'群馬県','11'=>'埼玉県','12'=>'千葉県','13'=>'東京都','14'=>'神奈川県','15'=>'新潟県','16'=>'富山県','17'=>'石川県','18'=>'福井県','19'=>'山梨県','20'=>'長野県','21'=>'岐阜県','22'=>'静岡県','23'=>'愛知県','24'=>'三重県','25'=>'滋賀県','26'=>'京都府','27'=>'大阪府','28'=>'兵庫県','29'=>'奈良県','30'=>'和歌山県','31'=>'鳥取県','32'=>'島根県','33'=>'岡山県','34'=>'広島県','35'=>'山口県','36'=>'徳島県','37'=>'香川県','38'=>'愛媛県','39'=>'高知県','40'=>'福岡県','41'=>'佐賀県','42'=>'長崎県','43'=>'熊本県','44'=>'大分県','45'=>'宮崎県','46'=>'鹿児島県','47'=>'沖縄県'];

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/login.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>マイプロフ編集画面</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
    $(function() {
    $("#datepicker,#datepicker2").datepicker().datepicker2();
  } );
  </script>

</head>
<body>

<div id="tablecellboke">
  <div class="container">
    <div class="row">

      <div class="col-xs-3">
       <div class="batch">

        <img src="../assets/img/logomark.png" alt="hand_logo" >
        <h1>BATCH</h1>
        <p>make a history together!</p>
        <br>
        <h2>My Profile Edit</h2>

        <form method="POST" action="" enctype="multipart/form-data">
        <br>
        <div class="top"></div><br>
        <input type="file" name="image" accept="image/*">
        <br><br>

        <?php if (isset($errors["image"])
              && $errors["image"] == "blank") { ?>
        <div>
          *プロフィール画像を選択してください
        </div>

        <?php }elseif (isset($errors["image"])
              && $errors["image"] == "extention") {?>
        <div>
          *使用できる拡張子は「jpg」または「png」、「gif」のみです。
        </div>

        <?php } ?>
        </div>
      </div>


  
      <div class="col-xs-3"><br><br>
        <div class="top">FULLNAME</div><br>
          <input class="text" type="text" name="username" placeholder="小川　ともゆき" value="<?php echo $username; ?>">
          <br><br>
          <?php if (isset($errors["username"]) 
      && $errors["username"] == "blank"): ?>
          <div>
            *名前を入力してください
          </div>
          <?php endif; ?>


        <div class="top">NICKNAME</div><br>
          <input class="text" type="text" name="nickname" placeholder="tomtom" value="<?php echo $nickname; ?>">
          <br><br>
          <?php if (isset($errors["nickname"]) 
    && $errors["nickname"] == "blank"): ?>
          <div>
            *ニックネームを入力してください
          </div>
          <?php endif; ?>


        <div class="top">EMAIL</div><br>
          <input class="text" type="email" name="email" placeholder="seed@com" value="<?php echo $email; ?>">
          <br><br>
          <?php if (isset($errors["email"]) 
      && $errors["email"] == "blank"): ?>
          <div>
            *メールアドレスを入力してください
          </div>
          <?php endif; ?>


        <div class="top">COURSE<br><br>
          <input type="radio" name="course" value="programming" <?php echo $course_p; ?> >Programming
          <input type="radio" name="course" value="english" <?php echo $course_e; ?> >English
          </div><br>
          <?php if (isset($errors["course"]) 
      && $errors["course"] == "blank"): ?>
          <div>
            *コースを選択してください
          </div>
          <?php endif; ?>


        <div class="top">ENTRANCE</div><br>
          <input class="text" type="text" name="datepicker" id="datepicker" value="<?php echo $datepicker; ?>">

        <br><br>
        <div class="top">GRADUATION</div><br>
          <input class="text" type="text" name="datepicker2" id="datepicker2" value="<?php echo $datepicker2; ?>">
        <br><br>

        <?php if (isset($errors["datepicker"]) && (isset($errors["datepicker2"])) && $errors["datepicker"] == "blank" && $errors["datepicker2"] == "blank"): ?>
        <div>
          *入学日・卒業日を選択してください
        </div>
        <?php endif; ?>

        <?php if (isset($errors["datepicker"]) 
      && $errors["datepicker"] == "blank" && (!empty($datepicker2))): ?>
        <div>
          *入学日を選択してください
        </div>
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
          <?php endif; ?>
      </div>



      <div class="col-xs-3">
        <br><br>
        <div class="top">BIRTH DAY</div><br>
          <select name="year">
            <?php optionLoop("1950" , "2020" , "1980");?>
          </select>
          <select name="month">
            <?php optionLoop("1" , "12" , "1");?>
          </select>
          <select name="day">
            <?php optionLoop("1" , "31" , "1");?>
          </select>
          <?php if(isset($errors["year"]) 
    && $errors["year"] == "blank"): ?>
          <div>
            *生年月日を選択してください
          </div>
          <?php endif; ?>
          <br><br>

        <div class="top">PLACE</div><br>
          <select name="birthplace">
            <?php foreach ($pref as $v): ?>
            <option value="<?php echo $v; ?>"><?php echo $v; ?></option>
            <?php endforeach; ?>
          </select>
          <?php if (isset($errors["birthplace"]) 
      && $errors["birthplace"] == "blank"): ?>
          <div>
            *出身地を選択してください
          </div>
          <?php endif; ?>
          <br><br>


        <div class="top">HOBBY</div><br>
          <input class="text" type="textbox" style="width: 300px;" name="hobby" placeholder="旅行,読書,器械体操" value="<?php echo $hobby; ?>">
          <?php if (isset($errors["hobby"]) 
      && $errors["hobby"] == "blank"): ?>
          <div>
            *趣味を入力してください
          </div>
          <?php endif; ?>
          <br><br>


        <div class="top">INTRODUCE</div><br>
          <textarea class="text" name="intro" style="width: 300px; height: 320px;" placeholder="自己紹介文と共に、SNSなどのURLを貼っていただくと、他のユーザーがあなたのことをより理解してくれます！" value="<?php echo $intro; ?>"></textarea>
          <?php if (isset($errors["intro"]) 
      && $errors["intro"] == "blank"): ?>
          <div>
            自己紹介を入力してください！<br>短くても構いません！
          </div>
          <?php endif; ?>
          <br><br>
      </div>

      <div class="position">
        <div class="col-xs-3">
          <input class="login" type="submit" value="SAVE">
        </div>
      </div>

  </form>
</div>
</div>
</div>
</div>
</div>


</body>
</html>


