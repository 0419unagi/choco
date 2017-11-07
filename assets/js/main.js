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
        console.log('success');
        
        //フォームに何も入力されていない場合は、そのままreturn
    	if(!$('#text_input').val()) return;

        // 初期値の設定
        var user = $('#user_name').val();
        var message =  $('#text_input').val();
        //部分スクロールの元の高さを取得
        // var height = $('#talkField').get(0).scrollHeight;

        //bbs.phpへgetリクエストで配列を送信している
        $.get('bbs.php', {
            //userキーに対して、ID'user'に入力された値
        	user: $('#user_name').val(),
            //messageキーに対して、ID'message'に入力された値
        	message: $('#text_input').val(),
        	mode: "0" // 書き込み
        },function(data){
            $('#result').append("<div class='left_balloon'>" + message + "</div>");
            scrollDown();
        });
    });
});


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
