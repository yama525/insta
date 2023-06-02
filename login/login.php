

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" href="../img/logo_b.png">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="scss/login.css">
</head>
<body>


<div class="wrapper">
    <form class="login" method="POST" action="login_act.php">
        <p class="title">ログイン</p>
        <input name="u_id" type="text" placeholder="ユーザー ID" autofocus/>
        <i class="fa fa-user"></i>
        <input name="pass" type="password" placeholder="パスワード" />
        <i class="fa fa-key"></i>
        <a href="login_create.php">アカウントを作成</a>


        <button>
            <i class="spinner"></i>
            <span class="state"><input class="submit" type="submit" value=" ログイン "></span>
        </button>
            
    </form>
</div>


<style>



</style>



</body>
</html>