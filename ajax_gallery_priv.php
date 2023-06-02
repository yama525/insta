




<?php
//ajax.php
include("funcs.php");

//POSTパラメータを取得
$id = $_POST["id"];
$priv = $_POST["priv"];

// DB 接続
$pdo = db_conn();


// 3. UPDATE gs_an_table SET ... で更新（bindValue）
$sql = 'UPDATE gallery_table SET priv=:priv WHERE id=:id'; // id は WHERE で取得。SQL 文はシングルクォーテーションで囲むことに注意。
$stmt = $pdo->prepare($sql);
 
$stmt->bindValue(':id',    $id,    PDO::PARAM_INT);
$stmt->bindValue(':priv',  $priv,    PDO::PARAM_INT);
    
$status = $stmt->execute();



// // SQL からデータ抽出
$sql2 = 'SELECT * FROM gallery_table WHERE id=:id';  
$stmt2 = $pdo->prepare($sql2);
$stmt2->bindValue(':id', $id);
$status2 = $stmt2->execute();
// var_dump($status2); // 問題なし
// exit("sssss");


$json = '[
    {
      "id":"'.$id.'",
      "priv":"'.$priv.'",
    }
]';



$val = $stmt2->fetch(PDO::FETCH_ASSOC);
//作成したJSON文字列をリクエストしたファイルに返す
echo $status2;
exit;
?>