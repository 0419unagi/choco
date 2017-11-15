<?php 
  // echo "<pre>";
  // var_dump($_POST);
  // echo "</pre>";
  // session_start();
  // require('../dbconnect.php');
	require('../part/header.php');

  if(!isset($_SESSION['login_user']['id'])){
    header('Location: index.php');
    exit();
	}



$sql = 'SELECT `nickname`,`image`,`datepicker`,`course` FROM `batch_users` ORDER BY `datepicker` DESC';
$data = array();
$stmt = $dbh->prepare($sql);
$stmt->execute($data);


$userdata = array();
while(true){
  $data = $stmt->fetch(PDO::FETCH_ASSOC);
  if(!$data){
    break;
  }

  $userdata[] = $data;
  // echo '<pre>';
  // var_dump($data);
  // echo '</pre>';
  
}


$sql = 'SELECT `datepicker` FROM `batch_users` GROUP BY `datepicker` DESC';
$data = array();
$stmt = $dbh->prepare($sql);
$stmt->execute($data);


$gdata = array();
while(true){
  $data = $stmt->fetch(PDO::FETCH_ASSOC);
  if(!$data){
    break;
  }

  $gdata[] = $data;
  
}

  // echo '<pre>';
  // var_dump($userdata);
  // echo '</pre>';
  // echo '<pre>';
  // var_dump($gdata);
  // echo '</pre>';
  

 ?>



<!doctype html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>BATCH TOP</title>
  <link href="../assets/css/reset.css" rel="stylesheet">
  <link href="../assets/css/bootstrap.css" rel="stylesheet">
  <link href="../assets/css/font-awesome.min.css" rel="stylesheet">
  <link href="../assets/css/top.css" rel="stylesheet" type="text/css">
  
  <!-- アニメーション --> 
  <link href="../assets/css/animate.css" rel="stylesheet">
<script src="../assets/js/wow.min.js"></script>
<script>
new WOW().init();
</script>
  
  
  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="../assets/js/chart.js"></script>
  <script>
$(function(){
	var setElm = $('.carousel'),
	slideSpeed = 500,
	slideDelay = 5000,
	slideEasing = 'swing';

	$(window).load(function(){
		setElm.each(function(){
			var self = $(this),
			selfWidth = self.innerWidth(),
			selfUl = self.find('ul'),
			selfLi = selfUl.find('li'),
			liFirst = selfUl.find('li:first'),
			liLast = selfUl.find('li:last'),
			listWidth = selfLi.outerWidth(true),
			listCount = selfLi.length,
			slideWidth = listWidth*listCount;

			selfUl.css({width:slideWidth});

			self.wrapAll('<div class="slideWrap" />').find('ul').wrapAll('<div class="movePanel" />');

			var slideWrap = self.parent('.slideWrap'),
			slidePanel = self.find('.movePanel');

			if(selfWidth < slideWidth){
				selfUl.clone().prependTo(slidePanel);
				selfUl.clone().appendTo(slidePanel);

				slidePanel.find('ul').eq('1').addClass('mainList');

				var mainList = slidePanel.find('.mainList').find('li');
				mainList.eq('0').addClass('mainActive');

				var allList = slidePanel.find('li'),
				allListCount = slidePanel.find('li').length;


				// スライダーエリアの位置設定
				var baseWrapWidth = listWidth*listCount,
				allWrapWidth = listWidth*allListCount,
				posResetNext = -(baseWrapWidth)*2,
				posResetPrev = -(baseWrapWidth)+(listWidth);

				slidePanel.css({left:-(baseWrapWidth),width:allWrapWidth}).find('ul').css({width:baseWrapWidth});


				// Next/Backボタン
				//slideWrap.append('<a href="javascript:void(0);" class="btnPrev"></a><a href="javascript:void(0);" class="btnNext"></a>');

				var btnNext = slideWrap.find('.btnNext'),
				btnPrev = slideWrap.find('.btnPrev');

				btnNext.click(function(){
					slideNext();
				});

				btnPrev.click(function(){
					slidePrev();
				});

				function slideNext(){
					slidePanel.not(':animated').each(function(){
						timerStop();
						var posLeft = parseInt(slidePanel.css('left')),
						moveLeft = posLeft-listWidth;
						slidePanel.stop().animate({left:(moveLeft)},slideSpeed,slideEasing,function(){
							var adjustLeft = parseInt(slidePanel.css('left'));
							if(adjustLeft <= posResetNext){
								slidePanel.css({left: -(baseWrapWidth)});
							}
						});

						var setActive = selfUl.find('.mainActive'),
						listIndex = selfLi.index(setActive),
						nextCount = listIndex+1;

						self.find('.mainActive').removeClass('mainActive');

						if(listCount == nextCount){
							liFirst.addClass('mainActive');
							selfUl.next('ul').find('li:first').addClass('mainActive');
						} else {
							setActive.next().addClass('mainActive');
						}

						timerStart();
					});
				}

				function slidePrev(){
					slidePanel.not(':animated').each(function(){
						timerStop();
						var posLeft = parseInt(slidePanel.css('left')),
						moveLeft = posLeft+listWidth;
						slidePanel.stop().animate({left:(moveLeft)},slideSpeed,slideEasing,function(){
							var adjustLeft = parseInt(slidePanel.css('left'));
							if(adjustLeft >= posResetPrev){
								slidePanel.css({left: posResetNext+listWidth});
							}
						});

						var setActive = selfUl.find('.mainActive'),
						listIndex = selfLi.index(setActive),
						nextCount = listIndex+1;

						self.find('.mainActive').removeClass('mainActive');

						if(1 == nextCount){
							liLast.addClass('mainActive');
							selfUl.prev('ul').find('li:last').addClass('mainActive');
						} else {
							setActive.prev().addClass('mainActive');
						}

						timerStart();
					});
				}

				// スライドタイマー
				var slideTimer;

				function timerStart(){
					slideTimer = setInterval(function(){
						slideNext();
					},slideDelay);
				}
				timerStart();

				function timerStop(){
					clearInterval(slideTimer);
				}

				// スライド中央揃え
				$(window).on('resize', function(){
					var wrapWidth = slideWrap.width();
					self.css({marginLeft: (wrapWidth / 2) - (listWidth / 2)})
				}).resize();
			}
		});
		setElm.css({visibility:'visible'});
	});
});
   
   
</script>
</head>

<body>

  
<main id="topPg">
 <div class="line_tate"></div>

 
 
 <section>
	<?php foreach($gdata as $data) { ?>
	<!-- 入学日 -->
		<p class="date wow flipInY"><?php echo $data['datepicker'] ?></p>
		<img class="fuki" src="../assets/img/fuki.png" width="7" height="6" alt=""/>
		<div class="line_yoko"></div>
		
			 	
			 	<?php foreach($userdata as $data1){?>
			 	<?php error_log(print_r($data1,true),"3","../../../../../logs/error_log"); ?>
				 	<?php if($data1['datepicker']==$data['datepicker']){ ?>
				 		<div class="carousel">
							<ul>
							 <li>
								<!-- プロフィール画像 -->
								  <!-- <a href="#"> -->
								  	<!-- 色を変えたい -->
								  	<?php if($data1['course']=='programming'){ ?>
								  	<!-- プログラミング生の時、青色表示 -->
			 						  <div class="frame_b">
									  	<img src="../image/<?php echo $data1['image'];?>" width="100%" height="auto" alt=""/>
									  </div>
									<?php }else { ?>
								  	<!-- 英語生の時、黄色表示 -->
									  <div class="frame_y">
									  	<img src="../image/<?php echo $data1['image'];?>" width="100%" height="auto" alt=""/>
									  </div>
									<?php } ?>
								   	<!-- ユーザーネーム -->
								  	<p class="name"><?php echo $data1['nickname'];?></p>
								  </a>
							 </li>
							</ul>
						</div>
				 	<?php } ?>
			  	<?php } ?>
			

	<?php } ?>
<img class="arrow" src="../assets/img/arrow.png" width="58" height="29" alt=""/>

</section>

</main>


<footer>
 <small>copyright ©︎chocomallow.All rights reserved.</small>
</footer>

</body>
</html>
