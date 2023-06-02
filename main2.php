
<!-- ---------------------------------------------------------------------------------- -->
<!-- ------------------------------------- php ------------------------------------- -->
<!-- ---------------------------------------------------------------------------------- -->

<?php
session_start();
include("funcs.php");

// ログインチェック
    loginCheck();

// DB 接続
    $pdo = db_conn();


// 右上アイコンで pname がない場合はダミー画像、ある場合は pname を表示。
if($_SESSION["pname"] == null){
    $view2 = '<a href="create_profile.php"><img class="head_profile_img" src="https://placehold.jp/24/e3e3e6/ffffff/200x200.png?text=%E3%83%97%E3%83%AD%E3%83%95%E3%82%A3%E3%83%BC%E3%83%AB%0A%E7%94%BB%E5%83%8F%E3%82%92%E8%BF%BD%E5%8A%A0" alt="プロフィール画像"></a>';
  }else{
    $view2 = '<a href="create_profile.php"><img class="head_profile_img" src="images/'.$_SESSION["pname"].'" alt="プロフィール画像"></a>';
  }


// ユーザーデータ抽出（こちらはユーザー（login_table）の id と、投稿（post_table）の p_id で一致するものを検索）
    $stmt = $pdo->prepare("SELECT * FROM posts_table WHERE p_id=:p_id");
    $stmt->bindValue(':p_id', $_SESSION["id"], PDO::PARAM_STR);
    $status = $stmt->execute();



// 投稿一覧画面ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー
    // このユーザーが保有している投稿データの表示
            $view="";
            $modal="";
            if($status==false) {
                
            //  execute（SQL実行時にエラーがある場合）
                $error = $stmt->errorInfo();
                exit("ErrorQuery:".$error[2]);

            } else {

            // while での表示箇所
                while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 
                $view .= '<li class="icons_li">';
                
                // チェックボックス  機能ここまで消えたら終了。。。。
                    // $view .= '<form method="post" action="insert.php">';
                    //     $view .= '<div class="image_box">';
                            // 画像表示
                                $view .= '<a class="img_for_check" href="images/'.$result["fname"].'" data-lightbox="gallery1" data-title="'.$result["description"].'"><img class="img_posts" src="images/'.$result["fname"].'" width="200"></a>';
                                $view .= '<input class="checkbox" type="checkbox" checked >';
                    //     $view .= '</div>';
                    // $view .= '</form>';
                // 投稿の編集ボタン
                    // $view .= '<a class="edit_post" href="〇〇.php?id='.$result["id"].'">';  
                    $view .= '<a class="edit_post">';   // モーダル編集ができなかった場合、最悪href は「post_update.php?id='.$result["id"].'」を入れる 
                    $view .= '<img class="icon pen_icon" src="./img/pen.png" width="20px">'; // 編集ボタンを設置
                    $view .= '</a>'; 

                // 削除ボタン
                    $view .= '<a class="del_post" href="delete.php?id='.$result["id"].'">'; 
                    $view .= '<img class="icon" src="./img/bin.png" width="20px">'; // 削除ボタンを設置
                    $view .= '</a>'; 

                $view .= '</li>';

                }





            // モーダル  ※while の中か外かわからないからとりあえず外に書いた
                $modal .= '<form method="post" action="update_act.php">';
                // <!-- 写真編集箇所 -->
                    $modal .= '<label for="file_edit">';
                    $modal .= '<input type="file" id="file_edit" name="fname">';
                    
                    
//  ▲ 画像表示に苦戦中 ▲
                // パターン2
                    // $modal .= '<div class="file_edit_img></div>';
                // パターン1
                    $modal .= '<img class="file_edit_img" src="https://placehold.jp/24/e3e3e6/ffffff/200x200.png?text=%E3%83%97%E3%83%AD%E3%83%95%E3%82%A3%E3%83%BC%E3%83%AB%0A%E7%94%BB%E5%83%8F%E3%82%92%E8%BF%BD%E5%8A%A0">';
                    

                    $modal .= '</label>';
                // <!-- Discription 編集箇所 -->
                    $modal .= '<div class="modal_txt_area">';
                    $modal .= '<textarea class="update_text"name="description" cols="30" rows="10">'.$result["description"].'</textarea>';
                    $modal .= '</div>';
                // <!-- キャンセル、変更ボタン箇所 -->
                    $modal .= '<div class="modal_btns">';
                    $modal .= '<input class="close_modal modal_btn1" type="button" value="キャンセル">';   //<!-- 上記の modal-overlay と同様にキャンセル処理なので同じクラス名を付与 -->
                    $modal .= '<input class="modal_btn2" type="submit" value="保存">';      //<!-- form 内容の送信 -->
                    $modal .= '</div>';
                // <!-- 投稿の id も取得 -->
                    $modal .= '<input type="hidden" name="id" value="'.$result["id"].'">';
                    $modal .= '</form>';

            }


?>



<!-- ---------------------------------------------------------------------------------- -->
<!-- ------------------------------------- html ------------------------------------- -->
<!-- ---------------------------------------------------------------------------------- -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/logo_b.png">
    <title>Document</title>

    <!-- モーダル LightBox -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.min.css" />
    <!-- CSS 適用 -->
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300&display=swap" rel="stylesheet">    
    <header>

    <!-- ハンバーガーメニュー -->
        <div class="openbtn">
            <div class="openbtn-area">
            <span></span><span></span><span></span>
            </div>
        </div>

    <!-- ロゴ -->
        <div class="logo">
            <img src="img/logo_c.png">
        </div>

    <!-- 右側のメニュー -->
        <div class="header_p off_edit">       <!-- off_edit クラスは編集中は消す処理を実装 -->
            <a id="post_edit">編集</a>    <!-- 編集ボタン -->
        </div>
        <div class="header_p">
            <a id="post_edit_end" style="display: none">編集を終了</a>    <!-- 編集の終了ボタン（編集中のみ表示） -->
        </div>
        <!-- プロフィール写真の表示 -->
        <div class="head_profile_img_area">
            <?= $view2 ?>
        </div>

    </header>



    <!-- ーーーーー ハンバーガーメニュー押した時のメニュー ーーーーー -->
   
        <nav class="nav_menu" style="display: none">
        
            <ul>
                <li><a href="main.php">ホーム</a></li>
                <li><a href="select.php">+ 写真を投稿</a></li>    <!-- 新規投稿ボタン -->
                <li class="has-child"><a href="#">ギャラリー</a>
                    
                    <ul>
                        <a class="add_new_gall">+ ギャラリーを追加する</a>
                        <li><a href="#"><dl><dt><img src="images/01.jpeg" alt=""></dt><dd>About Top</dd></dl></a></li>
                        <li><a href="#"><dl><dt><img src="images/02.png" alt=""></dt><dd>About-1</dd></dl></a></li>
                    </ul>
                </li>
                <li><a id="logout_btn" href="login/logout.php">ログアウト</a></li>    <!-- ログアウトボタン -->
            </ul>
        </nav>


        <!-- ギャラリー作成時のモーダル（modal2）を表示 -->
            <div class="modal2" style="display:none">
                <!-- モーダルの外側の暗い所 -->
                    <div class="modal-overlay close_modal"></div>
                <!-- モーダルの本体と投稿編集処理 -->
                    <div class="my_modal2">
                        <!-- ------フォーム箇所------ -->
                            <h3>新しいギャラリーを作成</h3>
                                <form method="post" action="new_gall_act.php">
                                <!-- ギャラリー名（g_name） 入力箇所 -->
                                    <div class="gall_name gall_info">
                                        <p>ギャラリー名</p>
                                        <input class="" name="g_name" cols="30" rows="10" required>
                                    </div>
                                <!-- 説明文（g_des）編集箇所 -->
                                    <div class="modal_txt_area gall_info">
                                        <p>ギャラリーの説明</p>
                                        <textarea name="g_des" cols="30" rows="10"></textarea>
                                    </div>
                                <!-- キャンセル、変更ボタン箇所 -->
                                    <div class="modal_btns">
                                        <!-- <input class="close_modal modal_btn1" type="button" value="キャンセル">   //上記の modal-overlay と同様にキャンセル処理なので同じクラス名を付与 -->
                                        <input class="modal_btn2" type="submit" value="保存">      <!-- form 内容の送信 -->
                                    </div>
                                <!-- 投稿の id も取得 -->
                                    <!-- <input type="hidden" name="id" value="'.$result["id"].'"> -->
                                </form>
                    </div>
            </div>
        

<!-- ーーーーーーーーーーーーーーーーーー メイン箇所 ーーーーーーーーーーーーーーーーーー -->
<main>

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



<!-- ーーーーーーーーーー PHP で書いた処理の表示場所 ーーーーーーーーーー -->
    <div class="post">
        <ul class="gallery">
            <?= $view ?>        <!-- ここで表示 -->
        </ul>
    </div>



</main>



<!-- ---------------------------------------------------------------------------------- -->
<!-- ------------------------------------- style ------------------------------------- -->
<!-- ---------------------------------------------------------------------------------- -->
<style>
投稿
/*ーーーーーーーーーー 基本的な編集 ーーーーーーーーーー*/
/* 画像の角丸 */
    img{
        border-radius:2px;
    }


/*ーーーーーーーーーー ギャラリーのためのcss ーーーーーーーーーー*/
        .gallery{
            columns: 4;/*段組みの数*/
            padding:15px 15px 0 15px;/*ギャラリー左右に余白をつける*/
            margin:0;
        }

        .gallery li {
            margin-bottom: 20px;/*各画像下に余白をつける*/
            list-style: none;  

        }

    /*ギャラリー内のイメージは横幅100%にする*/
        .img_posts{
            width:100%;
            height:auto;
            vertical-align: bottom;/*画像の下にできる余白を削除*/}
        
        /* .img_posts:hover::before { なぜか hover が効かない
            background-color: rgba(0, 0, 0, 0.4);
        } */
            

    /* 横幅900px以下の段組み設定 */
        @media only screen and (max-width: 900px) {
            .gallery{
            columns:3;
            }	
        }

        @media only screen and (max-width: 768px) {
            .gallery{
            columns: 2;
            }	
        }

/* ーーーーーーー 新規ギャラリー生成時のモーダル ーーーーーーー */
    /* モーダル本体 */
        .my_modal2{
            width: 25%;
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

        /* ーーーーーーーーーーーー 新規ギャラリー生成時の自作モーダル内部の編集 ーーーーーーーーーーーー */

        /* input エリアの編集 */
            .gall_name > input{
                width: 88%;
                border-style:none;
                border-radius:2px;
                margin-bottom: 10px;
                padding:5px;
            }

            .gall_name > input:focus { 
                    border: 3px solid #a0d8ef;
                    outline: 0;
                }
            
            /* モーダル内の input, textarea の説明文の設定 */
                .gall_info > p {
                    text-align: left;
                    margin-left: 12px;
                    margin-bottom: 10px;
                }




/* ーーーーーーー投稿編集系の処理ーーーーーーー */
    /* 親要素である li につけてる */
        .icons_li{
            text-align: right;
        }

    /* アイコン自体の編集 */
        .icon{
            margin-right:10px;
            margin-top:5px;
            display:none;
        }



/* 編集時の自作モーダルの表示（編集ボタンを押した時、表示される） */
    /* モーダル本体 */
        .my_modal{
            width: 25%;
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
    
    
    /* ーーーーーーーーーーーー 自作モーダル内部の編集 ーーーーーーーーーーーー */
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
                border-style:none;
                border-radius:2px;
            }
            /* 選択時 */
                textarea:focus { 
                    border: 3px solid #a0d8ef;
                    outline: 0;
                }

        /* キャンセル、保存ボタンの編集 */
            .modal_btns > input{
                font-size: 14px;
                border-radius: 5px;
                border-style: none;
                margin-top: 15px;
                cursor: pointer;
                font-weight: bold;
                padding: 3px 10px;
                color: #FFF;
                transition: .3s;
                width: 80%;
                }
            
            /* ボタン自体 */
                .modal_btn1{
                    background: #2ca9e1;
                    margin-top: 10px;
                }
                .modal_btn2{
                    background: #2ca9e1;
                    margin-top: 8px;
                    margin-bottom:15px;

                }

                /* ホバー時 */
                    .modal_btn1:hover {
                        background: #a0d8ef;
                    }
                    .modal_btn2:hover {
                        background: #a0d8ef;
                    }

</style>


<!-- ---------------------------------------------------------------------------------- -->
<!-- ------------------------------------- script ------------------------------------- -->
<!-- ---------------------------------------------------------------------------------- -->

<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.min.js"></script>
<script>

// ーーーーーーーーーーーーーーーーーー投稿モーダルの処理ーーーーーーーーーーーーーーーーーーーーー

//lightbox オプションの設定※ https://lokeshdhakar.com/projects/lightbox2/#options 参照
    lightbox.option({
        'wrapAround': true,//グループ最後の写真の矢印をクリックしたらグループ最初の写真に戻る
        'albumLabel': ' %1 / total %2 '//合計枚数中現在何枚目かというキャプションの見せ方を変更できる
    })


// ーーーーーーーーーーーーーーーーーー投稿の編集系の処理ーーーーーーーーーーーーーーーーーー

// 編集ボタンを押した時、投稿の編集ができるようになる処理
        $("#post_edit").on("click", function () {
            $(".off_edit").hide();
            $("#post_edit_end").show();
            $(".icon").fadeIn("slow");


            // ーーーーーーーーーー 投稿一覧の複数選択チェックボックス ーーーーーーーーーー
            // 画像がクリックされた時の処理
                $('img.img_posts').click(function() {

                    $(function() {
                        // チェックボックスのクリックを無効化します。
                        $('.checkbox').click(function() {
                            return false;
                        });

                        // 画像がクリックされた時の処理（2 回目）
                        $('img.img_posts').on('click', function() {
                            if (!$(this).is('.checked')) {
                                $(this).addClass('checked'); // チェックが入っていない画像をクリックした場合、チェックを入れます。
                            } else {
                                $(this).removeClass('checked'); // チェックが入っている画像をクリックした場合、チェックを外します。
                            }
                        });
                    });

                    // チェックを入れた状態にする
                    $(this).addClass('checked');
                });

                // チェックボックスのクリックを無効化する
                $('.checkbox').click(function() {
                    return false;
                });

           
        });
    

    // キャンセルボタンを押して編集を終了
        $("#post_edit_end").on("click", function () {
            $(".off_edit").show();
            $("#post_edit_end").hide();
            $(".icon").hide();
            $("img.img_posts").removeClass('checked'); 
            $('img.img_posts').click(function() {
                return false;
            });

            // ーーーーーーーーーー 投稿一覧の複数選択チェックボックス ーーーーーーーーーー
            // 画像がクリックされた時の処理
            
        });


// 削除アイコンボタンを押した後、アラートで本当にポストを削除するか聞く処理
    $(".del_post").on("click", function () {
        if(!confirm("写真を削除")){
            return false;
        }else{
            location.href = main.php;
        }
    });


//ーーーーーーーーーーーーーーーーー ハンバーガーメニュー ーーーーーーーーーーーーーーーーー
$(".openbtn").click(function () {
    // ハンバーガーメニューボタン自体の動き
      $(this).toggleClass('active');

    // ハンバーガーメニュー押したときに表示されるメニュー
      $(".nav_menu").toggle(400);
        //ドロップダウンの設定を関数でまとめる
          function mediaQueriesWin(){
            var width = $(window).width();
            if(width <= 768) {//横幅が768px以下の場合 $(".has-child>a").off('click');	//has-childクラスがついたaタグのonイベントを複数登録を避ける為offにして一旦初期状態へ
              $(".has-child>a").on('click', function() {//has-childクラスがついたaタグをクリックしたら
                var parentElem =  $(this).parent();// aタグから見た親要素のliを取得し
                $(parentElem).toggleClass('active');//矢印方向を変えるためのクラス名を付与して
                $(parentElem).children('ul').stop().slideToggle(500);//liの子要素のスライドを開閉させる※数字が大きくなるほどゆっくり開く
                return false;//リンクの無効化
              });
            }else{//横幅が768px以上の場合
              $(".has-child>a").off('click');//has-childクラスがついたaタグのonイベントをoff(無効)にし
              $(".has-child>a").removeClass('active');//activeクラスを削除
              $('.has-child').children('ul').css("display","");//スライドトグルで動作したdisplayも無効化にする
            }
          }

        // ページがリサイズされたら動かしたい場合の記述
          $(window).resize(function() {
            mediaQueriesWin();/* ドロップダウンの関数を呼ぶ*/
          });

        // ページが読み込まれたらすぐに動かしたい場合の記述
          $(window).on('load',function(){
            mediaQueriesWin();/* ドロップダウンの関数を呼ぶ*/
          });
    });


    // ーーーーーーーーーー ギャラリー追加時のの自作モーダル（modal2）関係の動き ーーーーーーーーーー
        // 編集アイコンボタンを押した後、モーダルを表示させる
        $(".add_new_gall").on("click", function () {
                $(".modal2").fadeIn("slow");
            });
        
        // 外枠を押したときモーダルを消す処理
            $(".close_modal").on("click", function () {
                $(".modal2").fadeOut("slow");
            });





    
    



// ーーーーーーーーーー 編集時の自作モーダル（modal）関係の動き ーーーーーーーーーー
    // 編集アイコンボタンを押した後、モーダルを表示させる
    $(".edit_post").on("click", function () {
            $(".modal").fadeIn("slow");
        });
    
    // 外枠を押したときモーダルを消す処理
        $(".close_modal").on("click", function () {
            $(".modal").fadeOut("slow");
        });





//ーーーーーーーーーーーーーーーーー modal に投稿情報を記載する Ajax ーーーーーーーーーーーーーーーーー

// 検索ボタンをクリックしたら
var $li = $('.pen_icon').eq(0).closest('ul').children();

$(".pen_icon").on("click", function(e){
    // li のインデックス番号取得方法
        e.preventDefault();
        let n = $li.index($(this).closest('li'));

        // location.href = "dbconnect.php"

    $.ajax({
        url:'./dbconnect.php', //送信先
        dataType: "json"

        
    // Ajax通信が成功した時
        }).done(function(data) {
            console.log(`images/${data[n].fname}`);
            console.log(data); // オブジェクトの中を確認
            $('.update_text').html(`${data[n].description}`);


// ▲ 画像の表示が謎 ▲
        // パターン1
            $('.file_edit_img').html(`<img src="https://toretama.jp/img/mouseover-zoomup-image.jpg">`);  // 写真が表示されない
            // $('.file_edit_img').html(`<img src="images/${data[n].fname}">`);  // 写真が表示されない
        // パターン2
            $('.file_edit_img').children('img').attr('src', 'https://toretama.jp/img/mouseover-zoomup-image.jpg');  // 写真が表示されない
            // $('.file_edit_img').children('img').attr('src', `images/${data[n].fname}');  // 写真が表示されない


            console.log('通信成功');
            console.log(data);
        })
    // Ajax通信が失敗した時 参考：「https://hacknote.jp/archives/38740/」
        .fail( function(XMLHttpRequest, textStatus, errorThrown) {
            console.log('通信失敗');
            console.log("XMLHttpRequest : " + XMLHttpRequest.status);
            console.log("textStatus     : " + textStatus);
            console.log("errorThrown    : " + errorThrown.message);
        })
        // こっちでもいい。
            // .fail( function(data) {
            //     $('.update_text').html(data);
            //     console.log('通信失敗');
            //     console.log(data);
            // })
  
});






</script>
</body>
</html>