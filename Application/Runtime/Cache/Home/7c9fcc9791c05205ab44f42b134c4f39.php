<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
		<link href="/Public/red_bag/css/style.css" rel="stylesheet" type="text/css"/>
		<title>奖券详情</title>
		<style>
			*{
				padding: 0;
				margin: 0;
				font-family: "微软雅黑";
				
			}
			.title{
				color: #FF4500;
				font-weight: 700;
				font-size: 20px;
				padding: 20px 15px;
				border-bottom: 1px solid #f1f1f1;
			}
			.inf{
				margin: 15px;
				font-size: 20px;
				line-height: 30px;
				border-bottom: 1px solid #f1f1f1;
				padding-bottom: 15px;
			}
			.inf span{
				color: #666;
				font-size: 18px;
			}
			.hexiaoma{
				text-align: center;
				margin-top: 25px;
			}
			.hexiaoma p{
				font-size: 20px;
				font-weight: 700;
			}
		</style>
	</head>
	<body>
		<header class="aui-navBar aui-navBar-fixed">
                <a href="javascript:;" class="aui-navBar-item">
                    <i class="icon icon-return"></i>
                </a>
                <div class="aui-center">
                    <span class="aui-center-title">领券详情</span>
                </div>
        </header>
		<div class="xiangqing">
			<div class="title">奖券详情</div>
			<div class="inf">
				<p>一元奖品<?php echo ($ticket["name"]); ?></p>
				<span>使用期限：请于<?php echo (date("y-m-d",$ticket["time"])); ?>之前使用
				<br>描述：<?php echo ($ticket["content"]); ?>
				<br>活动名称：<?php echo ($member_ticket["activity_id"]); ?>
				<br>商户名称：<?php echo (activity_shopname($member_ticket["activity_id"])); ?>
				<br>
				</span>
			</div>
			<div class="inf">
				<p>适用门店</p>
				<span>某某某餐厅<br>地址：金大街66号</span>
			</div>
		</div>
		<div class="hexiaoma">
			<p>核销码：请向商户出示</p>
			<img src="<?php echo ($member_ticket["hexiao_code"]); ?>" alt="" />
		</div>
	</body>
</html>