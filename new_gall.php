
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


// 前のページから GET でギャラリーの id を取得
    $id = $_GET["id"];
    // echo $id;
    // exit();  // OK


// リレーションテーブル（pg_relation_table）の g_id と、今いるギャラリー（gallery_table）の id で一致するものを検索
    $stmt3 = $pdo->prepare("SELECT * FROM gallery_table WHERE id=:id");
    $stmt3->bindValue(':id', $id, PDO::PARAM_INT);
    $status3 = $stmt3->execute();  // OK

    // エラー確認
        if($status3 == false){  
            $error = $stmt->errorInfo();  
            exit("QueryError:".$error[2]);
        }

    // エラーがなかったら、このギャラリーにある p_r_id を取得（複数なので、while で取得）
        $result3 = $stmt3->fetch(PDO::FETCH_ASSOC);


        // echo $result3["priv"]; // ok
        // exit();
        



 

    
// // リレーションテーブル（pg_relation_table）の p_r_id と、投稿（post_table）の id で一致するものを検索
    // $stmt = $pdo->prepare("SELECT * FROM posts_table WHERE id=:id");
    // $stmt->bindValue(':id', $result3["p_r_id"], PDO::PARAM_STR);
    // $status = $stmt->execute(); // OK
    // // var_dump($result3["p_r_id"]);
    // // exit();


    

// 1⃣ inner join で pg_relation_table の g_id と、今いるギャラリー gallery_table の id で結合
    // $stmt4 = $pdo->prepare("SELECT * FROM gallery_table INNER JOIN pg_relation_table ON gallery_table.id = pg_relation_table.g_id");
    // // $stmt2->bindValue(':id', $result3["g_id"], PDO::PARAM_STR); // bindValue いるの？どう書くの？
    // $status4 = $stmt->execute(); // OK


// 2⃣ inner join で pg_relation_table の p_r_id と、投稿 post_table の id で結合

    // $stmt = $pdo->prepare("SELECT * FROM posts_table INNER JOIN pg_relation_table ON posts_table.id = pg_relation_table.p_r_id");
    // // $stmt->bindValue(':id', $result3["p_r_id"], PDO::PARAM_STR); // bindValue いるの？どう書くの？
    // $status = $stmt->execute(); // OK


    $stmt = $pdo->prepare(" SELECT * FROM pg_relation_table AS PG
                            INNER JOIN gallery_table AS G ON G.id = PG.g_id
                            INNER JOIN posts_table AS P ON P.id = PG.p_r_id
                            WHERE PG.g_id = :g_id");
    $stmt->bindValue(':g_id', $_GET["id"], PDO::PARAM_STR); // bindValue いるの？どう書くの？
    $status = $stmt->execute(); // OK
    

    // SELECT * FROM pg_relation_table as PG 
    // INNER JOIN gallery_table AS G ON G.id = PG.g_id
    // INNER JOIN posts_table AS P ON P.id = PG.p_r_id
    // WHERE PG.g_id = 1;
    


// 投稿一覧画面ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー
    // このユーザーが保有している投稿データの表示
            $view="";
            $modal="";
            if($status==false) {
                
            //  execute（SQL実行時にエラーがある場合）
                $error = $stmt->errorInfo();
                exit("ErrorQuery:".$error[2]);

            } else {
        // 投稿写真の表示

                
            // while での表示箇所
                while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 
                    // echo $result;
                $view .= '<li class="icons_li">';
            
                // 画像表示
                    $view .= '<a href="images/'.$result["fname"].'" data-lightbox="gallery1" data-title="'.$result["description"].'"><img class="img_posts" src="images/'.$result["fname"].'" width="200"></a>';
                    $view .= '<input class="checkbox" type="checkbox" value="'.$result["id"].'">';

                // 投稿の編集ボタン
                    $view .= '<a class="edit_post">';  
                    $view .= '<img class="icon pen_icon" src="./img/pen.png" width="20px">'; // 編集ボタンを設置
                    $view .= '</a>'; 

                // 削除ボタン
                    $view .= '<a class="del_post" href="delete.php?id='.$result["id"].'">'; 
                    $view .= '<img class="icon" src="./img/bin.png" width="20px">'; // 削除ボタンを設置
                    $view .= '</a>'; 

                $view .= '</li>';


                }
                // exit();

            // 投稿編集のモーダル
                $modal .= '<form method="post" action="update_act.php" enctype="multipart/form-data">';
                // <!-- 写真編集箇所 -->
                    $modal .= '<label for="file_edit" class="cms-thumb">'; 
                    $modal .= '<input class="file_edit_input" type="file" id="file_edit" name="fname" accept="image/*">';
                    $modal .= '<img class="file_edit_img" src="images/'.$result["fname"].'">';
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
                    $modal .= '<input class="post_update_id" type="hidden" name="id" value="'.$result["id"].'">';
                 $modal .= '</form>';

            }




// ユーザーデータ抽出（こちらはユーザー（login_table）の id と、ギャラリー（gallery_table）の c_userid で一致するものを検索）
    $stmt2 = $pdo->prepare("SELECT * FROM gallery_table WHERE c_userid=:c_userid");
    $stmt2->bindValue(':c_userid', $_SESSION["id"], PDO::PARAM_STR);
    $status2 = $stmt2->execute();
    $gall_room="";
    $modal3="";
    if($status2==false) {
    //  execute（SQL実行時にエラーがある場合）
        $error = $stmt2->errorInfo();
        exit("ErrorQuery:".$error[2]);

    } else {
        // メニュー内のギャラリーにギャラリー名表示
            while( $result2 = $stmt2->fetch(PDO::FETCH_ASSOC)){ 
                
                $gall_room .= '<li><a href="new_gall.php?id='.$result2["id"].'">'.$result2["g_name"].'</a></li>';


                

                // 移動先ギャラリーを表示（ラジオボタンでの選択）
                    // $modal3 .= '<div id="move_radio" class="radio"><input class="radio_box" type="radio" name="g_name" value="'.$result2["id"].'">'.$result2["g_name"].'</div>';

            }

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
        <div class="space"></div>
            <div class="openbtn">
                <div class="openbtn-area">
                <span></span><span></span><span></span>
                </div>
            </div>
        

    <!-- 現在のギャラリー名 -->
        <div class="gall_title">
            <h2><?= $result3["g_name"] ?></h2>
        </div>


    <!-- 中央のアイコン集 -->

        <div class="editers">

            <input class="color_editer" type="color" name="color_changer" value="#ffffff">
            <img class="private_on editer_icons" src="img/key_b.png" alt="プライベート設定">
            <img class="private_off editer_icons" src="img/key_g.png" alt="プライベート設定" style="display: none">

        </div>



    <!-- 右側のメニュー -->
        <div class="header_p off_edit">       <!-- off_edit クラスは編集中は消す処理を実装 -->
            <a id="post_edit">編集</a>        <!-- 編集ボタン -->
        </div>
        <!-- <div class="header_p">
            <a  id="choose_gall" style="display: none">ギャラリーへ移動</a>
        </div> -->
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
                        <a class="add_new_gall">+ ギャラリーを追加</a>
                        <?= $gall_room ?>
                    </ul>
                </li>
                <li><a class="moveto_gall_share" href="gallery_share.php">ギャラリーシェア</a></li>
                <li><a id="logout_btn" href="login/logout.php">ログアウト</a></li>    <!-- ログアウトボタン -->
            </ul>
        </nav>


        <!-- ギャラリー作成時のモーダル（modal2）を表示 -->
            <div class="modal2" style="display:none">
                <!-- モーダルの外側の暗い所 -->
                    <div class="modal-overlay close_modal"></div>
                <!-- モーダルの本体と投稿編集処理 -->
                    <div class="my_modal">
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

<div class="wrapper">

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

        <!-- 写真選択時にギャラリーに移動させるモーダル -->
            <div class="modal3" style="display:none">
                <!-- モーダルの外側の暗い所 -->
                    <div class="modal-overlay close_modal"></div>
                <!-- モーダルの本体と投稿編集処理 -->
                    <div class="my_modal">
                        <!-- ------フォーム箇所------ -->
                        <h3>移動先のギャラリーを選択</h3>

                    <!-- とりあえず自分で ajax やってみる -->
                        <!-- <form method="post" action="new_gall_update.php">   -->
                            <?= $modal3 ?>
                            <!-- <input type="hidden" name="post_id" value=`${chks}`> -->
                            <!-- <div > -->
                                <input class="btn gall_move_btn" type="submit" value="移動先に保存">
                                <!-- ↓ テスト  本番は ↑ -->
                                <!-- <input type="button" class="btn gall_move_btn"> -->
                            <!-- </div> -->
                        </form>
                    </div>
            </div>


<!-- ーーーーーーーーーー PHP で書いた処理の表示場所 ーーーーーーーーーー -->
    <div class="post">
        <ul class="gallery">
            <?= $view ?>        <!-- ここで表示 -->
        </ul>
    </div>




</div>
</main>



<!-- ---------------------------------------------------------------------------------- -->
<!-- ------------------------------------- style ------------------------------------- -->
<!-- ---------------------------------------------------------------------------------- -->
<style>

body{
    width: 100vw;
    height: 100vh;
    background-color:<?= $result3["b_color"] ?>;
    
}

.wrapper{
    width: 100%;
    height: 100%;   
    background-color:<?= $result3["b_color"] ?>;
    
}


投稿
/*ーーーーーーーーーー 基本的な編集 ーーーーーーーーーー*/
/* 画像の角丸 */
    img{
        border-radius:5px;
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



/* 編集時の自作モーダルの表示 */
    /* モーダル本体 */
        /* （編集ボタンを押した時、表示される） */
            .my_modal{
                width: 25%;
                border-radius:5px;
                margin:0 auto;            
                background-color:#f5f5f5;
                z-index: 7;
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
                z-index:6;
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
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.min.js"></script>
<script>

// ーーーーーーーーーーーーーーーーーー投稿モーダルの処理ーーーーーーーーーーーーーーーーーーーーー

//lightbox オプションの設定※ https://lokeshdhakar.com/projects/lightbox2/#options 参照
    lightbox.option({
        'wrapAround': true,//グループ最後の写真の矢印をクリックしたらグループ最初の写真に戻る
        'albumLabel': ' %1 / total %2 '//合計枚数中現在何枚目かというキャプションの見せ方を変更できる
    })


// ーーーーーーーーーーーーーーーーーーheader スライドで現れる処理ーーーーーーーーーーーーーーーーーー

// $(".header_wrapper").mouseover(function(){
//     $("header").fadeIn();
// });

// $(".header_wrapper").mouseout(function(){
//     $("header").fadeOut();
// });

    


// ーーーーーーーーーーーーーーーーーー投稿の編集系の処理ーーーーーーーーーーーーーーーーーー

// 編集ボタンを押した時、投稿の編集ができるようになる処理
        $("#post_edit").on("click", function () {
            $(".off_edit").hide();
            $("#post_edit_end").show();
            $("#choose_gall").show();
            $(".icon").fadeIn("slow");
            // $(".checkbox").show();
        });
    // キャンセルボタンを押して編集を終了
        $("#post_edit_end").on("click", function () {
            $(".off_edit").show();
            $("#post_edit_end").hide();
            $("#choose_gall").hide();
            $(".icon").hide();
            // $(".checkbox").hide();
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


        // ーーー 選択した写真をギャラリーに移動画面のモーダル ーーー
            // 編集アイコンボタンを押した後、モーダルを表示させる
                $("#choose_gall").on("click", function () {
                        $(".modal3").fadeIn("slow");
                    });
                
                // 外枠を押したときモーダルを消す処理
                    $(".close_modal").on("click", function () {
                        $(".modal3").fadeOut("slow");
                    });




//ーーーーーーーーーーーーーーーーー 更新処理で modal に投稿情報を記載する Ajax ーーーーーーーーーーーーーーーーー

// 編集ペンアイコンをクリックしたら
var $li = $('.pen_icon').eq(0).closest('ul').children();

$(".pen_icon").on("click", function(e){
    console.log(e.target)
    // li のインデックス番号取得方法
        e.preventDefault();
        let n = $li.index($(this).closest('li'));
        // location.href = "dbconnect.php"

    $.ajax({
        url:'./dbconnect.php', //送信先
        dataType: "json"

        
    // Ajax通信が成功した時
        }).done(function(data) {
        
            // 画像の表示 下では完全な画像の URL を取得
                // const imgUrl = location.href.split('/').slice(0,4).join('/') + '/images/' + data[n].fname // こっちでも写真情報の取得可能
                $('.file_edit_img').attr('src',`images/${data[n].fname}`);  
                // $('.file_edit_input').attr('value',`${imgUrl}`);  

            // 説明文
                $('.update_text').html(`${data[n].description}`);

            // id を取得
                $('.post_update_id').attr('value', `${data[n].id}`);


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


// ーーーーーーーーーーーー 投稿画像モーダルサムネイル更新表示 ーーーーーーーーーーーー
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




// //ーーーーーーーーーーーーーーーーー 背景の色変え axios ーーーーーーーーーーーーーーーーーーーーー



    // ーーーーーーーーーー バックグラウンドカラーの変更処理（色変えた時） ーーーーーーーーーー
        
    $(".color_editer").on("change", function () {
            let choose_color = $(".color_editer").val();
            console.log(choose_color); // 値の取得 OK
            $("body").css('background-color',`${choose_color}`);
        });


$(".color_editer").on("change", function () {

    const params = new URLSearchParams();

// 色の値を取得
    let choose_color = $(".color_editer").val();
    console.log(choose_color); // 値の取得 OK

        //Ajax（非同期通信）post ーーーーーーーー
            params.append('id', <?= $id ?>); // id を上の方で取得してるから活用
            params.append('b_color', `${choose_color}`); 

            //axiosでAjax送信
            axios.post('ajax_gallery.php',params).then(function (response) {
                console.log(response.data);//通信OK
                $(".wrapper").css('background-color',`${response.data}`);
            }).catch(function (error) {
                console.log(error);//通信Error
            }).then(function () {
                console.log("Last");//通信OK/Error後に処理を必ずさせたい場合
            });


    });



//ーーーーーーーーーーーーーーーーー ギャラリープライベートモード  ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー
// ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー
// //ーーーーーーーーーーーーーーーーー プライベート権限の変更 表示側 ーーーーーーーーーーーーーーーーーーーーー

if(<?= $result3["priv"] ?> == 1){
    $(".private_on").show();
    $(".private_off").hide();
}
if(<?= $result3["priv"] ?> == 0){
    $(".private_off").show();
    $(".private_on").hide();
}



//ーーーーーーーーーーーーーーーーー ギャラリープライベートモード 変更処理 ーーーーーーーーーーーーーーーーー
$(".private_on").on("click", function () {
        if(!confirm("このギャラリーを公開しますか？")){
            return false;
        }else{
            $(".private_off").show();
            $(".private_on").hide();
        }
        
    });

    $(".private_off").on("click", function () {
        $(".private_on").show();
        $(".private_off").hide();
    });

// //ーーーーーーーーーーーーーーーーー プライベート権限の変更 axios ーーーーーーーーーーーーーーーーーーーーー


$(".private_on").on("click", function () {  // on を押すとオフにする処理
const params = new URLSearchParams();
    //Ajax（非同期通信）post ーーーーーーーー
        params.append('id', <?= $id ?>); // id を上の方で取得してるから活用 OK
        params.append('priv', 0); 

        //axiosでAjax送信
        axios.post('ajax_gallery_priv.php',params).then(function (response) {
            console.log(response.data);//通信OK
        }).catch(function (error) {
            console.log(error);//通信Error
        }).then(function () {
            console.log("Last");//通信OK/Error後に処理を必ずさせたい場合
        });

});


$(".private_off").on("click", function () {
const params = new URLSearchParams();

    //Ajax（非同期通信）post ーーーーーーーー
        params.append('id', <?= $id ?>); // id を上の方で取得してるから活用
        params.append('priv', 1); 

        //axiosでAjax送信
        axios.post('ajax_gallery_priv.php',params).then(function (response) {
            console.log(response.data);//通信OK
        }).catch(function (error) {
            console.log(error);//通信Error
        }).then(function () {
            console.log("Last");//通信OK/Error後に処理を必ずさせたい場合
        });

});








// //ーーーーーーーーーーーーーーーーー 写真の一括選択 axios ーーーーーーーーーーーーーーーーー

// let chks ="";
// $(".gall_move_btn").on("click", function () {
    
//     // チェックボックスの値を取得
//         chks = $('[class="checkbox"]:checked').map(function(){
//             return $(this).val(); // 値を返す
//         }).get(); // オブジェクトを配列に変換するメソッド
//         console.log(chks); 
//     // ラジオボタンの値を取得
//         chks2 = $('[class="radio_box"]:checked').map(function(){
//             return $(this).val(); // 値を返す
//         }).get(); // オブジェクトを配列に変換するメソッド
//         console.log(chks2); 

//     //Ajax（非同期通信）ーーーーーーーー
//         const params = new URLSearchParams();
//         params.append('id',   chks2);
//         params.append('post_id', chks);

//         //axiosでAjax送信
//         axios.post('ajax_post.php',params).then(function (response) {
//             console.log(response.data);//通信OK
//         }).catch(function (error) {
//             console.log(error);//通信Error
//         }).then(function () {
//             console.log("Last");//通信OK/Error後に処理を必ずさせたい場合
//         });
// });





// 上記で取得した id の配列から該当の fname を取得-------------------------------------------------------------------------------------------

    // $explode = explode(",", $result3["post_id"]); // 文字列 → 配列（array(5) { [0]=> string(2) "50" [1]=> string(2) "51" [2]=> string(2) "52" [3]=> string(2) "53" [4]=> string(2) "54" }）
    // $inplode = "('".implode("', '", $explode)."')"; // 配列 → 文字列 ('50', '51', '52', '53', '54')

    // echo $inplode;
    // exit;

// パターン１ 文字列にして、IN で検索する
    // $stmt4 = $pdo->prepare("SELECT * FROM gallery_table WHERE id IN ($inplode)");
    // $status4 = $stmt4->execute();
    // $result4 = $stmt4->fetch();
    // var_dump($status4); 

// パターン２ 配列にして any で検索する
    // $arr = array[$explode]
    // $stmt4 = $pdo->prepare("SELECT * FROM gallery_table WHERE id = any($explode)");
    // $status4 = $stmt4->execute();
    // $result4 = $stmt4->fetch();
    // var_dump($status4); 



</script>
</body>
</html>