<html lang="ja">
<head>
<meta charset="UTF-8">
<title>TOP</title>
  <link href="assets/css/reset.css" rel="stylesheet">
  <link href="assets/css/bootstrap.css" rel="stylesheet">
  <link href="assets/css/font-awesome.min.css" rel="stylesheet">
  <link href="assets/css/top.css" rel="stylesheet" type="text/css">
  
  <style type="text/css">
   header {
 position: relative;
 font-family: "Helvetica Neue";
 font-size: 12px;
 letter-spacing: 2px;
 border-bottom: 1px solid #E8E8E8;
 display: flex;
 justify-content: space-between;
 border-bottom-width: 1px;
}
header #clm_l {
}
header #clm_l #prf {
 position: relative;
}
header #clm_l #prf #ill {
 position: absolute;
 border-left: 1px solid #DCDCDC;
 padding-top: 5px;
 padding-bottom: 212px;
}
header #clm_l #prf #pic {
 position: absolute;
 left: 63px;
 top: 6px;
 z-index: -5;
 border-radius: 35px;
 padding-right: 0px;
}

header #clm_l #logo {
 margin-left: 150px;
 margin-top: 25px;
 margin-bottom: 15px;
}
header #clm_l #logo img {
}

header #clm_r {
 margin-right: 50px;
}
header #clm_r #tBox {
 display: flex;
 align-items: flex-end;
 justify-content: space-between;
 margin-bottom: 8px;
 margin-top: 10px;
}
header #clm_r #reserch {
 margin-bottom: 10px;
 border-bottom: 1px solid #000000;
}
header #clm_r #reserch i {
 margin-right: 5px;
}
header #clm_r #reserch input {
 letter-spacing: 1px;
 color: #C1C1C1;
 border-style: none;
 padding-bottom: 3px;
}

header #clm_r #tab {
 display: flex;
 font-size: 12px;
 letter-spacing: 2px;
 font-weight: bold;
 margin-left: 15px;
}
header #clm_r #tab li a {
 text-align: center;
 padding-top: 8px;
 padding-right: 20px;
 padding-bottom: 8px;
 padding-left: 20px;
 margin-left: 10px;
 border: 1px solid #000000;
 display: block;
}
header #clm_r #tab li a:link,
header #clm_r #tab li a:visited {
 color: #000000;
}
header #clm_r #tab li a:hover {
 color: #FFFFFF;
 background-color: #000000;
}

header #clm_r #icon {
 display: flex;
 justify-content: flex-end;
}
header #clm_r #icon li {
 margin-left: 20px;
}
header #clm_r #icon img {
 margin-right: 1px;
}
header #clm_r #icon p {
 display: inline;
 font-weight: bold;
 font-size: 10px;
}
  </style>
  
  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="assets/js/chart.js"></script>

</head>

<body>

<header>

<!doctype html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>Message</title>

<!-- cssファイルの読み込み -->
  <link href="../assets/css/reset.css" rel="stylesheet">
  <link href="../assets/css/bootstrap.css" rel="stylesheet">
  <link href="../assets/css/font-awesome.min.css" rel="stylesheet">
  <link href="../assets/css/top.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="../assets/css/custom.css">
  
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
<header>
 <div class="container">
  
  <div id="clm_l">
   <div id="prf">
    <a href="#">
    <img id="ill" class="wow slideInDown" data-wow-duration="0.8s" src="assets/img/ill_hand.png" width="133" alt=""/>
    <img id="pic" src="assets/img/profile.jpg" width="70" height="70" alt=""/>
    <img id="ill" class="wow slideInDown" data-wow-duration="0.8s" src="../assets/img/ill_hand.png" width="133" alt=""/>
    <img id="pic" src="../assets/img/profile.jpg" width="70" height="70" alt=""/>

    </a>
   </div>
  
  <div id="logo" class="wow pulse" data-wow-duration="0.5s">
   <a href="#">
   <img src="assets/img/logo.png" width="120" height="45" alt=""/>
   </a>
  </div>
 </div>
  
 <div id="clm_r">
   <div id="tBox">
   <div id="reserch">
    <i class="fa fa-search" aria-hidden="true"></i><input type="text" value="Search BATCH" size="30">
   </div>
  
  <ul id="tab">
   <li><a href="#">MY PAGE</a></li>
   <li><a href="#">LOGOUT</a></li>
  </ul>
  </div>
  
  <div class="bBox">
  <ul id="icon">
   <li>

    <a href="#"><img class="roll" src="assets/img/nenpyo.png" width="21" height="13" alt=""/>
    <p>MEMBER</p></a>
   </li>
   <li>
    <a href="#"><img class="roll" src="assets/img/time.png" width="13" height="13" alt=""/>
    <p>TIME LINE</p></a>
   </li>
   <li>
    <a href="#"><img class="roll" src="assets/img/badge.png" width="13" height="16" alt=""/>
    <p>FOLLOW</p></a>
   </li>
   <li>
    <a href="#"><img class="roll" src="assets/img/message.png" width="17" height="13" alt=""/>

    <a href="#"><img class="roll" src="../assets/img/nenpyo.png" width="21" height="13" alt=""/>
    <p>MEMBER</p></a>
   </li>
   <li>
    <a href="#"><img class="roll" src="../assets/img/time.png" width="13" height="13" alt=""/>
    <p>TIME LINE</p></a>
   </li>
   <li>
    <a href="#"><img class="roll" src="../assets/img/badge.png" width="13" height="16" alt=""/>
    <p>FOLLOW</p></a>
   </li>
   <li>
    <a href="#"><img class="roll" src="../assets/img/message.png" width="17" height="13" alt=""/>

    <p>MESSAGE</p></a>
   </li>
  </ul>
 </div> 
 
 </div> 
</header>

</body>
</html>

 </div>
 </header>
