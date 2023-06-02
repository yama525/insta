<?php
session_start();
include("funcs.php");

// 画像の入力チェック
image_check("pname");


// DB 接続
$pdo = db_conn();


// 画像 insert
    $_SESSION["pname"] = fileUpload("pname","images/");
    if($_SESSION["pname"] == 1 || $_SESSION["pname"] == 2){    // エラーの種類を番号で確認できる
        exit("FileUpload Error!");
    }



// データ登録
$sql = 'UPDATE login_table SET pname=:pname WHERE id=:id';
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':pname', $_SESSION["pname"], PDO::PARAM_STR);
    $stmt->bindValue(':id',    $_SESSION["id"],    PDO::PARAM_INT);

    $status = $stmt->execute();


    // エラー確認とリダイレクト
if($status == false){
    $error = $stmt->errorInfo();
    exit("QueryError:".$error[2]);
}else{
    header("Location: select.php");
    exit;
}



?>