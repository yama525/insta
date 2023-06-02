<!-- 参考 https://github.com/woodroots/infiniteslidev2 -->
<!-- http://127.0.0.1:5500/index.html -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<!-- たとえばulの場合 -->
<ul class="infiniteslide">
    <div class="b"><li class="a"><img src="../images/01.jpeg" alt="" /></li></div>
    <div class="b"><li class="a"><img src="../images/02.png" alt="" /></li></div>
    <div class="b"><li class="a"><img src="../images/03.png" alt="" /></li></div>

</ul>
<ul class="infiniteslide2">
    <div class="b"><li class="a"><img src="../images/01.jpeg" alt="" /></li></div>
    <div class="b"><li class="a"><img src="../images/02.png" alt="" /></li></div>
    <div class="b"><li class="a"><img src="../images/03.png" alt="" /></li></div>

</ul>
<ul class="infiniteslide3">
    <div class="b"><li class="a"><img src="../images/01.jpeg" alt="" /></li></div>
    <div class="b"><li class="a"><img src="../images/02.png" alt="" /></li></div>
    <div class="b"><li class="a"><img src="../images/03.png" alt="" /></li></div>

</ul>
<ul class="infiniteslide4">
    <div class="b"><li class="a"><img src="../images/01.jpeg" alt="" /></li></div>
    <div class="b"><li class="a"><img src="../images/02.png" alt="" /></li></div>
    <div class="b"><li class="a"><img src="../images/03.png" alt="" /></li></div>

</ul>



<style>
    .infiniteslide{
        position:absolute;
        top:0;
        left:5%;
    }
    .infiniteslide2{
        position:absolute;
        top:0;
        left:30%;
    }
    .infiniteslide3{
        position:absolute;
        top:0;
        left:55%;
    }
    .infiniteslide4{
        position:absolute;
        top:0;
        left:80%;
    }


</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="infiniteslidev2.js"></script>
<script>
    $(function(){
	$('.infiniteslide').infiniteslide({
		speed: 300,
	direction: 'down'
	});
});

$(function(){
	$('.infiniteslide2').infiniteslide({
		speed: 300,
	direction: 'down'
	});
});

$(function(){
	$('.infiniteslide3').infiniteslide({
		speed: 300,
	direction: 'down'
	});
});
$(function(){
	$('.infiniteslide4').infiniteslide({
		speed: 300,
	direction: 'down'
	});
});
</script>

</body>
</html>