<?php
session_start();
// 値がセットされてない or 空白でエラー表示
if(
    !isset($_POST["u_name"]) || $_POST["u_name"]=="" ||
    !isset($_POST["u_id"])   || $_POST["u_id"]==""   ||
    !isset($_POST["pass"])   || $_POST["pass"]==""
){
    exit('ParamError');  
}

// POSTデータの取得
$u_name = $_POST["u_name"];
$u_id   = $_POST["u_id"];
$pass_def   = $_POST["pass"]; // 一旦ユーザーの入力したパスワードを受け取る。
$pass   = password_hash("$pass_def", PASSWORD_DEFAULT);  // 上記で受け取ったパスワードをハッシュ化。


// データベースとの接続
include("../funcs.php");
$pdo = db_conn();


// データ登録 SQL 作成  
$sql = "INSERT INTO login_table(id, u_name, u_id, pass, pname, life_flg, indate)
VALUES(NULL, :u_name, :u_id, :pass, :pname, 0, sysdate())";  
$stmt = $pdo->prepare($sql); 

$stmt->bindValue(':u_name', $u_name, PDO::PARAM_STR); 
$stmt->bindValue(':u_id',   $u_id,   PDO::PARAM_STR);
$stmt->bindValue(':pass',   $pass,   PDO::PARAM_STR);
$stmt->bindValue(':pname',   $pname,   PDO::PARAM_STR);


$status = $stmt->execute(); 
$_SESSION["id"] = $pdo->lastInsertId(); // 上で登録した id を取得。

// エラーもしくはリダイレクト
if($status == false){  
    $error = $stmt->errorInfo();  
    exit("QueryError:".$error[2]);
}else{
    // 直接 select.php に入れるよう、ssidを渡しておく。↓
    // u_name も渡しておくことで次の画面に u_name を表示させる。↓
    // u_id を渡しているのは恐らくこのユーザーの持っている情報（別のテーブルとのリレーション）にアクセスするため ↓
    // 上で登録してすぐにログインしているイメージ。↓
    $_SESSION["chk_ssid"] = session_id();
    $_SESSION["u_name"]   = $_POST["u_name"];
    $_SESSION["u_id"]     = $_POST["u_id"];
    // $_SESSION["u_id"] = $_POST["u_id"];
    // echo $_SESSION["u_name"];
    // echo $_SESSION["id"];
    // echo $_SESSION["chk_ssid"];
    // exit('ok');
    
    header("Location: ../create_profile.php");    // 「select.php」へリダイレクト
    exit;
}

?>