<?php
  var_dump($_POST);
  echo "<br><br>";

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



    if (empty($errors)) {
      move_uploaded_file($_FILES["image"]["tmp_name"],"image/" . $username . "_" . $_FILES["image"]["name"]);
    }


    if (empty($errors)) {
      echo "エラーなし！ok！";

      $_SESSION["user_info"]["year"] = $year;
      $_SESSION["user_info"]["birthplace"] = $birthplace;
      $_SESSION["user_info"]["hobby"] = $hobby;
      $_SESSION["user_info"]["intro"] = $intro;
      $_SESSION["user_info"]["image"] = $username . "_" . $_FILES["image"]["name"];

      $sql ='UPDATE `batch_users` SET `id`=?,`username`=?,`nickname`=?,`email`=?,`course`=?,`datepicker`=?,`datepicker2`=?,`password`=?,`image`=?,`year`=?,`birthplace`=?,`hobby`=?,`intro`=?,`created`=?,`modified`=NOW() WHERE 1';

      // $data = array($username,$nickname,$email,$course,$datepicker,$datepicker2,$password,$image,$year,$birthplace,$hobby,$intro);

      $data = array($_SESSION["login_user"]["username"],$_SESSION["login_user"]["nickname"],$_SESSION["login_user"]["email"],$_SESSION["login_user"]["course"],$_SESSION["login_user"]["datepicker"],$_SESSION["login_user"]["datepicker2"],$_SESSION["login_user"]["password"],$_SESSION["user_info"]["image"],$_SESSION["user_info"]["year"],$_SESSION["user_info"]["birthplace"],$_SESSION["user_info"]["hobby"],$_SESSION["user_info"]["intro"]);
      
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
  <form method="POST" action="" enctype="multipart/form-data">
    <label>プロフィール画像</label><br>
    <input type="file" name="image" accept="image/*">
    <br><br>
    <?php if (isset($errors["image"])
      && $errors["image"] == "blank") { ?>
      <div class="alert alert-danger">
        *プロフィール画像を選択してください
      </div>
    <?php }elseif (isset($errors["image"])
      && $errors["image"] == "extention") {?>
      <div class="alert alert-danger">
        *使用できる拡張子は「jpg」または「png」、「gif」のみです。
      </div>
      <?php } ?>


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
      <div class="alert alert-danger">
        *ニックネームを入力してください
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


    <label>生年月日</label><br>
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
    <div class="alert alert-danger">
      *生年月日を選択してください
    </div>
    <?php endif; ?>
    <br><br>

    <label>出身地</label><br>
    <select name="birthplace">
      <?php foreach ($pref as $v): ?>
        <option value="<?php echo $v; ?>"><?php echo $v; ?></option>
      <?php endforeach; ?>
    </select>
    <?php if (isset($errors["birthplace"]) 
      && $errors["birthplace"] == "blank"): ?>
      <div class="alert alert-danger">
        *出身地を選択してください
      </div>
    <?php endif; ?>
    <br><br>


    <label>趣味</label><br>
    <input type="textbox" name="hobby" placeholder="旅行,読書,器械体操" value="<?php echo $hobby; ?>">
    <?php if (isset($errors["hobby"]) 
      && $errors["hobby"] == "blank"): ?>
        <div class="alert alert-danger">
          *趣味を入力してください
        </div>
    <?php endif; ?>
    <br><br>


     <label>自己紹介</label><br>
     <textarea name="intro" style="width: 300px; height: 80px;" placeholder="自己紹介文と共に、SNSなどのURLを貼っていただくと、他のユーザーがあなたのことをより理解してくれます！" value="<?php echo $intro; ?>"></textarea>
     <?php if (isset($errors["intro"]) 
      && $errors["intro"] == "blank"): ?>
      <div class="alert alert-danger">
        自己紹介を入力してください！短くても構いません！
      </div>
    <?php endif; ?>
     <br><br>

     <input type="submit" value="内容を変更する">




  </form>

</body>
</html>


