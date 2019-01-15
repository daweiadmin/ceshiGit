<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
		<link rel="stylesheet" type="text/css" href="/Public/red_bag/share/css/style.css"/>
		<title>获取地理位置</title>
	</head>

	<body>
		<div class="nav">
			<img src="/Public/red_bag/share/image/head.png" alt="" />
			<p><?php echo ($shopdata["name"]); ?></p>
		</div>
		<div class="chanpin">
			<p>获取地理位置</p>
			<p>扫码领红包</p>
		</div>
				 <input type="hidden" id="canshu" name="" value="<?php echo ($put_r_id); ?>">
		<script type="text/javascript" src="/Public/youji/js/TouchSlide.1.1.js"></script>
		<script src="http://libs.baidu.com/jquery/1.2.3/jquery.min.js"></script>
		<script src="http://res2.wx.qq.com/open/js/jweixin-1.4.0.js"></script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
    <script>
        wx.config({
          debug: false,
          appId: '<?php echo $signPackage["appId"]; ?>',
          timestamp: '<?php echo $signPackage["timestamp"]; ?>',
          nonceStr: '<?php echo $signPackage["nonceStr"]; ?>',
          signature: '<?php echo $signPackage["signature"]; ?>',
          jsApiList: [
            'getLocation',
            //'chooseImage',
            //'previewImage',
            //'uploadImage'
          ]
        });
      
      wx.ready(function (){  
       wx.getLocation({
          type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
          success: function (res) {
          var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
          var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
          var speed = res.speed; // 速度，以米/每秒计
          var accuracy = res.accuracy; // 位置精度
         }
        });  
      
      });
    </script>
 <!--  <script type="text/javascript">
   /*jQuery(".ibanner").slide({*/
   TouchSlide({ 
     slideCell:"#slideBox",
     titCell:".hd ul",
     mainCell: ".bd ul",
     autoPlay: true,
     autoPage: true,
     effect: "leftLoop",
     delayTime: 400,
     interTime: 3000,//间隔时间
     triggerTime: 150
   });
   /*微信分享sdk*/
   $(document).ready(function(){
       initPage();
   });
   function initPage() {
       //alert(window.location.href);/***用于获得当前连接url用**/
       /***用户点击分享到微信圈后加载接口接口*******/
       
       var url = 'http://redbag.lingcheng888.com/index.php/home/wechat/wx_share';
      // alert(url);
       var jump_url = 'http://redbag.lingcheng888.com';
       var imgUrl = '';
       var content = '领程科技';
       var title='领程科技';
       $.post(url,{"url":window.location.href},function(data,status){
           data=eval("("+data+")");
          
           wx.config({
               debug: true,
               appId: data.appid,
               timestamp:data.timestamp,
               nonceStr:data.nonceStr,
               signature:data.signature,
               jsApiList: [
                   'checkJsApi',
                   'onMenuShareAppMessage',
                   'onMenuShareTimeline',
               ]
           });
           var shareTitle = "一起分享吧！";
           var shareImg = '/Public/Uploads/2018-05-08/5af162033af96.png';
           wx.ready(function(){
                //分享朋友
           wx.onMenuShareAppMessage({
             title: title, // 分享标题
             desc: content, // 分享描述
             link: jump_url, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
             imgUrl: imgUrl, // 分享图标
             type: '', // 分享类型,music、video或link，不填默认为link
             dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
             success: function () {
             // 用户点击了分享后执行的回调函数
             }
             });
              /*分享到朋友圈*/
             wx.onMenuShareTimeline({
                 title: title, // 分享标题
                 link: jump_url, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                 imgUrl:imgUrl, // 分享图标
                 success: function () {
                 // 用户点击了分享后执行的回调函数
             },
         
           });
           
          /*  //分享朋友
           wx.updateAppMessageShareData({
             title: title, // 分享标题
             desc: content, // 分享描述
             link: jump_url, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
             imgUrl: imgUrl, // 分享图标
             type: '', // 分享类型,music、video或link，不填默认为link
             dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
             success: function () {
              alert('success');
             }
             });
              //*分享到朋友圈
             wx.updateTimelineShareData({
                 title: title, // 分享标题
                 link: jump_url, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                 imgUrl:imgUrl, // 分享图标
                 success: function () {
                 // 用户点击了分享后执行的回调函数
             },
         
           });*/
       });
     });
   }
 </script> -->
	</body>
</html>