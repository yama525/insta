<!-- ユーザー情報の更新処理 -->
 
<?php
include("funcs.php");
 
// DB 接続
    $pdo = db_conn();

// POST で取得
$id            = $_POST["id"]; // id を受け取っているためこれを記載
$description   = $_POST["description"];


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
