

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="scss/login.css">

</head>
<body>

<div class="wrapper">
    <form class="login" method="POST" action="login_insert.php">
            <p class="title">アカウント作成</p>
            <input name="u_name" type="text" placeholder="名前" autofocus/>
            <i class="fas fa-pen"></i>

            <input name="u_id" type="text" placeholder="ユーザー名" autofocus/>
            <i class="fa fa-user"></i>

            <input name="pass" type="password" placeholder="パスワード" />
            <i class="fa fa-key"></i>

            <a href="login.php">アカウントをお持ちの場合</a>


            <button>
                <i class="spinner"></i>
                <span class="state"><input class="submit" type="submit" value=" アカウントを作成 "></span>
            </button>
            
    </form>
</div>


<script src="https://kit.fontawesome.com/c46f55df8f.js" crossorigin="anonymous"></script>

</body>
</html>