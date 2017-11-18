// メッセージ内容ページの最新コメントを表示
$(document).ready(function(){
    scrollDown();
    //画像選択ボタンと送信ボタンをタブキーで指定出来るようにする
    $('#submit').attr("tabindex", "0");
    $('#uplode_image').attr("tabindex", "0");
    $('.tomo').attr("tabindex", "0");

    // サイドバーでクリックしたユーザーのトーク画面を表示
    $("div.tom").click(function(){
        //サイドバーでクリックされたユーザーIDを取得
        var other_id = $(this).attr("value");
        // console.log(other_id);
        $.ajax({
          type: 'GET',
          url: "message.php",
           data: {
                    other_id: other_id,
                },
            error : function(XMLHttpRequest, textStatus, errorThrown) {
            console.log("ajax通信に失敗しました");
            console.log("XMLHttpRequest : " + XMLHttpRequest.status);
            console.log("textStatus     : " + textStatus);
            console.log("errorThrown    : " + errorThrown.message);
        },
        })
          .done(function(data) {            
            //指定されたユーザーIDとのトーク履歴を表示する
            changeTalk(other_id);

            //コメント送信ボタンのother_idのvalue値を上で定義したother_id
            //がセットされた要素を上書きする
            $('#other_id').val(other_id);
            // console.log($('#other_id').val());
            
         }).fail(function(data) {                
            // console.log('fail');

         }).always(function(data) {                
            // console.log('always');
         });         
    });


    // サイドバーのユーザー検索機能
    $(".user_list").searcher({
                itemSelector: ".tom",
                textSelector: "p",
                inputSelector: "#mes_search"
            });



});

//メッセージ送信機能
$(function(){
    //#submitにenterキーを押すると以下のコードを実行する
    $('#submit').keypress(function(){
        // console.log('//////////////////////////////');
        // console.log($('#other_id').val());

        //フォームに何も入力されていない場合は、そのままreturn
        if(!$('#text_input').val()) return;
        //bbs.phpへgetリクエストで配列を送信している
        $.get('bbs.php', {
            user_id: $('#user_id').val(),
            other_id: $('#other_id').val(),
            content: $('#text_input').val(),
            uplode_image: "NULL",
            mode: "0" // 書き込み
        },function(data){
            $('#result').append(data);
            scrollDown();
            // 入力後にテキストボックスを空にする
            $('#text_input').val('');
        }); 
    });
});




//サイドバーで選択したユーザーとのトーク画面を表示する
function changeTalk(data){
        var other_id = data;

        $.ajax({
          type: 'GET',
          url: "model/update_talk.php",
           data: {
                    other_id: other_id,
                },
          error : function(XMLHttpRequest, textStatus, errorThrown) {
            console.log("ajax通信に失敗しました");
            console.log("XMLHttpRequest : " + XMLHttpRequest.status);
            console.log("textStatus     : " + textStatus);
            console.log("errorThrown    : " + errorThrown.message);
        },
        })
          .done(function(data) { 
            var test = $.parseJSON(data);
            // 返り値の最後にユーザーネームを付けているので、取得する
            var user_name = test[test.length - 1];
            // ユーザーネーム取得後、最後の要素を削除する
            test.pop();
            // console.log(test);
            var logs = test.join('');
            $("#result").html(logs);
            // console.log(logs);
            scrollDown();
            // console.log(user_name);
            $("#mes_head").html(user_name);

         }).fail(function(data) {                
            // console.log('fail');

         }).always(function(data) {                
            // console.log('always');
         });         
}


//トーク送信時にサイドバーを更新
// function updateSideBar() {

//     $.ajax({
//       type: 'GET',
//       url: "model/update_side_bar.php",
//       error : function(XMLHttpRequest, textStatus, errorThrown) {
//         console.log("ajax通信に失敗しました");
//         console.log("XMLHttpRequest : " + XMLHttpRequest.status);
//         console.log("textStatus     : " + textStatus);
//         console.log("errorThrown    : " + errorThrown.message);
//     },
//     })
//       .done(function(data) { 
//         console.log('done');


//         // var test = $.parseJSON(data);
//         // // 返り値の最後にユーザーネームを付けているので、取得する
//         // var user_name = test[test.length - 1];
//         // // ユーザーネーム取得後、最後の要素を削除する
//         // test.pop();
//         // // console.log(test);
//         // var logs = test.join('');
//         // $("#result").html(logs);
//         // scrollDown();
//         // // console.log(user_name);
//         // $("#mes_head").html(user_name);

//      }).fail(function(data) {                
//         console.log('fail');

//      }).always(function(data) {                
//         console.log('always');
//      });         

// }













// 画像送信ボタンが押された時に以下の関数を実行
function img_up(){
    // 画像送信ボタンが押された時に、データベースへインサート
        insertDateImg();
    // 画像を指定のディレクトリへ移動させるため
        makeImg();

        return false;
}

// 画像送信ボタンが押された時に、データベースへインサート
function insertDateImg() {
    //ここのやり方を見直す
    // 1.上記指定の配列を1度、JSONにする
    // 2.ajaxでbbs.phpに落とす

    var user_data = {
        "user_id": $('#user_id').val(),
        "other_id": $('#other_id').val(),
        "content": "NULL",
        "uplode_image": $('#file').val(),
        "mode": "3" // 画像送信モード
    };

    var user_data = JSON.stringify(user_data);

    $.ajax({
      type: 'GET',
      url: "bbs_img_insert.php",
      data: user_data,
      processData: false,
      contentType: false,
      error : function(XMLHttpRequest, textStatus, errorThrown) {
        console.log("ajax通信に失敗しました");
        console.log("XMLHttpRequest : " + XMLHttpRequest.status);
        console.log("textStatus     : " + textStatus);
        console.log("errorThrown    : " + errorThrown.message);
    },
    })
      .done(function(data) {                
        console.log('done');
        console.log(data);
        $('#result').append(data);
        scrollDown();
     }).fail(function(data) {                
        console.log('fail');

     }).always(function(data) {                
        console.log('always');
     });
}

// 画像オブジェクトを作成
// 画像を指定のディレクトリへ移動させるため
function makeImg(){
    $(function(data){
            // 画像オブジェクトを作成        
            var fd = new FormData($('#foo').get(0));
            console.log(fd);
            $.ajax({
                url: "bbs_img.php",
                type: "POST",
                data: fd,
                processData: false,
                contentType: false,
            })
            .done(function(data) {                
                // $('#result').text(data.width + "x" + data.height);
                
                console.log('done');
                console.log(data);

            }).fail(function(data) {                
                console.log('fail');

            }).always(function(data) {                
                console.log('always');
            });
            // メッセージ内容ページの最下層を表示
            scrollDown();
        });
}


// メッセージ内容ページの最下層を表示
function scrollDown(){
    // 元の高さを取得
    var height = $('#talk_content').get(0).scrollHeight;
    // 上記の高さまでスクロール
      $('#talk_content').scrollTop(height);

}


// ログをロードする
function loadLog(){
    $.get('bbs.php', {
        mode: "1" // 読み込み
    }, function(data){
        $('#result').html(data);
        // scTarget();
    });
}

// 一定間隔でログをリロードする
function logAll(){
    setTimeout(function(){
        // loadLog();
        logAll();
    },5000); //リロード時間はここで調整
}
