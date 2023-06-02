<?php
session_start();
include("funcs.php");


// DB 接続
    $pdo = db_conn();


// ユーザーデータ抽出（こちらはユーザー（login_table）の id と、投稿（post_table）の p_id で一致するものを検索）
    $stmt = $pdo->prepare("SELECT * FROM posts_table WHERE p_id=:p_id");
    $stmt->bindValue(':p_id', $_SESSION["id"], PDO::PARAM_STR);
    $status = $stmt->execute();

//あらかじめ配列を生成しておき、while文で回します。
    $postList = array();
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        $postList[]=array(
            'id' =>$result['id'],
            'fname'=>$result['fname'],
            'description'=>$result['description']
    );
    }


//jsonとして出力
header('Content-type: application/json');
echo json_encode($postList,JSON_UNESCAPED_UNICODE);




?>