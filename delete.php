<?php
include("funcs.php");
// 1. GET で id を取得
$id = $_GET["id"]; // id だけ取得
 

 
// 2. DB 接続
$pdo = db_conn();
 

// ファイルをフォルダーから削除する
  // id から 1 レコードすべての配列を取得する方法
  $stmt2 = $pdo->prepare("SELECT * FROM posts_table WHERE id=:id");
  $stmt2->bindValue(':id', $id, PDO::PARAM_INT);
  $status2 = $stmt2->execute();
  $result = $stmt2->fetch(PDO::FETCH_ASSOC);
//   var_dump($result);
//   echo $id;
//   echo $result["fname"];
//   exit();

  $saved_file = './images/'.$result["fname"];
  // $file_place = '../img/';
  unlink($saved_file);


 
// 3. DELETE FROM gs_an_table WHERE ... で削除（bindValue）
$sql = 'DELETE FROM posts_table WHERE id=:id'; // ここを DELETE に。
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT); // id だけでいい。
$status = $stmt->execute();
 
 
// 4. 処理後は select.php へ戻す
if($status == false){  
    $error = $stmt->errorInfo();  
    exit("QueryError:".$error[2]);
}else{
    header("Location: main.php");    // 「select.php」へリダイレクト
    exit;
}
 
?>
