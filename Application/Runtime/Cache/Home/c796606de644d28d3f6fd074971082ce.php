<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
		<link rel="stylesheet" type="text/css" href="/Public/red_bag/share/css/style.css"/>
		<title>温馨提示</title>
	</head>
	<body>
		<div class="nav1">
			 <?php if($shopdata[logo] != ''): ?><img src="<?php echo ($shopdata["logo"]); ?>" alt="" style="width: 50px; height: 50px;" />
		       <?php else: ?>
		       <img src="/Public/red_bag/share/image/head.png" alt="" style="width: 50px; height: 50px;"/><?php endif; ?>
			<p><?php echo ($shopdata["name"]); ?></p>
		</div>
	       <a href="/index.php/Home/index/index">
			<div class="mine">
				<img src="/Public/red_bag/share/image/mine.png" alt="" />
				<p>我的</p>
			</div>
	       </a>
		<div class="banner">
			<div class="con">
				<!-- <img src="/Public/red_bag/share/image/chenggong.png" alt="" /> -->
				<p style="">温馨提示</p>
			</div>
			 <div class="inf">
            <p><?php echo ($error); ?></p>
            <p></p>
         </div> 

			      <!--  <?php if($error == 10001): ?><div class="con">
         				<span>对不起！</span>
         			</div>
         			<div class="inf">
         				<p>二维码已失效</p>
         			</div><?php endif; ?>
         <?php if($error == 10002): ?><div class="con">
         				<span>活动状态错误！</span>
         			</div>
         			<div class="inf">
         				<p>活动未开启或者已经关闭或未审核</p>
         			</div><?php endif; ?>
         <?php if($error == 10003): ?><div class="con">
         				
         				<span>对不起！</span>
         			</div>
         			<div class="inf">
         				<p>您已经参加过活动，不能再参加了哦</p>
         			</div><?php endif; ?>
         <?php if($error == 10004): ?><div class="con">
         				
         				<span>对不起！</span>
         			</div>
         			<div class="inf">
         				<p>您今天得参与次数已达到上限，明天再来参与把</p>
         			</div><?php endif; ?>
          <?php if($error == share_success): ?><div class="con">
         				<img src="/Public/red_bag/share/image/chenggong.png" alt="" />
         				<span>分享成功！</span>
         			</div>
         			<div class="inf">
         				<p>奖励已发出哦</p>
         			</div><?php endif; ?> -->
		</div>
		<div class="eq">
			<p>长按识别二维码进入个人中心</p>
			<p>可查看记录和使用卡券</p>
			<img src="/Public/red_bag/lckj.jpg" alt="" />
		</div>
	</body>
</html>