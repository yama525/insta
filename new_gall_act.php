<?php
session_start();
include("funcs.php");

// ログインチェック
    loginCheck();

// DB 接続
    $pdo = db_conn();

// 変数定義
    $g_name = $_POST["g_name"];
    $g_des  = $_POST["g_des"];



// データ登録 SQL 作成  
    $sql = "INSERT INTO gallery_table(id,    g_name,  g_des,  c_userid, priv, indate)
    VALUES(                           NULL, :g_name, :g_des, :c_userid, 1,    sysdate())";  //priv は 1 が作成者
    $stmt = $pdo->prepare($sql); 

    $stmt->bindValue(':g_name',     $g_name,           PDO::PARAM_STR); 
    $stmt->bindValue(':g_des',      $g_des,            PDO::PARAM_STR);
    $stmt->bindValue(':c_userid',   $_SESSION["id"],   PDO::PARAM_STR);

    $status = $stmt->execute(); 
    

// エラーもしくはリダイレクト
    if($status == false){  
        $error = $stmt->errorInfo();  
        exit("QueryError:".$error[2]);
    }else{
        redirect("main.php");
    }

?>

