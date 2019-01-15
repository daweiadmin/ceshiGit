<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>刮刮乐</title>
    <link rel="stylesheet" href="/Public/red_bag/guagua/common/css/swiper.min.css">
    <link rel="stylesheet" href="/Public/red_bag/guagua/common/css/common_mobile.css">
    <link rel="stylesheet" href="/Public/red_bag/guagua/guaguale/css/index.css">
    <!-- 移动端适配 -->
    <script>
        var html = document.querySelector('html');
        changeRem();
        window.addEventListener('resize', changeRem);

        function changeRem() {
            var width = html.getBoundingClientRect().width;
            html.style.fontSize = width / 10 + 'px';
        }
    </script>
</head>

<body>
<div id="wrap">
    <div class="caidai1"></div>
    <div class="caidai2"></div>
    <div class="caidai3"></div>
    <!--游玩区域-->
    <div class="box">
        <p class="rule">活动规则</p>
        <a href="../my.html" id="myWin">
            <p class="my">我的奖品</p>
        </a>
        <div class="panel">
            <canvas id="canvas" width="562" height="308"></canvas>
            <div id="canvas-mask">
                <a id="btn" href="javascript:;"></a>
                <p><?php echo (htmlspecialchars_decode($activity["title"])); ?></p>
            </div>
        </div>
        <!--奖品展示。-->
        <div class="awards">
            <div class="swiper-container">
                <ul class="swiper-wrapper">
                    <li class="swiper-slide">
                        <img src="/Public/red_bag/guagua/common/imageicon/drag1.png">
                    </li>
                    <li class="swiper-slide">
                        <img src="/Public/red_bag/guagua/common/imageicon/drag2.png">
                    </li>
                    <li class="swiper-slide">
                        <img src="/Public/red_bag/guagua/common/imageicon/drag3.png">
                    </li>
                    <li class="swiper-slide">
                        <img src="/Public/red_bag/guagua/common/imageicon/drag4.png">
                    </li>
                    <li class="swiper-slide">
                        <img src="/Public/red_bag/guagua/common/imageicon/drag5.png">
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!--游戏规则弹窗-->
    <div id="mask-rule">
        <div class="box-rule">
            <span class="star"></span>
            <h2>活动规则说明</h2>
            <span id="close-rule"></span>
            <div class="con">
                <div class="text">
                    <?php echo (htmlspecialchars_decode($activity["instruction"])); ?>
                </div>
            </div>
        </div>
    </div>
    <!--中奖提示-->
    <div id="mask">
        <div class="blin"></div>
        <div class="caidai"></div>
        <div class="winning">
            <div class="red-head"></div>
            <div class="red-body"></div>
            <div id="card">
               <!--  <a href="" target="_self" class="win"></a> -->

               <?php if($type==1||$type==2){ ?>
                  <a href="javascript:viod(0);" class="winText">恭喜你获得</a>
                   <a href="javascript:viod(0);" target="_self" class="win">
                     <img src="/Public/red_bag/get_now/common/image/redPack/559167105689558095.png" alt="">
                   </a>
                   <a href="javascript:viod(0);" target="_self" class="winMoney"><?php echo ($money); ?>元</a>
              
                <?php }else{ ?>
                <a href="javascript:viod(0);" class="winText">恭喜你获得</a>
                   <a href="javascript:viod(0);" target="_self" class="win">
                     <img src="/Public/red_bag/1.png" style="height: 70px;">
                   </a>
                   <a href="javascript:viod(0);" target="_self" class="winMoney">兑换券</a> 
                <?php } ?> 
            </div>
            <a href="" target="_self" class="btn"></a>
            <span id="close"></span>
        </div>
    </div>
</div>

<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
<script src="/Public/red_bag/guagua/common/js/swiper.jquery.min.js"></script>
<script src="/Public/red_bag/guagua/common/js/h5_game_common.js"></script>
<script src="/Public/red_bag/guagua/guaguale/js/index.js"></script>
<script type="text/javascript" src="/Public/media/js/layer/dialog.js"></script> 
<script type="text/javascript" src="/Public/media/js/layer/layer.js"></script> 
</body>
<script> 
  $('.get').click(function(){
      var sn = $('#sn').val();
     // alert(sn);
      var con = $('#condition').val();
     // alert(con);
      if(con==1){  //直接领取
          var url = '/index.php/Home/Wechat/get_money';
          var data = {'sn':sn}
          $.post(url,data,function(res){
            //alert(res.status);
              if (res.status == 1) {
                    var jump_url = '/index.php/Home/Wechat/tishi?record='+res.datas;
                   // alert(jump_url);
                    window.location.href=jump_url;
                  } 
               if(res.status == 0){
                  dialog.error(res.message);
                 }

           },'JSON');
        }

      if(con==2){
        window.location.href='/index.php/Home/Wechat/share?sn='+sn;
      }
      
  });

</script>
</body>
</html>