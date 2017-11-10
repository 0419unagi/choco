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
            console.log(data);
            $('#result').append("<div class='left_balloon'>" + content + "</div>");
            scrollDown();
        });
    });
});

function img_up(){
        // console.log("aaaaaaa");

        //bbs.phpへgetリクエストで配列を送信している
        $.get('bbs.php', {
            user_id: $('#user_id').val(),
            user_name: $('#user_name').val(),
            other_id: $('#other_id').val(),
            other_name: $('#other_name').val(),
            content: "NULL",
            uplode_image: $('#uplode_image').val(),
            mode: "3" // 画像送信モード
        },function(data){
            console.log(data);
            // 画像オブジェクトを作成        
            var fd = new FormData($('#foo').get(0));
            $.ajax({
                url: "bbs.php",
                type: "POST",
                data: fd,
                processData: false,
                contentType: false,
                dataType: 'json'
            })
            .done(function(data) {
                $('#result').text(data.width + "x" + data.height);
            });
            // bbs.phpでリターンした要素を変数dataへ引数と渡して、
            // #resultへ要素を追加したい
            console.log('data_sample');
            console.log(data);
            $('#result').append(data);

            scrollDown();
        });

        return false;
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
