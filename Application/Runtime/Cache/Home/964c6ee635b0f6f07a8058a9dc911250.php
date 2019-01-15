<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>转盘</title>
    <!-- <link rel="stylesheet" href="/Public/red_bag/zhuanpan/common/css/common_mobile.css"> -->
    <link rel="stylesheet" href="/Public/red_bag/jiugong/common/css/common_mobile.css">
    <link rel="stylesheet" href="/Public/red_bag/zhuanpan/zhuanpan/css/index.css">
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
    <div class="caidai"></div>
    <div class="header clearfix">
        <p class="rule fl">规则</p>
        <a href="/index.php/Home/index/index" id="myWin">
            <p class="my fr">我的奖品</p>
        </a>
        <div class="title"></div>
    </div>
    <!--轮盘-->
    <div class="rotate">
        <div class="lunpai">
            <ul class="prize running">
                <li>
                    <img src="/Public/red_bag/zhuanpan/zhuanpan/image/face.png" alt="" width="40px" height="40px">
                    <span></span>
                    <p>谢谢参与</p>
                </li>
                
                 
                 <li>
                    <?php if($box5[prize_type]==3){ ?>
                       <img src="/Public/red_bag/1.png" style="width: 50px; height: 30px;">
                     <?php }elseif($box5[prize_type]==4){ ?>
                       <img src="/Public/red_bag/2.png"  style="width: 50px; height: 30px;">
                     <?php  }else{ ?>
                       <img src="/Public/red_bag/zhuanpan/zhuanpan/image/red.png" alt="" width="40px" height="50px">
                     <?php  } ?> 
                     <span></span>
                    <p><?php echo (prize($box5["id"])); ?></p>  
                </li>
                <li>
                    <?php if($box4[prize_type]==3){ ?>
                       <img src="/Public/red_bag/1.png" style="width: 50px; height: 30px;">
                     <?php }elseif($box4[prize_type]==4){ ?>
                       <img src="/Public/red_bag/2.png"  style="width: 50px; height: 30px;">
                     <?php  }else{ ?>
                        <img src="/Public/red_bag/zhuanpan/zhuanpan/image/red.png" alt="" width="40px" height="50px">
                     <?php  } ?> 
                     <span></span>
                    <p><?php echo (prize($box4["id"])); ?></p>  
                </li>
                <li>
                    <?php if($box3[prize_type]==3){ ?>
                       <img src="/Public/red_bag/1.png" style="width: 50px; height: 30px;">
                     <?php }elseif($box3[prize_type]==4){ ?>
                       <img src="/Public/red_bag/2.png"  style="width: 50px; height: 30px;">
                     <?php  }else{ ?>
                       <img src="/Public/red_bag/zhuanpan/zhuanpan/image/red.png" alt="" width="40px" height="50px">
                     <?php  } ?> 
                     <span></span>
                    <p><?php echo (prize($box3["id"])); ?></p>  
                </li>
                 <li>
                    <?php if($box2[prize_type]==3){ ?>
                       <img src="/Public/red_bag/1.png" style="width: 50px; height: 30px;">
                     <?php }elseif($box2[prize_type]==4){ ?>
                       <img src="/Public/red_bag/2.png"  style="width: 50px; height: 30px;">
                     <?php  }else{ ?>
                      <img src="/Public/red_bag/zhuanpan/zhuanpan/image/red.png" alt="" width="40px" height="50px">
                     <?php  } ?> 
                     <span></span>
                    <p><?php echo (prize($box2["id"])); ?></p>  
                </li>
                <li>
                    <?php if($box1[prize_type]==3){ ?>
                       <img src="/Public/red_bag/1.png" style="width: 50px; height: 30px;">
                     <?php }elseif($box1[prize_type]==4){ ?>
                       <img src="/Public/red_bag/2.png"  style="width: 50px; height: 30px;">
                     <?php  }else{ ?>
                      <img src="/Public/red_bag/zhuanpan/zhuanpan/image/red.png" alt="" width="40px" height="50px">
                     <?php  } ?> 
                     <span></span>
                    <p><?php echo (prize($box1["id"])); ?></p>  
                </li>
              
            </ul>
        </div>
        <div class="ring"></div>
        <div id="btn"></div>
    </div>
    <div class="border">
        快来抽奖吧
    </div>
    <!--滚动信息-->
    <div class="scroll">
        <p></p>
        <div>
            <ul>
                <li>
                    恭喜<span class="start-num">134</span>****<span class="end-num">0481</span>
                    获得<span class="info">随机红包</span>一份
                </li>
                <li>
                    恭喜<span class="start-num">132</span>****<span class="end-num">3145</span>
                    获得<span class="info">现金红包</span>一份
                </li>
                <li>
                    恭喜<span class="start-num">150</span>****<span class="end-num">0150</span>
                    获得<span class="info">兑换券</span>一份
                </li>
                 <li>
                    恭喜<span class="start-num">150</span>****<span class="end-num">0150</span>
                    获得<span class="info">优惠券</span>一份
                </li>
            </ul>
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
              
                <?php }elseif($type==3||$type==4){ ?>
                <a href="javascript:viod(0);" class="winText">恭喜你获得</a>
                   <a href="javascript:viod(0);" target="_self" class="win">
                     <img src="<?php echo ($money["ticket_picture"]); ?>" style="height: 70px;">
                   </a>
                   <a href="javascript:viod(0);" target="_self" class="winMoney"><?php echo ($money["name"]); ?></a> 
                <?php }else{ ?> 
                  <a href="javascript:viod(0);" class="winText" style="display: block;width:100%;height:160px;line-height: 160px; font-size:30px;">谢谢参与</a>
                <?php } ?> 
            </div>
            <input type="hidden" id="sn" name="sn" value="<?php echo ($sn); ?>">
            <input type="hidden" id="condition" value="<?php echo ($activity["condition"]); ?>">
            <a href="javascript:viod(0);" target="_self" class="btn get"></a>
            <span id="close"></span>
        </div>
    </div>
</div>
<input type="hidden" id="de_prize" value="6">
<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
<script src="/Public/red_bag/zhuanpan/common/js/jquery.rotate.js"></script>
<script src="/Public/red_bag/zhuanpan/common/js/h5_game_common.js"></script>
<script src="/Public/red_bag/zhuanpan/zhuanpan/js/index.js"></script>
<!-- <script type="text/javascript"  src="/Public/media/js/jquery-1.10.2.min.js"></script> -->
<script type="text/javascript" src="/Public/media/js/layer/dialog.js"></script> 
<script type="text/javascript" src="/Public/media/js/layer/layer.js"></script> 
</body>
<script> 
  $('.get').click(function(){
      var sn = $('#sn').val();
      //alert(sn);
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
                  alert(res.message);
                 }

           },'JSON');
        }

      if(con==2){
        window.location.href='/index.php/Home/Wechat/share?sn='+sn;
      }
      
  });

</script>
</html>