<!-- （わからない ID1）モーダルからの投稿情報編集。ペンマークからその投稿の id を取得する方法がわからない。 -->



<!-- ----------------------------------------- -->
<!-- PHP 箇所（たぶん while ループの内部か外部） -->
<!-- ----------------------------------------- -->

<?php
// モーダル
                    $modal .= '<form method="post" action="update_act.php">';
                // <!-- 写真編集箇所 -->
                    $modal .= '<label for="file_edit">';
                    $modal .= '<input type="file" id="file_edit" name="fname">';
                    $modal .= '<img class="file_edit_img" src="https://placehold.jp/24/e3e3e6/ffffff/200x200.png?text=%E3%83%97%E3%83%AD%E3%83%95%E3%82%A3%E3%83%BC%E3%83%AB%0A%E7%94%BB%E5%83%8F%E3%82%92%E8%BF%BD%E5%8A%A0">';
                    $modal .= '</label>';
                // <!-- Discription 編集箇所 -->
                    $modal .= '<div>';
                    $modal .= '<textarea name="description" cols="30" rows="10">'.$result["description"].'</textarea>';
                    $modal .= '</div>';
                // <!-- キャンセル、変更ボタン箇所 -->
                    $modal .= '<div>';
                    $modal .= '<input class="close_modal" type="button" value="キャンセル">';   //<!-- 上記の modal-overlay と同様にキャンセル処理なので同じクラス名を付与 -->
                    $modal .= '<input type="submit" value="変更">';      //<!-- form 内容の送信 -->
                    $modal .= '</div>';
                // <!-- 投稿の id も取得 -->
                    $modal .= '<input type="hidden" name="id" value="'.$result["id"].'">';
                    $modal .= '</form>';
?>





<!-- ----------------------------------------- -->
<!-- HTML（main の箇所の最初） -->
<!-- ----------------------------------------- -->

<!-- ーーーーーーーーーー 編集時に自作モーダルを表示させる ーーーーーーーーーー -->
<div class="modal" style="display:none">
        <!-- モーダルの外側の暗い所 -->
            <div class="modal-overlay close_modal"></div>
        <!-- モーダルの本体と投稿編集処理 -->
            <div class="my_modal">
                <!-- ------フォーム箇所------ -->
                <?= $modal ?> 
            </div>
    </div>






<!-- ----------------------------------------- -->
<!-- CSS 追加場所はどこでもいい。-->
<!-- ----------------------------------------- -->

<style>
/* 自作モーダルの表示（編集ボタンを押した時、表示される） */
        /* モーダル本体 */
        .my_modal{
            width: 25%;
            height: 65%;
            border-radius:5px;
            margin:0 auto;            
            background-color:#f5f5f5;
            z-index: 2;
            padding:10px 20px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            text-align: center;
        }
        /* 外側の暗い所 */
        .modal-overlay{
            z-index:1;
            position:fixed;
            top:0;
            left:0;
            width:100%;
            height:120%;
            background-color:rgba(0,0,0,0.75);
        }
    
    
    /* ーーーーーーーーーーーー モーダル内部の編集 ーーーーーーーーーーーー */
    /* 写真表示領域の編集 */
        /* アップロードボタンのスタイルを無効にする */
        label > input {
            display:none; 
        }

        .file_edit_img{
            cursor: pointer;
            width: 80%;
            padding-top: 25px;
            padding-bottom: 25px;
        }

    /* テキストエリアの編集 */
        textArea{
            width: 90%;
        }
</style>



<!-- ----------------------------------------- -->
<!-- JS の箇所 -->
<!-- ----------------------------------------- -->

<script>
// ーーーーーーーーーー モーダル関係の動き ーーーーーーーーーー
    // 編集アイコンボタンを押した後、モーダルを表示させる
        $(".edit_post").on("click", function () {
            $(".modal").fadeIn("slow");
        });
    
    // 外枠を押したときモーダルを消す処理
        $(".close_modal").on("click", function () {
            $(".modal").fadeOut("slow");
        });
</script>