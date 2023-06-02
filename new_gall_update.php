<!-- ギャラリーに写真を追加する更新処理 -->
 
<?php
include("funcs.php");
 
// DB 接続
    $pdo = db_conn();

// POST で取得
$id        = $_POST["id"]; 
$post_id   = $_POST["post_id"];

echo $_SESSION["id"];
echo $id;
echo $id;
echo "OK";
exit();

// 画像の入力チェック
image_check("fname");


// 画像 insert
    $fname = fileUpload("fname" ,"images/");
    if($fname == 1 || $fname == 2){    // エラーの種類を番号で確認できる
        exit("FileUpload Error!");
    }


 
// UPDATE 処理
    $sql = 'UPDATE posts_table SET fname=:fname, description=:description WHERE id=:id';
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':id',            $id,            PDO::PARAM_STR);
    $stmt->bindValue(':fname',         $fname,         PDO::PARAM_STR);
    $stmt->bindValue(':description',   $description,   PDO::PARAM_STR);

    $status = $stmt->execute();
 

 
// 4. データ登録処理後
    if($status == false){  
        $error = $stmt->errorInfo();  
        exit("QueryError:".$error[2]);
    }else{
        header("Location: main.php");   
        exit;
    }
 
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    ここは HTML
</body>
</html>