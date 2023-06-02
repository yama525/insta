<?php
session_start();
include("funcs.php");


// 前のページから id を取得
    $id = $_GET["id"];


// ログインチェック
    loginCheck();


// DB 接続
    $pdo = db_conn();

 
// SQL からの表示 
    $sql = "SELECT * FROM posts_table WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    
    $status = $stmt->execute();
 
 
// データの表示
    if($status == false){  
        $error = $stmt->errorInfo();   
        exit("QueryError:".$error[2]); 
    }else{
        $row = $stmt->fetch(); 
    }
    
?>
 
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>フリーアンケート</title>
</head>
<body>
 
<form method="POST" action="insert.php">
    <div class="junbotron">
        <fieldset>
            <label>名前：<input type="text" name="name" value="<?= $row['name']?>"></label><br/>
            <label>Email：<input type="text" name="email" value="<?= $row['email']?>"></label><br/>
            <label>住所：<input type="text" name="address" value="<?= $row['address']?>"></label><br/>
            <label><textarea name="naiyou" row="4" cols="40"> <?= $row["naiyou"]?></textarea></label><br/>
            <input type="hidden" name="id" value="<?= $row["id"]?>">  <!-- ここで hidden で隠して id を取得しておく -->
 
            <input type="submit" value="送信">
        </fieldset>
    </div>
</form>
</body>
</html>