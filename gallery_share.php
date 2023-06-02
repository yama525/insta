<?php
    session_start();
  include("funcs.php");

// DB 接続
  $pdo = db_conn();

// ログインチェック
//   loginCheck();

// 右上アイコンで pname がない場合はダミー画像、ある場合は pname を表示。
    if($_SESSION["pname"] == null){
        $view2 = '<a href="create_profile.php"><img class="head_profile_img" src="https://placehold.jp/24/e3e3e6/ffffff/200x200.png?text=%E3%83%97%E3%83%AD%E3%83%95%E3%82%A3%E3%83%BC%E3%83%AB%0A%E7%94%BB%E5%83%8F%E3%82%92%E8%BF%BD%E5%8A%A0" alt="プロフィール画像"></a>';
    }else{
        $view2 = '<a href="create_profile.php"><img class="head_profile_img" src="images/'.$_SESSION["pname"].'" alt="プロフィール画像"></a>';
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
            

    

// inner join で id から写真を取得
    $stmt2 = $pdo->prepare(" SELECT * FROM pg_relation_table AS PG
    INNER JOIN gallery_table AS G ON G.id = PG.g_id
    INNER JOIN posts_table AS P ON P.id = PG.p_r_id
    WHERE G.priv = 0");
    $status2 = $stmt2->execute(); // OK


// SQL からデータ抽出
    $sql = 'SELECT * FROM gallery_table WHERE priv=0'; // 0 が公開されているギャラリー
    $stmt = $pdo->prepare($sql);
    $status = $stmt->execute();
        // var_dump($status); // 問題なし
        // exit("sssss");


// エラー確認
    if($status == false){  
        $error = $stmt->errorInfo();  
        exit("QueryError:".$error[2]);
    }

 
// 3. 抽出データ数を取得と表示
    $view = "";
    while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 

        $view .= '<li>';
        $view .= '<a href="new_gall.php?id='.$result["id"].'"><h2>'.$result["g_name"].'</h2></a>';
        $view .= '<p class="gall_des">'.$result["g_des"].'</p>';
        
            // $view3 = "";
            $view3 .= '<ul class="slider">';
            while( $result2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
                // echo $result2["fname"];
                // exit(); //OK

                $view3 .=       '<li class="gall_list_img">';
                $view3 .=          '<a href="#"><img src="images/'.$result2["fname"].'" ></a>'; // fname OK
                $view3 .=       '</li>';
                
            }
            $view3 .=     '</ul>';
        $view .= '</li>';
        $view .= $view3;
        $view .= '<hr>';
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300&display=swap" rel="stylesheet">    
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
				
</head>
<body>
    
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
            <h2>ギャラリーシェア</h2>
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
        


<main>

<div class="shared_gall">
  <ul class="gall_lists">

        <li>
            <?= $view ?>
            <!-- <ul class="slider"> -->
              
            <!-- </ul> -->
        </li>

    </ul>
</div>





</main>



<style>
    body{
        text-align: center;
    }
    
    hr {
        height: 8px;
        background-image: repeating-linear-gradient(45deg, #ccc 0, #ccc 1px, transparent 0, transparent 50%), repeating-linear-gradient(135deg, #ccc 0, #ccc 1px, transparent 0, transparent 50%);
        background-size: 8px 8px;
        width: 1000px;
    }

/*==================================================
スライダーのためのcss
===================================*/
.slider {/*横幅94%で左右に余白を持たせて中央寄せ*/
   width:94%;
    margin:0 auto;
}

.slider img {
    width:68%;/*スライダー内の画像を横幅100%に*/
    height:auto;
}

/*slickのJSで書かれるタグ内、スライド左右の余白調整*/

.slider .slick-slide {
    margin:0 ;
}

/*矢印の設定*/

/*戻る、次へ矢印の位置*/
.slick-prev, 
.slick-next {
    position: absolute;/*絶対配置にする*/
    top: 42%;
    cursor: pointer;/*マウスカーソルを指マークに*/
    outline: none;/*クリックをしたら出てくる枠線を消す*/
    border-top: 2px solid #666;/*矢印の色*/
    border-right: 2px solid #666;/*矢印の色*/
    height: 15px;
    width: 15px;
}

.slick-prev {/*戻る矢印の位置と形状*/
    left: -1.5%;
    transform: rotate(-135deg);
}

.slick-next {/*次へ矢印の位置と形状*/
    right: -1.5%;
    transform: rotate(45deg);
}

/*ドットナビゲーションの設定*/

.slick-dots {
    text-align:center;
	margin:0 0 0 0;
}

.slick-dots li {
    display:inline-block;
	margin:0 ;
}

.slick-dots button {
    color: transparent;
    outline: none;
    width:8px;/*ドットボタンのサイズ*/
    height:8px;/*ドットボタンのサイズ*/
    display:block;
    border-radius:50%;
    background:#ccc;/*ドットボタンの色*/
}

.slick-dots .slick-active button{
    background:#333;/*ドットボタンの現在地表示の色*/
}
/*==================================================
スライダーのためのcss ここまで
===================================*/



</style>




<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<script>
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



// スライドショーの設定
$('.slider').slick({
		autoplay: true,//自動的に動き出すか。初期値はfalse。
		infinite: true,//スライドをループさせるかどうか。初期値はtrue。
		slidesToShow: 6,//スライドを画面に3枚見せる
		slidesToScroll: 3,//1回のスクロールで3枚の写真を移動して見せる
		prevArrow: '<div class="slick-prev"></div>',//矢印部分PreviewのHTMLを変更
		nextArrow: '<div class="slick-next"></div>',//矢印部分NextのHTMLを変更
		dots: true,//下部ドットナビゲーションの表示
		responsive: [
			{
			breakpoint: 769,//モニターの横幅が769px以下の見せ方
			settings: {
				slidesToShow: 2,//スライドを画面に2枚見せる
				slidesToScroll: 2,//1回のスクロールで2枚の写真を移動して見せる
			}
		},
		{
			breakpoint: 426,//モニターの横幅が426px以下の見せ方
			settings: {
				slidesToShow: 1,//スライドを画面に1枚見せる
				slidesToScroll: 1,//1回のスクロールで1枚の写真を移動して見せる
			}
		}
	]
	});

</script>

</body>
</html>