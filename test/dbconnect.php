<?php
$id = $_POST['id'];

// データベース接続

$host = 'localhost';
$dbname = 'test';
$dbuser = 'root';
$dbpass = 'root';

try {
$dbh = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8mb4", $dbuser,$dbpass, array(PDO::ATTR_EMULATE_PREPARES => false));
} catch (PDOException $e) {
 var_dump($e->getMessage());
 exit;
}
// データ取得
$sql = "SELECT id, name, mail FROM member WHERE id = ?";
$stmt = ($dbh->prepare($sql));
$stmt->execute(array($id));

//あらかじめ配列を生成しておき、while文で回します。
$memberList = array();
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
 $memberList[]=array(
  'id' =>$row['id'],
  'name'=>$row['name'],
  'mail'=>$row['mail']
 );
}

//jsonとして出力
header('Content-type: application/json');
echo json_encode($memberList,JSON_UNESCAPED_UNICODE);