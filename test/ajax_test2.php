<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<table>
  <thead>
    <tr><th>Checkbox
  <tbody>
    <tr>
      <td><input type="checkbox" class="chk" name="ago" value="a1">
    <tr>
      <td><input type="checkbox" class="chk" name="ago" value="a2">
    <tr>
      <td><input type="checkbox" class="chk" name="ago" value="a3">
    <tr>
      <td><input type="checkbox" class="chk" name="ago" value="a4">  
    <tr>
      <td><input type="checkbox" class="chk" name="ago" value="a5">
</table>
        
<button type='button' id='btn1' class="btn-square">map</button>
        
<button type='button' id='btn2' class="btn-square-shadow">each</button>






<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script>

$("#btn1").on("click", function(){
  
  // チェックされている値を配列に格納
  var chks = $('[class="chk"]:checked').map(function(){
      // 無効化する
      $(this).prop('disabled', true);
      // 値を返す
      return $(this).val();
  }).get();   // オブジェクトを配列に変換するメソッド
  
  console.log(chks);
  // ["a2", "a3"]
   
  // Ajax 処理
  $.ajax({
    type: "POST",
    url: "ago.php",
    data: {'checkbox' : chks},
    dataType : "json"
  }).done(function(data){
    // 成功した時の処理
   
    // 例えば、「 map 」ボタン無効化
    $('#btn1').prop('disabled', true);
   
  }).fail(function(XMLHttpRequest, textStatus, error){
    // 失敗した時の処理
  });
});



</script>


</body>
</html>