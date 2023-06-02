
<!--------------------------------------------------- PHP ------------------------------------------------->
<!--------------------------------------------------- PHP ------------------------------------------------->
<!--------------------------------------------------- PHP ------------------------------------------------->


<?php
  session_start();
  include("funcs.php");


// DB 接続
  $pdo = db_conn();

// ログインチェック
  loginCheck();

// SQL からデータ抽出
  $sql = 'SELECT * FROM login_table WHERE u_id=:u_id AND life_flg=0'; // 0 が生きてるユーザー
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':u_id', $u_id);
  $status = $stmt->execute();
    // var_dump($status); // 問題なし
    // exit("sssss");


// id を取得 
  $sql2 = 'SELECT * FROM login_table WHERE id=:id'; 
  $stmt2 = $pdo->prepare($sql2);
  $stmt2->bindValue(':id', $_SESSION["id"]);
  $status2 = $stmt2->execute();
  $result = $stmt2->fetch(); // 1 レコードのみ配列で取得
  $_SESSION["pname"] = $result['pname'];


// エラー確認
  if($status == false || $status2 == false){  
      $error = $stmt->errorInfo();  
      exit("QueryError:".$error[2]);
  }

 
// 3. 抽出データ数を取得
   $val = $stmt->fetch(); // 1 レコードのみ配列で取得
  //  var_dump($val); // エラー出る
  //  exit("sssss");


// pname がない場合はダミー画像、ある場合は pname を表示。
  if($_SESSION["pname"] == null){
    $view = '<a href="create_profile.php"><img class="head_profile_img" src="https://placehold.jp/24/e3e3e6/ffffff/200x200.png?text=%E3%83%97%E3%83%AD%E3%83%95%E3%82%A3%E3%83%BC%E3%83%AB%0A%E7%94%BB%E5%83%8F%E3%82%92%E8%BF%BD%E5%8A%A0" alt="プロフィール画像"></a>';
  }else{
    $view = '<a href="create_profile.php"><img class="head_profile_img" src="images/'.$_SESSION["pname"].'" alt="プロフィール画像"></a>';
  }


?>



<!--------------------------------------------------- HTML ------------------------------------------------->
<!--------------------------------------------------- HTML ------------------------------------------------->
<!--------------------------------------------------- HTML ------------------------------------------------->

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="img/logo_b.png">
    <title>Image</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300&display=swap" rel="stylesheet">    
</head>
<body>

<!-- ーーーーーーーーーーーーーーーーー header ーーーーーーーーーーーーーーーーー -->


<header>

<!-- ホームに戻るボタン -->
  <div>
      <a class="home_btn" href="main.php"><img  class="home_btn" src="img/home.png" alt=""></a>
  </div>
<!-- ログアウトボタン -->
  <div class="header_p">
      <a href="login/logout.php">ログアウト</a>
  </div>

<!-- プロフィール写真の表示 -->
  <div class="head_profile_img_area">
    <?= $view ?>
  </div>
</header>    



<!-- ーーーーーーーーーーーーーーーーー main ーーーーーーーーーーーーーーーーー -->
<main>
<div class="center">



<!-- form 箇所 -->
  <form method="post" action="insert.php" enctype="multipart/form-data">
    <!-- 画像表示箇所 -->
    <label for="post_upload" class="cms-thumb" >
      <input type="file" id="post_upload" name="fname" accept="image/*" required>
      <img src="https://placehold.jp/38/f0f0f0/ffffff/320x240.png?text=%E7%94%BB%E5%83%8F%E3%82%92%E9%81%B8%E6%8A%9E" alt="ダミー画像" width="350">
    </label>
    <!-- 画像の説明文の箇所 -->
    <h2>写真の思い出</h2>
    <textarea name="description" id="" cols="30" rows="10"></textarea>

    <div>
      <input class="btn" type="submit" value="保存">
    </div>
    
  </form>


</div>
</main>


<!--------------------------------------------------- CSS ------------------------------------------------->
<!--------------------------------------------------- CSS ------------------------------------------------->
<!--------------------------------------------------- CSS ------------------------------------------------->


<style>
  /* 写真選択画像の設定と見た目の変更 */
    label > input {
        display:none; /* アップロードボタンのスタイルを無効にする */
    }

    label > img{
        border-radius:5px;
        cursor: pointer;
        margin-top: 30px;
        margin-bottom: 10px;
    }



  /* 写真一覧（main.php）に戻るホームボタン */
    .home_btn{
      position: absolute;
      cursor: pointer;
      width: 30px;
      height: 30px;
      left: 8px;
      top: 7px;
      margin:0;
    }



  /* textarea のスタイル */
    textarea{
      width: 450px;
      border: 1px solid #696969;
      border-radius:5px;
    }
    /* 選択時 */
    textarea:focus { 
    border: 3px solid #b59aff;
    outline: 0;
    }


  /* button のスタイル */
    .btn {
      font-size:18px;
      border-radius:5px;
      border-style:none;
      margin-top: 40px;
      cursor: pointer;
      font-weight: bold;
      padding:  12px 50px;
      color: #FFF;
      background: #00bcd4;
      transition: .3s;
    }
    .btn:hover {
      background: #1ec7bb;
    }

</style>



<!--------------------------------------------------- JS ------------------------------------------------->
<!--------------------------------------------------- JS ------------------------------------------------->
<!--------------------------------------------------- JS ------------------------------------------------->

<script src="http://code.jquery.com/jquery-3.0.0.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

<script>

//ーーーーーーーーーーーーーーーーー 画像サムネイル表示 ーーーーーーーーーーーーーーーーー

  // アップロードするファイルを選択
  $('input[type=file]').change(function() {
    //選択したファイルを取得し、file変数に格納
    var file = $(this).prop('files')[0];
    // 画像以外は処理を停止
    if (!file.type.match('image.*')) {
      // クリア
      $(this).val(''); //選択されてるファイルを空にする
      $('.cms-thumb > img').html(''); //画像表示箇所を空にする
      return;
    }
    // 画像表示
    var reader = new FileReader(); //1
    reader.onload = function() {   //2
      $('.cms-thumb > img').attr('src', reader.result);
    }
    reader.readAsDataURL(file);    //3
  });
    


</script>

</body>
</html>