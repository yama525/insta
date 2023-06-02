


<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="./style.css" />
  </head>
  <body>
    <div id="main">
      <ul class="image_list">

        <li>
          <div class="image_box">
            <img class="img_for_check" src="../img/logo_a.png">
            <input class="checkbox" type="checkbox" checked>  <!-- 画像の後に input を置こう -->
          </div>
        </li>

        <li>
          <div class="image_box">
            <img class="img_for_check" src="../img/logo_b.png">
            <input class="checkbox" type="checkbox" checked>  <!-- 画像の後に input を置こう -->
          </div>
        </li>

        <li>
          <div class="image_box">
            <img class="img_for_check" src="../img/logo_c.png">
            <input class="checkbox" type="checkbox" checked>  <!-- 画像の後に input を置こう -->
          </div>
        </li>
      </ul>

    </div>



<style>
    li {
  display: inline-block;
}

.image_box{

}

.checkbox{
    position: relative;
    top: -7px;
    left: -28px;
    transform: scale(2);
}

.checked{
    display: block;
}



</style>





    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script>

    $(".checkbox").on("click", function(){
        return false;
    });

    $(".img_for_check").on("click", function(){
        if (!$(this).is('.checked')) {
      // チェックが入っていない画像をクリックした場合、チェックを入れます。
      $(this).addClass('checked');
    } else {
      // チェックが入っている画像をクリックした場合、チェックを外します。
      $(this).removeClass('checked')
    }
    });



  

    </script>







  </body>
</html>