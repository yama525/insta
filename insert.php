<?php
session_start();
include("funcs.php");

// 入力チェック
image_check("fname");
r_check("description"); // f_check() 側で exit されるからこっちのエラーはファイルが選択されている場合しか表示されない。

// ログインチェック
loginCheck();

// DB 接続
$pdo = db_conn();

// 変数定義
// $fname = $_FILES["fname"]["name"];
$description = $_POST["description"];


// file のアップロード処理
// $upload = "./images/";
// if(move_uploaded_file($_FILES['fname']['tmp_name'], $upload.$fname)){
//     // ファイルアップロードオッケー
// }else{
//     // ファイルアップロード NG
//     echo "Upload Failed";
//     echo $_FILES['fname']['error'];
// }


// 画像 insert
    $fname = fileUpload("fname","images/");
    if($fname == 1 || $fname == 2){    
        exit("FileUpload Error!");
    }



// データ登録
$stmt = $pdo->prepare("INSERT INTO posts_table(id, fname, description, indate, p_id)VALUES(NULL, :fname, :description, sysdate(), :p_id)");
$stmt->bindValue(':fname', $fname, PDO::PARAM_STR);
$stmt->bindValue(':description', $description, PDO::PARAM_STR);
$stmt->bindValue(':p_id', $_SESSION["id"], PDO::PARAM_STR);

$status = $stmt->execute();


if($status == false){
    $error = $stmt->errorInfo();
    exit("QueryError:".$error[2]);
}else{

    header("Location: select.php");
    exit;
}





