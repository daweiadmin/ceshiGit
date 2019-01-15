<?php 
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
require_once "../lib/WxPay.Api.php";
require_once "WxPay.JsApiPay.php";
require_once 'log.php';
require_once 'mysql.php';
header("content-type:text/html;charset:utf-8");
/*逻辑代码*/
$indent_id = trim($_GET['intid']) ? trim($_GET['intid']) : '';
$mysql = new MySQL('localhost','ceshijingyingcn','eCADuyArxE','ceshijingyingcn');
$sql = "select * from de_indent where id=$indent_id";
$indent = $mysql->query($sql);
//print_r($indent);exit;
$tem = $indent[0]['temp_id'];

$mysql = new MySQL('localhost','ceshijingyingcn','eCADuyArxE','ceshijingyingcn');
$sql = "select * from de_temple where id=$tem";
$temple = $mysql->query($sql);

//初始化日志
$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

if($indent[0]['type']==1){
  $type_data = '随喜';
}
if($indent[0]['type']==2){
  $type_data = '供灯';
}
if($indent[0]['type']==3){
  $type_data = '供牌';
}
 $money = $indent[0]['money'];
 $Body = '随身功德宝-'.$temple[0]['name'].$type_data;
 $Out_trade_no = $indent[0]['indents'];
/* $data['type'] = $type;
 $data['temple'] = $temple;
 var_dump($data);exit;*/
//①、获取用户openid
$tools = new JsApiPay();
$openId = $tools->GetOpenid();
//$openId = $_SESSION['OPEN'];
//print_r($openId);exit;
//②、统一下单

//$Out_trade_no = time().$temple['id'].rand(0,9);
$input = new WxPayUnifiedOrder();
$input->SetBody($Body);
$input->SetAttach("test");
$input->SetOut_trade_no($Out_trade_no);
$input->SetTotal_fee($money*100);
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag("test");
$input->SetNotify_url("http://ceshi-jingying.cn.01.hbok.cn/Wxpay/example/notify.php");
$input->SetTrade_type("JSAPI");
$input->SetOpenid($openId);

$order = WxPayApi::unifiedOrder($input);
//echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
//print_r($order);exit;
$jsApiParameters = $tools->GetJsApiParameters($order);

//获取共享收货地址js函数参数
$editAddress = $tools->GetEditAddressParameters();

//③、在支持成功回调通知中处理成功之后的事宜，见 notify.php
/**
 * 注意：
 * 1、当你的回调地址不可访问的时候，回调通知会失败，可以通过查询订单来确认支付是否成功
 * 2、jsapi支付时需要填入用户openid，WxPay.JsApiPay.php中有获取openid流程 （文档可以参考微信公众平台“网页授权接口”，
 * 参考http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html）
 */
?>

<html lang="en">
<head>
<meta charset="UTF-8">
<meta id="viewPorts" name="viewport" content="width=device-width">
<script>
//不同分辨率手机加载
var appVersion = window.navigator.appVersion;
var platform = '', viewPorts = '';
if(appVersion.toLowerCase().indexOf('android')){
	platform = 'android';
}else if(appVersion.indexOf('iPhone') || appVersion.indexOf('iPod') || appVersion.indexOf('iPad')){
	platform = 'ios';
}
var winWidth = window.screen.width,
	targetDensitydpi = winWidth / 640;
switch(platform){
	case 'android':
		var devicePixelRatio = window.devicePixelRatio;
		targetDensitydpi = 640 / winWidth * devicePixelRatio * 160;
		viewPorts = 'width=640,target-densitydpi=' + targetDensitydpi + ',user-scalable=no';
		break;
	case 'ios':
		viewPorts = 'width=640,initial-scale=' + targetDensitydpi + ',mininum-scale=' + targetDensitydpi +',maxinum-scale=' + targetDensitydpi + ',user-scalable=no';
		break;
}
if(viewPorts){
	document.getElementById('viewPorts').setAttribute('content', viewPorts);
}
</script>
    <script type="text/javascript">
	//调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			<?php echo $jsApiParameters; ?>,
			function(res){
				WeixinJSBridge.log(res.err_msg);
			   if(res.err_msg == "get_brand_wcpay_request:ok"){
               //alert(res.err_code+res.err_desc+res.err_msg);
                   var host2 = document.domain; 
                   window.location.href="http://"+host2+"/index.php/home/member/goods_info?indent_id=<?php echo $indent_id; ?>";
               }else{
                   //返回跳转到订单详情页面
                   alert(支付失败);
                   //window.location.href="http://blog.sina.com.cn/u/1863605217";
                     
               }
			}
		);
	}

	function callpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}
	</script>
	<script type="text/javascript">
	//获取共享地址
	function editAddress()
	{
		WeixinJSBridge.invoke(
			'editAddress',
			<?php echo $editAddress; ?>,
			function(res){
				var value1 = res.proviceFirstStageName;
				var value2 = res.addressCitySecondStageName;
				var value3 = res.addressCountiesThirdStageName;
				var value4 = res.addressDetailInfo;
				var tel = res.telNumber;
				
				//alert(value1 + value2 + value3 + value4 + ":" + tel);
			}
		);
	}
	
	window.onload = function(){
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', editAddress, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', editAddress); 
		        document.attachEvent('onWeixinJSBridgeReady', editAddress);
		    }
		}else{
			editAddress();
		}
	};
	
	</script>
<style type="text/css">
	/*È·ÈÏÖ§¸¶*/
.confirm{ min-height:100vh; background:#fff;}
.confirm h2{ display:block; height:88px; line-height:90px; color:#a66748; font-size:36px; font-weight:normal; border-bottom:1px solid #ddd;}
.confirm h2 img{ display:block; height:68px; float:left; padding:10px 16px;}
.confirm form{ display:block; overflow:hidden;}
.confirm .pic{ text-align:center;}
.confirm .pic em{ display:block; height:72px; line-height:74px; color:#f85f72; font-size:24px; padding:14px 0 0;}
.confirm .pic img{ display:block; width:168px; border:8px solid rgba(125,24,39,0.2); border-radius:50%; margin:0 auto;}
.confirm .pic span{ display:block; height:72px; line-height:74px; color:#4e4e4e; font-size:28px;}
.confirm .choose label{ display:block; height:72px; line-height:74px; color:#4e4e4e; font-size:24px; padding:16px 28px 0; border-bottom:1px solid #ddd;}
.confirm .choose p{ display:block; height:86px; line-height:88px; color:#4e4e4e; font-size:28px; padding:0 28px; border-bottom:1px solid #ddd; position:relative;}
.confirm .choose p img{ display:block; height:46px; padding:20px 12px 0 0; float:left;}
.confirm .choose p.cur::before,
.confirm .choose p.cur::after{ content:''; display:block; width:6px; background:#4cb14b; border-radius:2px; position:absolute; right:48px; top:32px;}
.confirm .choose p.cur::before{ height:16px; transform:rotate(-45deg); margin:6px 0 0 0;}
.confirm .choose p.cur::after{ height:24px; transform:rotate(45deg); margin:-1px -11px 0 0;}
.confirm .choose em{ display:block; height:86px; line-height:88px; color:#4e4e4e; font-size:28px; text-align:center; padding:0 28px; border-bottom:1px solid #ddd; position:relative;}
.confirm input.btn{ display:block; width:80%; height:82px; color:#fff; font-size:30px; background:#45be8b; border:0; border-radius:5px; cursor:pointer; margin:36px auto 10%;}

</style>
<meta name="keywords" content="" />
<meta name="description" content="" />
<title>确认支付 - 随身功德宝</title>
<link rel="shortcut icon" href="images/favicon.ico" />
<link rel="stylesheet" type="text/css" href="css/base.css" />
<link rel="stylesheet" type="text/css" href="css/common.css" />
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jquery.SuperSlide.js"></script>
<script type="text/javascript" src="js/TouchSlide.1.1.js"></script>
</head>

<body>
<div class="wrap">
	<div class="confirm">
		<style>.wrap{ padding-bottom:0;}</style>
		<h2><img src="title_ico.png" /><?php echo $temple[0]['name']; ?></h2>
		<form>
			<div class="pic">
				<em>感谢您的护持与供养，功德无量</em>
                <?php if($indent[0]['type']==1){ ?>
				<img src="logo.png" />
                <?php }else{ ?>
                <img src="<?php echo $temple[0]['picture']; ?>" height="120" width="120" />
                <?php } ?>
				<span>在线供奉<?php echo $temple[0]['name']; ?>&nbsp;<?php echo $type_data; ?></span>
			</div>
			<div class="choose">
				<label>付款方式</label>
				<p class="cur"><img src="pay1.png"> 微信</p>
				<em class="sum">总支付金额：<?php echo $money; ?>元</em>
			</div>
			<input class="btn" type="button" value="支 付" onclick="callpay()" />
		</form>
	</div>
</div>
</body>
</html>

