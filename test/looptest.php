




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    


<div class="loop_wrap">
  <ul>
  <div class="b"><li class="a"><a href="#"><img src="https://i.gzn.jp/img/2018/01/15/google-gorilla-ban/00.jpg" alt=""></a></li></div>
  <div class="b"><li class="a"><a href="#"><img src="https://tk.ismcdn.jp/mwimgs/5/9/1140/img_59ee959e8de72d661bc73a524ac0f965202213.jpg" alt=""></a></li></div>
  <div class="b"><li class="a"><a href="#"><img src="https://storage.tenki.jp/storage/static-images/suppl/article/image/2/20/209/20941/1/large.jpg" alt=""></a></li></div>
  <div class="b"><li class="a"><a href="#"><img src="https://www.aws-s.com/assets/img/animals/navigation_carnivore.jpg" alt=""></a></li></div>
  <div class="b"><li class="a"><a href="#"><img src="https://www.tobuzoo.com/zoo/list/details/pc/0_an_73_02.jpg" alt=""></a></li></div>
  <div class="b"><li class="a"><a href="#"><img src="https://assets.media-platform.com/bi/dist/images/2020/09/11/5f5a5f37e6ff30001d4e8163.jpg" alt=""></a></li></div>
  <div class="b"><li class="a"><a href="#"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTsydtMv9W-0TqRJSgpVDyRT5Dr5z8ratc8BA&usqp=CAU" alt=""></a></li></div>
  <div class="b"><li class="a"><a href="#"><img src="https://www.city.chiba.jp/zoo/zone/images/s-0.jpeg" alt=""></a></li></div>

  </ul>
  <ul>
    <div class="b"><li class="a"><a href="#"><img src="https://i.gzn.jp/img/2018/01/15/google-gorilla-ban/00.jpg" alt=""></a></li></div>
    <div class="b"><li class="a"><a href="#"><img src="https://tk.ismcdn.jp/mwimgs/5/9/1140/img_59ee959e8de72d661bc73a524ac0f965202213.jpg" alt=""></a></li></div>
    <div class="b"><li class="a"><a href="#"><img src="https://storage.tenki.jp/storage/static-images/suppl/article/image/2/20/209/20941/1/large.jpg" alt=""></a></li></div>
    <div class="b"><li class="a"><a href="#"><img src="https://www.aws-s.com/assets/img/animals/navigation_carnivore.jpg" alt=""></a></li></div>
    <div class="b"><li class="a"><a href="#"><img src="https://www.tobuzoo.com/zoo/list/details/pc/0_an_73_02.jpg" alt=""></a></li></div>
    <div class="b"><li class="a"><a href="#"><img src="https://assets.media-platform.com/bi/dist/images/2020/09/11/5f5a5f37e6ff30001d4e8163.jpg" alt=""></a></li></div>
    <div class="b"><li class="a"><a href="#"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTsydtMv9W-0TqRJSgpVDyRT5Dr5z8ratc8BA&usqp=CAU" alt=""></a></li></div>
    <div class="b"><li class="a"><a href="#"><img src="https://www.city.chiba.jp/zoo/zone/images/s-0.jpeg" alt=""></a></li></div>

  </ul>
  
</div>



<!-- CSS -->
<style>

.loop_wrap {
  display: flex;
  width: 100vw;
  overflow: hidden;
}

.loop_wrap img {
  width: 300px;
  height: 100%;
}


.b{
    display: inline-block;
}



@keyframes loop {
  0% {
    transform: translateY(-100%);
  }
  to {
    transform: translateY(100%);
  }
}

@keyframes loop2 {
  0% {
    transform: translateY(-200%);
  }
  to {
    transform: translateY(0);
  }
}


.loop_wrap img:first-child {
  animation: loop 10s -5s linear infinite;
}

.loop_wrap img:last-child {
  animation: loop2 10s linear infinite;
}

</style>



</body>
</html>