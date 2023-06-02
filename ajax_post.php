<?php
//ajax.php
include("funcs.php");

//POSTパラメータを取得
$g_id = $_POST["g_id"];
$p_r_id = $_POST["p_r_id"];

// DB 接続
$pdo = db_conn();


// データ登録
$stmt = $pdo->prepare("INSERT INTO pg_relation_table(id, g_id, p_r_id)VALUES(NULL, :g_id, :p_r_id)");
$stmt->bindValue(':g_id', $g_id, PDO::PARAM_INT);
$stmt->bindValue(':p_r_id', $p_r_id, PDO::PARAM_INT);

$status = $stmt->execute();


// SQL からデータ抽出
$sql = 'SELECT * FROM pg_relation_table WHERE g_id=:g_id';  
$stmt2 = $pdo->prepare($sql);
$stmt2->bindValue(':g_id', $g_id);
$status2 = $stmt2->execute();
// var_dump($status2); // 問題なし
// exit("sssss");


$json = '[
    {
      "g_id":"'.$g_id.'",
      "p_r_id":"'.$p_r_id.'",
    }
]';



$val = $stmt2->fetch();
//作成したJSON文字列をリクエストしたファイルに返す
echo $val;
exit;
?>


