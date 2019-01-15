<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>扫码领红包</title>
    
    <link rel="stylesheet" href="/Public/red_bag/get_now/common/css/common_mobile.css">
    <link rel="stylesheet" href="/Public/red_bag/get_now/zhijielingqu/css/index.css">
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
    <style type="text/css">
			*{
				padding: 0;
				margin: 0;
				font-family: "微软雅黑";
			}
			body{
				background: orangered;
			}
			.title{
				color: #fff;
				text-align: center;
				font-size: 20px;
				font-weight: 700;
				margin-top: 25px;
				}
			
			.pic{
				width: 100%;
			}
			.pic img{
				
				width: 90%;
				
				margin-left: 5%;
				margin-top: 30px;
			}
			.guize{
				color: #FFFFFF;
				width: 90%;
				margin-left: 5%;
				margin-top: 30px;
				line-height: 30px;
			}
			#mask{
				position: fixed;
			    left: 0;
			    top: 0;
			    z-index: 10;
			    width: 100%;
			    height: 100%;
			    background-color: rgba(0, 0, 0, 0.7);
			}
		</style>
</head>

<body>
	<div class="title">
			<?php echo (htmlspecialchars_decode($activity["title"])); ?>
		</div>

		<div class="pic">
			<img src="/Public/red_bag/get_now/common/image/banner.png" alt="" />
		</div>
		<div class="guize">
			<?php echo (htmlspecialchars_decode($activity["rule"])); ?>
		</div>
<div id="wrap">

    <!--中奖提示-->
    <div id="mask">
<!--    <div class="blin"></div>
        <div class="caidai"></div> -->
        <form action="/index.php/Home/Wechat"></form>
        <div class="winning reback">
            <div class="red-head"></div>
            <div class="red-body"></div>
            <div id="card" style="text-align: center; line-height: 30px;">
               
           <?php if($type==1||$type==2){ ?>
              <a href="javascript:viod(0);" class="winText">恭喜你获得</a>
              <a href="javascript:viod(0);" target="_self" class="win">
              	<img src="/Public/red_bag/get_now/common/image/redPack/559167105689558095.png" alt="">
              </a>
              <a href="javascript:viod(0);" target="_self" class="winMoney"><?php echo ($money); ?>12元</a>
           <?php }elseif($type==3||$type==4){ ?>
              <a href="javascript:viod(0);" class="winText">恭喜你获得</a>
              <a href="javascript:viod(0);" target="_self" class="win">
              	<img src="<?php echo ($money["ticket_picture"]); ?>" style="height: 70px;">
              </a>
              <a href="javascript:viod(0);" target="_self" class="winMoney"><?php echo ($money["name"]); ?></a> 
           <?php }else{ ?>
              <a href="javascript:viod(0);" class="winText" style="display: block;width:100%;height:160px;line-height: 160px; font-size:30px;">谢谢参与</a>
           <?php } ?> 
              <!-- <a href="" target="_self" class="win">asdas</a> -->
            </div>
            <input type="hidden" id="sn" name="sn" value="<?php echo ($sn); ?>">
            <input type="hidden" id="condition" value="<?php echo ($activity["condition"]); ?>">
            <a href="javascript:viod(0);" target="_self" class="btn get"></a>
            <!-- <span id="close"></span> -->
        </div>

    </div>
</div>

<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
<script src="/Public/red_bag/get_now/common/js/h5_game_common.js"></script>
<script src="/Public/red_bag/get_now/zhijielingqu/js/index.js"></script>
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
</html>