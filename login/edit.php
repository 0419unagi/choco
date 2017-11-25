<?php 

require('../dbconnect.php'); 

    session_start(); 


    $user_id = $_SESSION['login_user']['id']; 
    // $id = $_SESSION["login_user"]["id"];
    $sql = 'SELECT * FROM `batch_users` WHERE `id`=?'; 
    $data = array($_SESSION["login_user"]["id"]); 
    $stmt = $dbh->prepare($sql); 
    $stmt->execute($data); 
         
    $record = $stmt->fetch(PDO::FETCH_ASSOC); 
    $user_info = $record; 

    
    $id = $user_info["id"];
    $username = $user_info['username']; 
    $nickname = $user_info['nickname']; 
    $email = $user_info['email']; 
    $course = $user_info['course']; 
    $course_p = $user_info['course'];
    $course_e = $user_info['course'];
    $datepicker = $user_info['datepicker']; 
    $datepicker2 = $user_info['datepicker2']; 
    $password = $user_info['password']; 
    $image = $user_info['image']; 
    $year = $user_info['year']; 
    $month = $user_info['month']; 
    $day = $user_info['day']; 
    $birthplace = $user_info['birthplace']; 
    $hobby = $user_info['hobby']; 
    $intro = $user_info['intro']; 


    // $_SESSION['login_user']['id'] = $id;

    if ($course =="programming"){
        $course_p = "checked";
    }
    elseif($course =="english"){
        $course_e = "checked";
    }

    if (!empty($_POST)) { 
        $username = $_POST["username"]; 
        $nickname = $_POST['nickname']; 
        $email = $_POST['email']; 
        $course = $_POST["course"]; 
        $datepicker = $_POST["datepicker"]; 
        $datepicker2 = $_POST["datepicker2"]; 
        $password = $_POST["password"]; 
        $year = $_POST["year"]; 
        $month = $_POST['month']; 
        $day = $_POST['day']; 
        $birthplace = $_POST["birthplace"]; 
        $hobby = $_POST["hobby"]; 
        $intro = $_POST["intro"]; 

 
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

        if ($datepicker == "") { 
            $errors["datepicker"] = "blank"; 
        } 

        if ($datepicker2 == "") { 
            $errors["datepicker2"] = "blank"; 
        } 

        if ($password == "") { 
            $errors["password"] = "blank"; 
        }elseif (strlen($password) < 4 ) { 
            $errors["password"] = "length"; 
        }elseif (strlen($password) > 8 ) { 
            $errors["password"] = "length"; 
        } 

        if ($year == "") { 
            $errors["year"] = "blank"; 
        } 

        if ($month == "") { 
            $errors["month"] = "blank"; 
        } 

        if ($day == "") { 
            $errors["day"] = "blank"; 
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


            // ファイル名を取得する（アップロードされなければ空）
            $fileName = $_FILES['image']['name']; 
            // フラグを立てる
            $f_flag=false;
            if(empty($fileName) && !empty($_SESSION["login_user"]['image'])){
                $f_flag=true;
            }

            //アップロードされた、または過去にアップロードしてたら
            if(!empty($fileName) || $f_flag==true ){
                // アップロードしてたらファイルの拡張子チェック

                if(!empty($fileName)){
                    $ext = substr($fileName,-3); 
    
                    $ext = strtolower($ext); 
                    if ($ext != "jpg" && $ext != "png" && $ext != "gif") { 
                        $errors["image"] = "extention"; 
                    }
                      // else{
                      //   $errors['image'] = "blank";
                      // }
                }else{
                  //アップロードしてなかったら、現在の画像を選択
                  $fileName=$_SESSION["login_user"]['image'];
                }
               // エラーが空の時
               if (empty($errors['image'])) {
             

               // 画像を保存する
                  if(!empty($fileName)){
                    // echo$fileName;
                    move_uploaded_file($_FILES["image"]["tmp_name"],'../image/'.$fileName); 
                       error_log(print_r('$fileName',true),"3","../../../../../logs/error_log");
                  
                  }
                  // イメージのフォルダの中にファイルを保存する
              }
           
                $sql ='UPDATE `batch_users` SET `username`=?,`nickname`=?,`email`=?,`course`=?,`datepicker`=?,`datepicker2`=?,`password`=?,`image`=?,`year`=?,`month`=?,`day`=?,`birthplace`=?,`hobby`=?,`intro`=? WHERE id=?'; 
                $data = array($username,$nickname,$email,$course,$datepicker,$datepicker2,$password,$fileName,$year,$month,$day,$birthplace,$hobby,$intro,$id); 
                $stmt = $dbh->prepare($sql); 
                $stmt->execute($data); 
                // セッションデータを更新する select?
                $_SESSION['login_user']['image']=$fileName;
                header('Location: top.php?id=' . $_SESSION['login_user']['id']);
                exit();
            }else{ 
              $errors["image"] = "blank"; 
            }  
        } 
    

 
function optionLoop($start, $end , $value = null){ 
    for ($i = $start; $i <= $end; $i++) {  
        if (isset($value) && $value == $i) { 
            echo"<option value=\"{$i}\" selected=\"selected\">{$i}</option>"; 
        }else{ 
            echo"<option value=\"{$i}\">{$i}</option>"; 
        } 
    } 
} 

$pref = ['1'=>'北海道','2'=>'青森県','3'=>'岩手県','4'=>'宮城県','5'=>'秋田県','6'=>'山形県','7'=>'福島県','8'=>'茨城県','9'=>'栃木県','10'=>'群馬県','11'=>'埼玉県','12'=>'千葉県','13'=>'東京都','14'=>'神奈川県','15'=>'新潟県','16'=>'富山県','17'=>'石川県','18'=>'福井県','19'=>'山梨県','20'=>'長野県','21'=>'岐阜県','22'=>'静岡県','23'=>'愛知県','24'=>'三重県','25'=>'滋賀県','26'=>'京都府','27'=>'大阪府','28'=>'兵庫県','29'=>'奈良県','30'=>'和歌山県','31'=>'鳥取県','32'=>'島根県','33'=>'岡山県','34'=>'広島県','35'=>'山口県','36'=>'徳島県','37'=>'香川県','38'=>'愛媛県','39'=>'高知県','40'=>'福岡県','41'=>'佐賀県','42'=>'長崎県','43'=>'熊本県','44'=>'大分県','45'=>'宮崎県','46'=>'鹿児島県','47'=>'沖縄県'];

// var_dump($user_info['birthplace']);

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
  <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
    $(function() {
    $("#datepicker,#datepicker2").datepicker().datepicker2();
  } );
  </script>

</head>


<body>
  <div class="container">
    
        <a class="back" href="top.php"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>

        <form method="POST" action="" enctype="multipart/form-data">
          <div class="clmWrp">
              <div class="clm" id="clm_1">
            <div id="logoBox">
              <img src="../assets/img/logomark.png" alt="hand_logo" width="81" height="135" id="logo" >
              <h1>BATCH</h1>
              <p id="sub">make a history together</p>
            </div>
            <div id="ctgBox">
              <div class="line"></div>
              <h2>PROFILE EDIT</h2>
              <div class="line"></div>
            </div>
            
            
             <input type="file" name="image" accept="image/*">
             <img src="../image/<?php echo $image; ?>" width="80px">
             <?php if (isset($errors["image"])
                   && $errors["image"] == "blank") { ?>
             <div>*プロフィール画像を選択してください</div>
             <?php }elseif (isset($errors["image"])
                   && $errors["image"] == "extention") {?>
             <div>*使用できる拡張子は「jpg」または「png」、「gif」のみです。</div>
             <?php } ?>
      </div>

              <div class="clm" id="clm_2">
                 <div class="list">
                   <p class="ttl">FULLNAME</p>
                   <input class="text" type="text" name="username" placeholder="小川 ともゆき" value="<?php echo $username; ?>">
                   <?php if (isset($errors["username"])  && $errors["username"] == "blank"): ?>
                   <p class="att">※名前を入力してください</p>
                   <?php endif; ?>
                 </div>

                 <div class="list">
                   <p class="ttl">NICKNAME</p>
                   <input class="text" type="text" name="nickname" placeholder="tomtom" value="<?php echo $nickname; ?>">
                   <?php if (isset($errors["nickname"]) && $errors["nickname"] == "blank"): ?>
                    <p class="att">※ニックネームを入力してください</p>
                   <?php endif; ?>
                 </div>

                 <div class="list">
                   <p class="ttl">EMAIL</p>
                   <input class="text" type="email" name="email" placeholder="seed@com" value="<?php echo $email; ?>">
                   <?php if (isset($errors["email"]) && $errors["email"] == "blank"): ?>
                   <p class="att">※メールアドレスを入力してください</p>
                   <?php endif; ?>
                 </div>

                 <div class="list">
                   <p class="ttl">COURSE</p>
                     <input type="radio" name="course" value="programming" <?php echo $course_p; ?> > <p class="course">Programming</p>　
                     <input type="radio" name="course" value="english" <?php echo $course_e; ?> > <p class="course">English</p>
                     <?php if (isset($errors["course"]) && $errors["course"] == "blank"): ?>
                     <p class="att">※コースを選択してください</p>
                     <?php endif; ?>
                 </div>

                 <div class="list">
                   <p class="ttl">ENTRANCE</p>
                   <input class="text underlineWrp" type="text" name="datepicker" id="datepicker" value="<?php echo $datepicker; ?>"><br><br>
                   <p class="ttl">GRADUATION</p>
                   <input class="text" type="text" name="datepicker2" id="datepicker2" value="<?php echo $datepicker2; ?>">
                   <?php if (isset($errors["datepicker"]) && (isset($errors["datepicker2"])) && $errors["datepicker"] == "blank" && $errors["datepicker2"] == "blank"): ?>
                    <p class="att">*入学日・卒業日を選択してください</p>
                   <?php endif; ?>
                   <?php if (isset($errors["datepicker"]) && $errors["datepicker"] == "blank" && (!empty($datepicker2))): ?>
                    <p class="att"> *入学日を選択してください</p>
                   <?php endif; ?>
                   <?php if (isset($errors["datepicker2"]) && $errors["datepicker2"] == "blank" && (!empty($datepicker))): ?>
                    <p class="att">*卒業日を選択してください</p>
                   <?php endif; ?>
                  </div>

                 <div class="list">
                   <p class="att">PASSWORD</p>
                   <input class="text" type="password" name="password" value="<?php echo $password; ?>">
                   <?php if (isset($errors["password"])  && $errors["password"] == "blank"): ?>
                    <p class="att">*パスワードを入力してください</p>
                   <?php endif; ?>
                   <?php if(isset($errors["password"])  && $errors["password"] == "length"): ?>
                    <p class="att">*パスワードは4文字以上8文字以内で入力してください</p>
                   <?php endif; ?>
                 </div>
             </div>

              <div class="clm" id="clm_3">
                <div class="list">
                 <p class="ttl">BIRTHDAY</p>
                 <select name="year">
                   <?php optionLoop("1950" , "2020" , $year);?> // 第一引数、第二引数、第三引数（1st argument, 2nd argument, 3rd argument)
                 </select>
                 <select name="month">
                   <?php optionLoop("1" , "12" , $month);?>
                 </select>
                 <select name="day">
                   <?php optionLoop("1" , "31" , $day);?>
                 </select>
                 <?php if(isset($errors["year"]) && $errors["year"] == "blank"): ?>
                  <p class="att">※生年月日を選択してください</p>
                 <?php endif; ?>
                 </div>

                <div class="list">
                <p class="ttl">PLACE</p>
                 <select name="birthplace">
                     <?php foreach ($pref as $v):?>  
                         <option value = "<?php echo $v; ?>" <?php echo $v == $birthplace ? 'selected': '';?> ><?php echo $v; ?> </option>
                         <?php var_dump($value); ?>
                         <?php var_dump($birthplace); ?>
                      <?php endforeach;?>
                 </select>
                   <?php if (isset($errors["birthplace"])  && $errors["birthplace"] == "blank"): ?>
                   <p class="att">*出身地を選択してください</p>
                   <?php endif; ?>
                </div>

                <div class="list">
                   <p class="ttl">HOBBY</p>
                   <input class="text" type="textbox" name="hobby" placeholder="旅行,読書,器械体操" value="<?php echo $hobby; ?>">
                   <?php if (isset($errors["hobby"]) && $errors["hobby"] == "blank"): ?>
                   <p class="att">*趣味を入力してください</p>
                   <?php endif; ?>
                 </div>

                <div class="list">
                 <p class="ttl">INTRODUCE</p>
                  <!-- <?php var_dump($intro); ?> -->
                  <textarea class="text" name="intro" style="width: 100%; height: 200px;" placeholder="自己紹介文と共に、SNSなどのURLを貼っていただくと、他のユーザーがあなたのことをより理解してくれます！" value="<?php echo $intro; ?>"><?php echo $intro; ?></textarea>
                  <?php if (isset($errors["intro"]) && $errors["intro"] == "blank"): ?>
                  <p class="att">自己紹介を入力してください！<br>短くても構いません！</p>
                  <?php endif; ?>
                </div>
            </div>

              <div class="clm" id="clm_4">
             <div class="position"  id="submitBox">
              <div class="col-xs-3">
                <input class="login" type="submit" value="SAVE">
              </div>
            </div>
            </div>
         </div>
      </form>

</body>
</html>


