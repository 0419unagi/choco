<?php
  var_dump($_POST);
  echo "<br><br>";


  session_start();
//初期値にnew.phpのデータベースから持って切る？

  $username = ($_SESSION["user_info"]["username"]);
  $nickname = ($_SESSION["user_info"]['nickname']);
  $email = ($_SESSION["user_info"]['email']);
  $course = ($_SESSION["user_info"]["course"]);
  $datepicker = ($_SESSION["user_info"]["datepicker"]);
  $datepicker2 = ($_SESSION["user_info"]["datepicker2"]);
  $password = ($_SESSION["user_info"]["password"]);

  $image = "";
  $year = "";
  $birthplace = "";
  $hobby = "";
  $intro = "";


  if (!empty($_POST)) {
    $year = htmlspecialchars($_POST["year"]);
    $birthplace = htmlspecialchars($_POST["birthplace"]);
    $hobby = htmlspecialchars($_POST["hobby"]);
    $intro = htmlspecialchars($_POST["intro"]);

    $errors = array();

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
    else{
      $errors["image"] = "blank";
    }
  }

    // if (empty($errors)) {
    //   move_uploaded_file($_FILES["image"]["tmp_name"],"../" destination)
    // }
  






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
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
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

  <title>マイページ編集</title>
</head>
<body>
  <form method="POST" action="" enctype="multipart/form-data">
    <label>プロフィール画像</label><br>
    <input type="file" name="image" accept="image/*">
    <br><br>


    <label>名前</label><br>
    <input type="text" name="username" value="<?php echo $username; ?>">
    <br><br>
    
    <label>ニックネーム</label><br>
    <input type="text" name="nickname" value="<?php echo $nickname; ?>">
    <br><br>

    <label>メールアドレス</label><br>
    <input type="text" name="email" value="<?php echo $email; ?>">
    <br><br>

    <label>コース</label><br>
    <input type="radio" name="course" value="programming">プログラミング(Web/iOS)
    <input type="radio" name="course" value="english">英語
    <br><br>

    <label>留学期間</label><br>
    <input type="text" name="datepicker" id="datepicker" value="<?php echo $datepicker; ?>">〜<input type="text" name="datepicker2" id="datepicker2" value="<?php echo $datepicker2; ?>">
    <br><br>

<!-- ここまではデータベースから引っ張ってくる？ -->


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
    <br><br>

    <label>出身地</label><br>
    <select name="birthplace">
      <?php foreach ($pref as $v): ?>
        <option value="<?php echo $v; ?>"><?php echo $v; ?></option>
      <?php endforeach; ?>
    </select>
    <br><br>

    <label>趣味</label><br>
    <input type="textbox" name="hobby">
    <input type="textbox" name="hobby">
    <input type="textbox" name="hobby">
    <br><br>



    <label>自己PR</label><br>
    <input type="textarea" name="intro" value="<?php echo $intro; ?>">
    <br><br>

    <label>SNS</label><br>
twitter
FB
insta




  </form>

</body>
</html>

