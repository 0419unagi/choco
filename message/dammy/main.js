// メッセージ内容ページの最新コメントを表示
$(document).ready(function(){
    scrollDown();
});



//メッセージ送信ボタンをクリックすると
// 1.データベースへデータを反映する
// 2.HTMLの要素を追加する

// 1.データベースへデータを反映する
$(function(){
    //submitをクリックすると以下のコードを実行する
    $('#submit').click(function(){
        
        //フォームに何も入力されていない場合は、そのままreturn
    	// if(!$('#text_input').val()) return;
        // 初期値の設定
        console.log("aaaaaaa");
        var fd = new FormData($('#foo').get(0));
        $.ajax({
            url: "bbs.php",
            type: "POST",
            data: fd,
            processData: false,
            contentType: false,
            dataType: 'json'
        })
        .done(function( data ) {
            $('#result').text(data.width + "x" + data.height);
        });
        return false;

    });
});

function aaa(){
        console.log("aaaaaaa");
        var fd = new FormData($('#foo').get(0));
        $.ajax({
            url: "bbs.php",
            type: "POST",
            data: fd,
            processData: false,
            contentType: false,
            dataType: 'json'
        })
        .done(function( data ) {
            $('#result').text(data.width + "x" + data.height);
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
