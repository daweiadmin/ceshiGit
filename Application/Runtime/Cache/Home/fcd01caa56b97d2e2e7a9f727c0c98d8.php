<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>九宫格抽奖</title>
   <link rel="stylesheet" href="/Public/red_bag/jiugong/common/css/swiper.min.css"> 
    <!-- <link rel="stylesheet" href="/Public/red_bag/jiugong/common/css/common_mobile.css?version=1.0.0"> -->
     <link rel="stylesheet" href="/Public/red_bag/jiugong/common/css/common_mobile.css">
    <link rel="stylesheet" href="/Public/red_bag/jiugong/ninegrid/css/index.css?version=1.0.0">
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
    <p class="time">3.10-3.25</p>
    <!--星星-->
    <div class="stars-box">
        <span class="stars"></span>
        <span class="stars"></span>
        <span class="stars"></span>
        <span class="stars"></span>
        <span class="stars"></span>
        <span class="stars"></span>
        <span class="stars"></span>
    </div>
    <!--主体-->
    <div class="main">
        <p class="rule"></p>
        <a href="/index.php/Home/index/index" id="myWin">
            <p class="my"></p>
        </a>
        <!--游戏区域-->
        <div class="box">
            <span class="coin"></span>
            <h2><!-- 您今日还有 <span id="change"> 3 </span> 次抽奖机会 -->
             <?php echo (htmlspecialchars_decode($activity["title"])); ?>
            </h2>
            <ul class="light clearfix">
                <li class="fl">
                    <p></p>
                    <p class="blin"></p>
                    <p></p>
                    <p class="blin"></p>
                </li>
                <li class="fr">
                    <p class="blin"></p>
                    <p></p>
                    <p class="blin"></p>
                    <p></p>
                </li>
            </ul>
            <!--九宫格-->
            <ul class="play clearfix">
              
                <li class="prize select">
                    <div>
                        
                      <?php if($box1[prize_type]==3){ ?>
                        <img src="/Public/red_bag/1.png" style="width: 70px; height: 35px; margin-top:10px;">
                      <?php }elseif($box1[prize_type]==4){ ?>
                        <img src="/Public/red_bag/2.png"  style="width: 70px; height: 35px; margin-top:10px;">
                      <?php  }else{ ?>
                        <img src="/Public/red_bag/jiugong/common/imageicon/box5.png">
                      <?php  } ?>
                        <p><?php echo (prize($box1["id"])); ?></p>
                    </div>
                </li>

                <li class="prize">
                    <div>
                      <?php if($box2[prize_type]==3){ ?>
                        <img src="/Public/red_bag/1.png" style="width: 70px; height: 35px; margin-top:10px;">
                      <?php }elseif($box2[prize_type]==4){ ?>
                        <img src="/Public/red_bag/2.png"  style="width: 70px; height: 35px; margin-top:10px;">
                      <?php  }else{ ?>
                        <img src="/Public/red_bag/jiugong/common/imageicon/box5.png">
                      <?php  } ?>
                        <p><?php echo (prize($box2["id"])); ?></p>
                    </div>
                </li>
                <li class="prize">
                     <div>
                      <?php if($box3[prize_type]==3){ ?>
                        <img src="/Public/red_bag/1.png" style="width: 70px; height: 35px; margin-top:10px;">
                      <?php }elseif($box3[prize_type]==4){ ?>
                        <img src="/Public/red_bag/2.png"  style="width: 70px; height: 35px; margin-top:10px;">
                      <?php  }else{ ?>
                        <img src="/Public/red_bag/jiugong/common/imageicon/box5.png">
                      <?php  } ?>
                        <p><?php echo (prize($box3["id"])); ?></p>
                    </div>
                </li>
                <li>
                    <div>
                        <?php if($box4[prize_type]==3){ ?>
                        <img src="/Public/red_bag/1.png" style="width: 70px; height: 35px; margin-top:10px;">
                      <?php }elseif($box4[prize_type]==4){ ?>
                        <img src="/Public/red_bag/2.png"  style="width: 70px; height: 35px; margin-top:10px;">
                      <?php  }else{ ?>
                        <img src="/Public/red_bag/jiugong/common/imageicon/box5.png">
                      <?php  } ?>
                        <p><?php echo (prize($box4["id"])); ?></p>
                    </div>
                </li>
                <!--开始按钮-->
                <li id="btn"></li>
                <!--开始按钮-->
                <li class="prize">
                    <div>
                        <?php if($box5[prize_type]==3){ ?>
                        <img src="/Public/red_bag/1.png" style="width: 70px; height: 35px; margin-top:10px;">
                      <?php }elseif($box5[prize_type]==4){ ?>
                        <img src="/Public/red_bag/2.png"  style="width: 70px; height: 35px; margin-top:10px;">
                      <?php  }else{ ?>
                        <img src="/Public/red_bag/jiugong/common/imageicon/box5.png">
                      <?php  } ?>
                        <p><?php echo (prize($box5["id"])); ?></p>
                    </div>
                </li>
                <li class="prize">
                    <div>
                        <?php if($box6[prize_type]==3){ ?>
                        <img src="/Public/red_bag/1.png" style="width: 70px; height: 35px; margin-top:10px;">
                      <?php }elseif($box6[prize_type]==4){ ?>
                        <img src="/Public/red_bag/2.png"  style="width: 70px; height: 35px; margin-top:10px;">
                      <?php  }else{ ?>
                        <img src="/Public/red_bag/jiugong/common/imageicon/box5.png">
                      <?php  } ?>
                        <p><?php echo (prize($box6["id"])); ?></p>
                    </div>
                </li>
                <li>
                    <div>
                       <?php if($box7[prize_type]==3){ ?>
                        <img src="/Public/red_bag/1.png" style="width: 70px; height: 35px; margin-top:10px;">
                      <?php }elseif($box7[prize_type]==4){ ?>
                        <img src="/Public/red_bag/2.png"  style="width: 70px; height: 35px; margin-top:10px;">
                      <?php  }else{ ?>
                        <img src="/Public/red_bag/jiugong/common/imageicon/box5.png">
                      <?php  } ?>
                        <p><?php echo (prize($box7["id"])); ?></p>
                    </div>
                </li>
                <li class="prize">
                    <div>
                        <img src="/Public/red_bag/jiugong/common/imageicon/box0.png">
                        <p>谢谢参与</p>
                    </div>
                </li>
            </ul>
        </div>
        <input type="hidden" id="de_prize" value="<?php echo ($de_prize); ?>">
        <!--奖品展示-->
       <div class="awards" style=" font-size:16px; color: white;" >
             <?php echo (htmlspecialchars_decode($activity["rule"])); ?> 
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
               <!--  <a href="" target="_self" class="win"></a> -->
            </div>
            <input type="hidden" id="sn" name="sn" value="<?php echo ($sn); ?>">
            <input type="hidden" id="condition" value="<?php echo ($activity["condition"]); ?>">
            <a href="javascript:viod(0);" target="_self" class="btn get"></a>
            <span id="close"></span>
        </div>
    </div>
</div>

<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
<script src="/Public/red_bag/jiugong/common/js/swiper.jquery.min.js"></script>
<script src="/Public/red_bag/jiugong/common/js/h5_game_common.js?version=1.0.0"></script>
<script src="/Public/red_bag/jiugong/ninegrid/js/index.js?version=1.0.0"></script>
<script type="text/javascript"  src="/Public/media/js/jquery-1.10.2.min.js"></script>
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
          $('.get').attr('disabled',true);
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