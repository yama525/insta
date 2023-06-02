




<?php
//ajax.php
include("funcs.php");

//POSTパラメータを取得
$id = $_POST["id"];
$b_color = $_POST["b_color"];

// DB 接続
$pdo = db_conn();


// 3. UPDATE gs_an_table SET ... で更新（bindValue）
$sql = 'UPDATE gallery_table SET b_color=:b_color WHERE id=:id'; // id は WHERE で取得。SQL 文はシングルクォーテーションで囲むことに注意。
$stmt = $pdo->prepare($sql);
 
$stmt->bindValue(':id',    $id,    PDO::PARAM_INT);
$stmt->bindValue(':b_color',   $b_color,   PDO::PARAM_STR);

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
      "b_color":"'.$b_color.'",
    }
]';



$val = $stmt2->fetch(PDO::FETCH_ASSOC);
//作成したJSON文字列をリクエストしたファイルに返す
echo $b_color;
exit;
?>