<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
		<link rel="stylesheet" type="text/css" href="/Public/red_bag/share/css/style.css"/>
		<title>分享</title>
	</head>

	<body>
		<div class="nav">
			<img src="/Public/red_bag/share/image/head.png" alt="" />
			<p><?php echo ($shopdata["name"]); ?></p>
		</div>
		<div class="chanpin">
			<p>点击右上角：分享到朋友圈</p>
			<p>分享成功领红包</p>
			<div class="chanpin-infor">
				<img src="<?php echo ($sharedata["share_picture"]); ?>" alt="" />
				<span><?php echo ($sharedata["share_title"]); ?></span>
			</div>
		</div>
		<div class="mess">
			<div class="xian"></div>
			<h3>任务说明</h3>
			<div class="xian"></div>
		</div>
		<div class="shuoming">
		    <p>1、分享朋友圈成功即可获得奖品<br>2、进入领奖成功页面<br>3、长按识别二维码进入公众号，可查看消息记录</p>
		</div>
    <input type="hidden" id="sn" value="<?php echo ($sn); ?>">
		<div class="zhezhao">
			<img src="/Public/red_bag/share/image/share.png" alt="" />
			<p>1、点击右上方的按钮<br>2、选择分享到朋友圈即可领取</p>
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
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'onMenuShareQQ',
            'onMenuShareWeibo',
            //'chooseImage',
            //'previewImage',
            //'uploadImage'
          ]
        });
        var title = "领程科技";
        var desc = "领程科技邀你一起抢红包";
        var link  = 'http://redbag.lingcheng888.com/index.php/home/wechat/share_jump?share_id=<?php echo ($sharedata["id"]); ?>';
        var img  = "<?php echo $sharedata['share_picture'] ?>";
        //var url=window.location.href;
       // alert(link);
         //alert(link);
      wx.ready(function (){    
        wx.onMenuShareTimeline({
          title: title,   // 分享标题
          link: link,   // 分享链接
          imgUrl: img,  // 分享图标
          success: function () {
             var sn = $('#sn').val();
             var url = '/index.php/Home/Wechat/share_success';
             var jump_url = "/index.php/Home/Wechat/tishi?error_code='share_suc'";
             var data = {'sn':sn};
             $.post(url,data,function(result){
              if(result.status==1){
                    window.location.href=jump_url;
                }
                if(result.status==0){
                    dialog.error(result.message);
                }

             },'JSON');
            
          },
          cancel: function () {
            // 用户取消分享后执行的回调函数
          }
        });

        wx.onMenuShareAppMessage({
          title: title,   // 分享标题
          desc: desc,   // 分享描述
          link: link,   // 分享链接
          imgUrl: img,  // 分享图标
          type: 'type',   // 分享类型,music、video或link，不填默认为link
          dataUrl: '',  // 如果type是music或video，则要提供数据链接，默认为空
          success: function () {
             
          },
          cancel: function () {
            // 用户取消分享后执行的回调函数
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