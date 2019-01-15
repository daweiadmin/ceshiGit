<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport"/>
    <title>个人中心</title>
    <style type="text/css">
      *{
        padding: 0;
        margin: 0;
        font-family: "微软雅黑";
      }
      body{
        background: #f8f8f8;
      }
      .head{
        width: 100%;
        height: 200px;
        background-image: url(/Public/red_bag/image/bg.jpg);
        background-size: 100% 100%;
        text-align: center;
      }
      .head img{
        width: 80px;
        height: 80px;
        margin-top: 40px;
      }
      .head p{
        margin-top: 10px;
        color: #Fff;
        font-weight: 700;
        font-size: 18px;
      }
      .member{
        width: 96%;
          padding: 0 2%;
          height: auto;
          overflow: hidden;
          background: #fff;
          margin-top: 10px;
      }
      ul,li{
        list-style: none;
      }
      .member li{
        width: 100%;
          height: 70px;
          line-height: 70px;
          border-bottom: 1px solid #ddd;
          background: url(/Public/red_bag/image/more.png) no-repeat 97% center;
      }
      .member li img{
          width: 30px;
          float: left;
          height: 30px;
          margin: 22px 9px 0 5px;
      }
      a{
        text-decoration:none; 
        color:#333;
      }
    </style>
  </head>
  <body>
    <div class="head">
      <img src="<?php echo ($member["wx_pic"]); ?>" alt="" width="80" height="80" />
      <p><?php echo ($member["wx_name"]); ?></p>
    </div>
    <ul class="member">
      <a href="/index.php/Home/Index/note"><li><img src="/Public/red_bag/image/1.png" alt="" />我的领奖记录</li></a>
      <a href="/index.php/Home/Index/ticket?type=1"><li><img src="/Public/red_bag/image/2.png" alt="" />我的兑换券</li></a>
      <a href="/index.php/Home/Index/ticket?type=2"><li><img src="/Public/red_bag/image/3.png" alt="" />我的优惠券</li></a>
    </ul>
  </body>
</html>