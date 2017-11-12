// メッセージ内容ページの最新コメントを表示
$(document).ready(function(){
    scrollDown();
});

//メッセージ送信ボタンをクリックすると
// 1.データベースへデータを反映する
// 2.HTMLの要素を追加する
// ※メッセージが送信される場合は、uplodeキーにNULL値を設定する

// 1.データベースへデータを反映する
$(function(){
    //submitをクリックすると以下のコードを実行する
    $('#submit').click(function(){
        //フォームに何も入力されていない場合は、そのままreturn
        if(!$('#text_input').val()) return;
        //bbs.phpへgetリクエストで配列を送信している
        $.get('bbs.php', {
            user_id: $('#user_id').val(),
            user_name: $('#user_name').val(),
            other_id: $('#other_id').val(),
            other_name: $('#other_name').val(),
            content: $('#text_input').val(),
            uplode_image: "NULL",
            mode: "0" // 書き込み
        },function(data){
            $('#result').append(data);
            // scrollDown();
        });
    });
});


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
        "user_name": $('#user_name').val(),
        "other_id": $('#other_id').val(),
        "other_name": $('#other_name').val(),
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
        // $('#result').append(data);

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
