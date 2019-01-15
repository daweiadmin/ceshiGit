<?php if (!defined('THINK_PATH')) exit();?><html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>登录</title>
    <link rel="stylesheet" type="text/css" href="/Public/admin/css/login.css" />
    <script type="text/javascript"  src="/Public/media/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="/Public/media/js/layer/dialog.js"></script> 
    <script type="text/javascript" src="/Public/media/js/layer/layer.js"></script> 
    <script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.1/jquery.js"></script>
</head>

<body>


    <div id="center">
        <div class="head">
            <img src="/Public/media/logo.png"> 
        </div>
        <div class="main">
            <input type="text" value="" placeholder="账号" name="username" id="username"/>
            <input type="password" value="" placeholder="密码" class="pwd" name="password" id="password"/>
            <input type="text" placeholder="验证码" size="10" style="width:80px; height:30px; float: left; margin-left: 36px; " name="code" id="code"/>
                           <img src="<?php echo U('login/verify',array());?>"  onclick=this.src="/index.php/Admin/Login/verify/"+Math.random() alt="" height="40" width="126" align="absmiddle" style="position:relative;top:-2px; float: left; margin-left: 36px;" title="看不清？点击更换另一个验证码。"  />
            <div class="btn" id="submit" style="clear: both; cursor:pointer;">登  录</div>
        </div>
        <div class="lt">
            <div class="dds">

                
              
            </div>
            <div class="dds">
                <p><a href="/">返回首页>></a></p>
               
            </div>
        </div>

    </div>

</body>
<script>
    $('#submit').click(function(){
     var url = '/index.php/Admin/Login/index';
     var jump_url = '/index.php/Admin/index/index';
     var name = $('#username').val();
     var password = $('#password').val();
     var code = $('#code').val();

     if(!name){
       dialog.error('请填写用户名');return false;
     }
     if(!password){
       dialog.error('请输入密码');return false;
     }
     if(!code){
       dialog.error('请输入验证码');return false;
     }
     var data = {'username':name,'password':password,'code':code};
     $.post(url,data,function(res){
        if (res.status == 1) {
              window.location.href=jump_url;
            } 
         if(res.status == 0){
            dialog.error(res.message);
        }

     },'JSON');

    });

</script>
</html>