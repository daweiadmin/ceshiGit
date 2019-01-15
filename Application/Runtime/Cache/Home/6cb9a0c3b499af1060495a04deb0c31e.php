<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport"/>
		<link href="/Public/red_bag/css/style.css" rel="stylesheet" type="text/css"/>
		<title>领奖记录</title>
		<style type="text/css">
			*{
				padding: 0;
				margin: 0;
				font-family: "微软雅黑";
			}
			body{
				background: #f8f8f8;
			}
			.jilu{
				background: #fff;
				margin: 10px 10px;
				border: 1px solid #f1f1f1;
				overflow: hidden;
			}
			.jilu p{
				width: 70%;
				float: left;
				padding: 5px;
				margin-top: 5px;
			}
			.zhuangtai{
				float: right;
				background: orangered;
				color: #fff;
				padding: 5px 10px;
				border-radius: 3px;
				margin-top: 5px;
				margin-right: 4px;
			}
			.time{
				clear: both;
				margin-top: 45px;
				margin-left: 5px;
			}
			.jine{
				float: right;
				margin-right: 10px;
				font-size: 16px;
				color: red;
				margin-bottom: 10px;
			}
		</style>
	</head>
	<body>
		<header class="aui-navBar aui-navBar-fixed">
                <a href="javascript:;" class="aui-navBar-item">
                    <i class="icon icon-return"></i>
                </a>
                <div class="aui-center">
                    <span class="aui-center-title">领取纪录</span>
                </div>
        </header>
        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="jilu">
			<p><?php echo (activity_name($vo["activity_id"])); ?></p>
			<div class="zhuangtai">
				领取成功
			</div>
			<div class="time">
				<?php echo (date("y-m-d",$vo["time"])); ?>
			</div>
			<div class="jine">
				<?php echo (prize_value($vo["id"])); ?>元
			</div>
		</div><?php endforeach; endif; else: echo "" ;endif; ?>
	</body>
</html>