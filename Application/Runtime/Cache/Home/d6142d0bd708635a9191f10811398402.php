<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>砸金蛋</title>
    <link rel="stylesheet" href="/Public/red_bag/jiugong/common/css/common_mobile.css">
    <link rel="stylesheet" href="/Public/red_bag/jindan/goldeggs/css/index.css">
    <!-- 移动端适配-->
    <script>
        var html = document.querySelector('html');
        changeRem();
        window.addEventListener('resize', changeRem);

        function changeRem() {
            var width = html.getBoundingClientRect().width;
            //console.log( width );
            html.style.fontSize = width / 10 + 'px';
        }
    </script>
</head>

<body>
<div id="wrap">
    <div class="bg"></div>
    <div class="rule"></div>
  <a href="/index.php/Home/index/index" id="myWin">
       <div class="my">我的奖品</div>
   </a> 
    <!--砸蛋区域-->
    <div class="box">
       <!--  <p class="tips">今天剩余免费<span id="change">5</span>次</p> -->
        <p class="tips"><?php echo (htmlspecialchars_decode($activity["rule"])); ?></p>
        <ul class="egg clearfix">
            <li>
                <img src="/Public/red_bag/jindan/goldeggs/image/egg.png" class="goldegg init">
                <img src="/Public/red_bag/jindan/goldeggs/image/base.png">
                <div class="info"></div>
            </li>
            <li>
                <img src="/Public/red_bag/jindan/goldeggs/image/egg.png" class="goldegg init">
                <img src="/Public/red_bag/jindan/goldeggs/image/base.png">
                <div class="info"></div>
            </li>
            <li>
                <img src="/Public/red_bag/jindan/goldeggs/image/egg.png" class="goldegg init">
                <img src="/Public/red_bag/jindan/goldeggs/image/base.png">
                <div class="info"></div>
            </li>
            <li>
                <img src="/Public/red_bag/jindan/goldeggs/image/egg.png" class="goldegg init">
                <img src="/Public/red_bag/jindan/goldeggs/image/base.png">
                <div class="info"></div>
            </li>
            <li>
                <img src="/Public/red_bag/jindan/goldeggs/image/egg.png" class="goldegg init">
                <img src="/Public/red_bag/jindan/goldeggs/image/base.png">
                <div class="info"></div>
            </li>
            <li>
                <img src="/Public/red_bag/jindan/goldeggs/image/egg.png" class="goldegg init">
                <img src="/Public/red_bag/jindan/goldeggs/image/base.png">
                <div class="info"></div>
            </li>
            <li>
                <img src="/Public/red_bag/jindan/goldeggs/image/egg.png" class="goldegg init">
                <img src="/Public/red_bag/jindan/goldeggs/image/base.png">
                <div class="info"></div>
            </li>
            <li>
                <img src="/Public/red_bag/jindan/goldeggs/image/egg.png" class="goldegg init">
                <img src="/Public/red_bag/jindan/goldeggs/image/base.png">
                <div class="info"></div>
            </li>
            <li>
                <img src="/Public/red_bag/jindan/goldeggs/image/egg.png" class="goldegg init">
                <img src="/Public/red_bag/jindan/goldeggs/image/base.png">
                <div class="info"></div>
            </li>
        </ul>
        <div id="hammer" class="shak"></div>
    </div>
    <!--游戏规则弹窗-->
    <div id="mask-rule">
        <div class="box-rule">
            <span class="star"></span>
            <h2>活动规则说明</h2>
            <span id="close-rule"></span>
            <div class="con">
                <div class="text">
                    <?php echo (htmlspecialchars_decode($activity["rule"])); ?>
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
            <div id="card" style="text-align: center; line-height: 30px;">
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
               <!--  <a href="" target="_self" class="win"></a> -->
            </div>
            <input type="hidden" id="sn" name="sn" value="<?php echo ($sn); ?>">
            <input type="hidden" id="condition" value="<?php echo ($activity["condition"]); ?>">
            <a href="javascript:viod(0);" target="_self" class="btn get"></a>
            <span id="close"></span>
        </div>
    </div>
</div>
<script type="text/javascript"  src="/Public/media/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="/Public/media/js/layer/dialog.js"></script> 
<script type="text/javascript" src="/Public/media/js/layer/layer.js"></script> 
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
<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
<script src="/Public/red_bag/jindan/common/js/jquery.cookie.js"></script>
<script src="/Public/red_bag/jindan/common/js/h5_game_common.js"></script>
<script src="/Public/red_bag/jindan/goldeggs/js/index.js"></script>
<!--<script>

    var data = "";

    //执行第一次
    clickData(true);

    //请求回调，并且在ji中执行此代码，请加入防止连点措施
    function clickData(bool) {
        $.ajaxSettings.async = false;
        if (bool) 
            });
        } else {
            $.getJSON(basePath + "api/browse/browseAeI?appKey=" + queryString("appKey") + "&pId=" + queryString("pId") + "&caId=" + queryString("caId") + "&index=0&isFirst=0", "", function (datac) {
                if (null !== datac && "" !== datac) {
                    data = datac;

                    //设定中奖的图片
                    $(".win").css("background-image", "url(" + data.adImgUrl + ")");

                    //设定中奖次数
                    $("#change").html(data.count);

                    //设定中奖的跳转链接
                    $winning.find("a").attr("href", data.adUrl + "?appKey=" + queryString("appKey") + "&pId=" + queryString("pId") + "&caId=" + queryString("caId") + "&adId=" + data.adId + "&index=0");
                }
            });
        }
    }
</script>-->
</body>
</html>