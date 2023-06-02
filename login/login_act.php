<?php
session_start(); // SESSION 変数はページをまたいで変数を渡したりできる。それの定義を最初に書く。
$u_id = $_POST["u_id"];
$pass = $_POST["pass"];

 
// DB接続
include("../funcs.php");
$pdo = db_conn();
 
 
// データ登録 SQL 作成
$sql = 'SELECT * FROM login_table WHERE u_id=:u_id AND life_flg=0'; // 0 が生きてるユーザー
$stmt = $pdo->prepare($sql);
 
$stmt->bindValue(':u_id', $u_id);
// $stmt->bindValue(':pass', $pass);
 
$status = $stmt->execute();
 
 
// エラー確認
if($status == false){  
    $error = $stmt->errorInfo();  
    exit("QueryError:".$error[2]);
}

 
// 3. 抽出データ数を取得
   $val = $stmt->fetch(); // 1 レコードのみ配列で取得
 
   
//   下の「password_verify($pass, $val["pass"]」だけだとパスワードが同じなら別のアカウントにログインできてしまうと懸念したが問題なさそう。そのため、「&& $val["id"]」を後に加える必要なし。
// 4. 該当レコードがあれば SESSION に値を代入
if(password_verify($pass, $val["pass"]) != ""){    // 上で取得した $val の値が DB 上に空ではなかった（あった）場合 →（認証オッケーだった場合）...。
    $_SESSION["chk_ssid"] = session_id(); //「session_id()」はセッションスタート時にユニークキーを取得する関数。ここは重要！！
    $_SESSION["u_name"] = $val['u_name']; // u_name でユーザーを管理する（ログイン後に名前を表示させる時などに利用）
    $_SESSION["id"] = $val["id"]; // ログインしているユーザーの id をセッションで保存。
    $_SESSION["pname"] = $val["pname"]; // 

    // echo $_SESSION["u_name"];
    // echo $_SESSION["id"]; // id の取得できてる
    // exit("aaa");

    header("Location: ../main.php"); // 実践 1 で作ったユーザー一覧ページへ飛ばす。（実践 1 で作ったものと連結させる）
}else{   // 認証ダメだった場合
    // $_SESSION['login'] = false; // ログイン失敗したら前の画面に失敗したこと記載したい。
//     var_dump($_SESSION["login"]);
//     exit;
    header("Location: login.php"); // 上記の元のログイン画面へ戻す。
    exit();
}
 
?>
