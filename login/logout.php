<?php
// 必ず session_start は最初に記述
session_start(); // 削除するためにも一旦スタートは必要。
 
 
// SESSION を初期化（空っぽにする）
$_SESSION = array();   // 「$_SESSION」の後の「[]」がない場合、「$_SESSION」の全ての変数という意味になる。「array();」は配列で空にするという意味 → $_SESSION で定義された変数が全て空になる。
 
 
// Cookie に保有してある SessionID()の保存期間を過去にして（無効化して）破棄
if(isset($_COOKIE[session_name()])){ // session_name() は、セッションID 名を返す関数
    setcookie(session_name(), '', time()-42000, '/');  // Cookie には期間があるが、「time()-42000」で古い時間にして、現在では無効にする。
}
 
 
// サーバー側での、セッションID の破棄
session_destroy();
 
 
// 処理後、index_test.phpへリダイレクト
header("Location: login.php");  // 変更するのはここだけ！！
exit();
 
?>
