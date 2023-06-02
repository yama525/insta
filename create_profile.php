<!-- 登録時のプロフィール写真追加画面 -->

<?php
session_start();
include("funcs.php");
// echo $_SESSION["id"]; ここまで id きてる。
// exit();

// ログインチェック
loginCheck();

// DB 接続
$pdo = db_conn();


// pname がない場合はダミー画像、ある場合は pname を表示。
if($_SESSION["pname"] == null){
  $view = '<img class="profile_img" src="https://placehold.jp/24/e3e3e6/ffffff/200x200.png?text=%E3%83%97%E3%83%AD%E3%83%95%E3%82%A3%E3%83%BC%E3%83%AB%0A%E7%94%BB%E5%83%8F%E3%82%92%E8%BF%BD%E5%8A%A0" width="300px" height="300px">';
}else{
  $view = '<img class="profile_img" src="images/'.$_SESSION["pname"].'" width="300px" height="300px">';
}



?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
<header>
  <div class="header_p off_edit">       <!-- off_edit クラスは編集中は消す処理を実装 -->
      <a href="select.php">投稿</a>    <!-- 新規投稿ボタン -->
      <a href="login/logout.php">ログアウト</a>    <!-- ログアウトボタン -->
  </div>
  <div class="header_p">
      <a id="post_edit_end" style="display: none">編集を終了</a>    <!-- 編集の終了ボタン（編集中のみ表示） -->
  </div>
</header>


<main>
  <div class="center">





    <form method="post" action="create_profile_insert.php" enctype="multipart/form-data">
      <h1>ようこそ <?= $_SESSION['u_name'] ?> さん</h1>     <!-- 登録したユーザーの名前を表示 -->
      <h2>プロフィール画像を追加しましょう！</h2>
        <label for="file_upload" class="cms-thumb" >
          <input type="file" id="file_upload" name="pname" accept="image/*" required>
          <?= $view ?>
        </label>
      <div>
        <a href="select.php">この手順をスキップする</a>        <!-- スキップボタン -->
        <input id="add_pro_btn" type="submit" value="登録">   <!-- 登録ボタン -->
      </div>
    </form>

    
  

  </div>
</main>


<style>
    label > input {
        display:none; /* アップロードボタンのスタイルを無効にする */
    }

    img{
        border-radius:50%;
        cursor: pointer;
        margin: 30px;
    }




</style>


<script src="http://code.jquery.com/jquery-3.0.0.js"></script>
<script>

// ーーーーーーーーーーーー 画像サムネイル表示 ーーーーーーーーーーーー
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



//  ーーーーーーー 画像が選択されていない時のアラート ーーーーーーー
  $("#add_pro_btn").on("click", function () {
    if($("#file_upload").val() == ""){   // まずはクリックしたときに「$("#file_upload").val()」で val の値を取得。今回は空白だったので、 == "" とすることにより解消
      alert("ファイルが選択されていません");
    }  
  });

</script>


</body>
</html>