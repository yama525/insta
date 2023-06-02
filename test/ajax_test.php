<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Ajax、PHP、MySQLの連携</title>
<link rel="stylesheet" href="">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
</head>
<body>

IDを入力:<input id="id_number" type="number"><br>

<div id="result">
 <p>数値を入力してボタンを押してください。</p>
</div>
<button id="ajax">ボタン</button>

<script>
$(function(){

 $('#ajax').on('click',function(){

  $.ajax({
   url:'./dbconnect.php', //送信先
   type:'POST', //送信方法
   datatype: 'json', //受け取りデータの種類
   data:{'id' : $('#id_number').val()}

   })
   // Ajax通信が成功した時
   .done( function(data) {
   $('#result').html("<p>ID番号"+data[0].id+"は「"+data[0].name+"」さんです。<br>メールアドレスは「"+data[0].mail+"」です。</p>");
   console.log('通信成功');
   console.log(data);
   })
   // Ajax通信が失敗した時
   .fail( function(data) {
   $('#result').html(data);
   console.log('通信失敗');
   console.log(data);
   })
 }); //#ajax click end

}); //END
</script>

</body>
</html>