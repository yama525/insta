
<?php
//XSS対応（ echoする場所で使用！それ以外はNG ）
function h($str){
    return htmlspecialchars($str, ENT_QUOTES);
}

//DB接続関数：db_conn()
function db_conn(){
    try {
    // localhost 
        $db_name = "myinsta";    //データベース名
        $db_id   = "root";      //アカウント名
        $db_pw   = "root";      //パスワード：XAMPPはパスワード無しに修正してください。
        $db_host = "localhost"; //DBホスト

        return new PDO('mysql:dbname='.$db_name.';
        charset=utf8;host='.$db_host, $db_id, $db_pw);
    } catch (PDOException $e) {
        exit('DB Connection Error:'.$e->getMessage());
    }
}
// $pdo = new PDO('mysql:dbname=nanca_unit1;charset=utf8;host=mysql57.nanca.sakura.ne.jp','nanca','*******'); 


//SQLエラー関数：sql_error($stmt) なんか使えない
function sql_error($stmt){
    $error = $stmt->errorInfo();
    exit("SQLError:".$error[2]);
}


//リダイレクト関数: redirect($file_name) なんか使えない
function redirect($file_name){
    header("Location: $file_name");
    exit();
}


// ログイン認証チェック関数
function loginCheck(){
    if(!isset($_SESSION["chk_ssid"]) ||  // ログインページからしか取得できない chk_ssid を持っていない場合。
      $_SESSION["chk_ssid"] != session_id() // ブラウザに保有している chk_ssid が異なる場合。
){
    echo "LOGIN Error!";
    exit();
}else{ // ここにsession regenerate を書く。なぜここかと言うと、毎回ログインが成功する旅に新しく発行するようにするため。
    session_regenerate_id(true);
    $_SESSION["chk_ssid"] = session_id(); // リジェネレイトしたやつを次のページに飛ばさないといけないので、再度 $_SESSION を定義。
}
}


//受信確認処理
function r_check($val){
    if(!isset($_POST["$val"]) || $_POST["$val"]==""){
      exit("ParameError!$val!");
    }
}
    
    // ファイルの受信確認処理
    function image_check($val){
    if(!isset($_FILES["$val"]["name"]) || $_FILES["$val"]["name"]==""){
      exit("ParameError!Files!");
    }
}


//fileUpload("送信名","アップロード先フォルダ");
function fileUpload($fname,$path){ // 「$fname」は form で送るときの input の name の値、「$path」はフォルダー名。※「$path」の部分の後は「/」つけること。
    if (isset($_FILES[$fname] ) && $_FILES[$fname]["error"] ==0 ) {
      // ファイル情報取得
        $file_name = $_FILES[$fname]["name"];        //ファイル名取得（1.jpg など）
        $tmp_path  = $_FILES[$fname]["tmp_name"];        //一時保存場所取得
      // ユニークファイルの作成
        $extension = pathinfo($file_name, PATHINFO_EXTENSION);        // まずはファイルの拡張子をとる（jpg など）
        $file_name = date("YmdHis").md5(session_id()) . "." . $extension;        // md5 でただでさえユニークな日付をさらにハッシュ化
      // FileUpload [--Start--]
        $file_dir_path = $path.$file_name;
        if ( is_uploaded_file( $tmp_path ) ) {       // アップロードちゃんとできてるか確認。
            if ( move_uploaded_file( $tmp_path, $file_dir_path ) ) {     // ファイルの移動
                chmod( $file_dir_path, 0644 );
                return $file_name; //成功時：新しいファイル名を返す
            } else {
                return 1; //失敗時：ファイル移動に失敗
            }
        }
     }else{
         return 2; //失敗時：ファイル取得エラー
     }
}
    // 書き方の例としてはこんな感じ ↓ こちらをコピーして使うと良い。
        // 画像 insert
            // $fname = fileUpload("upfile","updir/");   // $fname の所は必要に応じて $_SESSION["fname"] などに切り替える。
            // if($fname == 1 || $fname == 2){    // エラーの種類を番号で確認できる
            // exit("FileUpload Error!");
        // }

                // ちなみに今までは下記のやり方で上げていた ↓
                        // $fname = $_FILES["fname"]["name"];
                    // file のアップロード処理
                        // $upload = "./images/";
                        // if(move_uploaded_file($_FILES['fname']['tmp_name'], $upload.$fname)){
                            // ファイルアップロードオッケー
                        // }else{
                            // ファイルアップロード NG
                        //     echo "Upload Failed";
                        //     echo $_FILES['fname']['error'];
                        // }



