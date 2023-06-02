


<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="./style.css" />
  </head>
  <body>
    <div id="main">
      <ul class="gallery">

        <li>
          <div class="image_box">
            <img class="img_for_check" src="../img/logo_a.png">
            <input class="checkbox" type="checkbox" checked >  <!-- 画像の後に input を置こう -->

          </div>
        </li>

        <li>
          <div class="image_box">
            <img class="img_for_check" src="../img/logo_b.png">
            <input class="checkbox" type="checkbox" checked >  <!-- 画像の後に input を置こう -->
          </div>
        </li>

        <li>
          <div class="image_box">
            <img class="img_for_check" src="../img/logo_c.png">
            <input class="checkbox" type="checkbox" checked >  <!-- 画像の後に input を置こう -->
          </div>
        </li>
      </ul>

    </div>



<style>
    li {
        display: inline-block;
    }

    .image_box {
        position: relative;
    }

    .img_for_check {
         cursor: pointer;
    }

    .img_for_check.checked {
        border: 6px solid blue;
        box-sizing: border-box;
    }

    .checkbox {
        position: absolute;
        top: 12px;
        right: 12px;
        display: none;
        transform: scale(2);
        cursor: pointer;
    }

    .img_for_check.checked + .checkbox {
        /* 画像にcheckedクラスが指定されたときは、
        チェックボックスの非表示を解除します。 */
        display: block;
    }


</style>





<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
    $(function() {

        // チェックボックスのクリックを無効化
            $('.image_box .checkbox').click(function() {
                    return false;
            });

        // 画像がクリックされた時の処理
            $('.img_for_check').click(function() {

                    $(function() {
                        // チェックボックスのクリックを無効化（2 回目）
                            $('.image_box .checkbox').click(function() {
                                return false;
                            });

                        // 画像がクリックされた時の処理
                            $('.img_for_check').on('click', function() {
                                if (!$(this).is('.checked')) {  // チェックが入っていない画像をクリックした場合、チェックを入れる
                                    $(this).addClass('checked');
                                } else {
                                    $(this).removeClass('checked') // チェックが入っている画像をクリックした場合、チェックを外す
                                }
                            });
                    });

                // チェックを入れた状態にします。
                    $(this).addClass('checked');
            });
});

    </script>







  </body>
</html>