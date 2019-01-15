<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
 <!DOCTYPE html>

<!-- 

Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 2.3.1

Version: 1.3

Author: KeenThemes

Website: http://www.keenthemes.com/preview/?theme=metronic

Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469

-->

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->

<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->

<!--[if !IE]><!--> <html lang="en" class="no-js"> <!--<![endif]-->

<!-- BEGIN HEAD -->

<head>

	<meta charset="utf-8" />

	<title>商户后台管理</title>

	<meta content="width=device-width, initial-scale=1.0" name="viewport" />

	<meta content="" name="description" />

	<meta content="" name="author" />

	<!-- BEGIN GLOBAL MANDATORY STYLES -->

	<link href="/Public/media/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

	<link href="/Public/media/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>

	<link href="/Public/media/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>

	<link href="/Public/media/css/style-metro.css" rel="stylesheet" type="text/css"/>

	<link href="/Public/media/css/style.css" rel="stylesheet" type="text/css"/>

	<link href="/Public/media/css/style-responsive.css" rel="stylesheet" type="text/css"/>

	<link href="/Public/media/css/default.css" rel="stylesheet" type="text/css" id="style_color"/>

	<link href="/Public/media/css/uniform.default.css" rel="stylesheet" type="text/css"/>

	<!-- END GLOBAL MANDATORY STYLES -->

	<!-- BEGIN PAGE LEVEL STYLES --> 

	<link href="/Public/media/css/jquery.gritter.css" rel="stylesheet" type="text/css"/>

	<link href="/Public/media/css/daterangepicker.css" rel="stylesheet" type="text/css" />

	<link href="/Public/media/css/fullcalendar.css" rel="stylesheet" type="text/css"/>

	<link href="/Public/media/css/jqvmap.css" rel="stylesheet" type="text/css" media="screen"/>
    <link href="/Public/media/css/page.css" rel="stylesheet" type="text/css" media="screen"/>

	<link href="/Public/media/css/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>

	<!-- END PAGE LEVEL STYLES -->

	<link rel="shortcut icon" href="/Public/media/image/favicon.ico" />
    <script type="text/javascript"  src="/Public/media/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="/Public/media/js/layer/dialog.js"></script> 
    <script type="text/javascript" src="/Public/media/js/layer/layer.js"></script> 
   <!--  <script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.1/jquery.js"></script> -->
   <style>
*{ margin:0; padding:0;}
.navbar-inner{
	height:80px !important;
}
@media (min-width: 980px){
	.page-content{
		margin-top:40px !important;
	}
}
.navbar-inner .brand{
	height:80px !important;
	line-height: 80px;
	padding:0;
	margin-left:10px;
	color:orange;
	width: 400px;
}
.header .nav > li.dropdown.user .dropdown-toggle{
	margin-top:5px;
	float:right;
	right:0;
}
.btn.red11{
	width:50px;
	height:50px;
	border-radius: 50% !important;
	padding:0;
	line-height: 50px;
	text-align: center
}
/*form.userform{ display:block; padding:100px;}*/
.userform p{ display:block; overflow:hidden; padding:10px 16px;}
.userform p label{ display:block; width:200px; height:36px; line-height:36px; color:#333; font-size:14px; float:left; white-space:nowrap;}
.userform p label font{ color:#ff2222; padding-right:4px;}
.userform p input.file{ display:none;}
.userform p span.file{ display:block; width:200px; text-align: center; height:auto; min-height:34px; padding:0; background:#fff; border:1px solid #9b9b9b; float:left; overflow:hidden;}
.userform p span.file img{ display:block; width:100%; height:auto; padding:8px 0 0; float:none; margin:0; cursor:default;}
.userform p span.file img:first-child{ padding:0;}
.userform p span.file a{ display:block;}
.userform p span.file a img{ cursor:pointer;}
.userform p label.file{ display:block; width:70px; height:36px; line-height:36px; color:#fff; font-size:14px; text-align:center; background:#00a266; float:left; margin:0 0 0 10px; cursor:pointer; padding:0;}

/* 分页 */
	.list-page{padding:20px 0;text-align:right;}
    .list-page a{margin:0 2px;padding:5px 10px;border:1px solid #ccc;background:#fff;}
    .list-page a:hover{background:#e4e4e4;border:1px solid #908f8f; text-decoration: none;}
    .list-page .current{margin:0 2px;padding:5px 10px;background:#6495ED;border:1px solid #B0C4DE;color:#fff;}
    .list-page ul{list-style: none;}


</style>
</head>
<!-- BEGIN HEADER -->
<!-- END HEAD -->

<!-- BEGIN BODY -->
<?php  $shop['id'] = session('shopUser.id'); $fin = D('shop')->where($shop)->field('id,type,name,end_time')->find(); $dali_id = session('shopUser.top_daili_id'); ?>	<?php ?>
<body class="page-header-fixed">
	<div class="header navbar navbar-inverse navbar-fixed-top">

		<!-- BEGIN TOP NAVIGATION BAR -->

		<div class="navbar-inner">

			<div class="container-fluid">

				<!-- BEGIN LOGO -->
                
				<a class="brand" href="javascript:(0);">
                  <?php if($fin['type']==3){ ?>
				     <span><?php echo ($fin["name"]); ?>--商户后台</span>
                  <?php }else{ ?>
                     <span><?php echo ($fin["name"]); ?>--代理后台</span>
                  <?php } ?>
				</a>



				<!-- END LOGO -->

				<!-- BEGIN RESPONSIVE MENU TOGGLER -->

				<a href="javascript:;" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">

				<img src="/Public/youji/images/common/logo.png" alt="" />

				</a>          

				<!-- END RESPONSIVE MENU TOGGLER -->            

				<!-- BEGIN TOP NAVIGATION MENU -->              

				<ul class="nav pull-right">

		
					<!-- END TODO DROPDOWN -->
                    <?php $user = session('name'); ?>
					<!-- BEGIN USER LOGIN DROPDOWN -->
               
					<li class="dropdown user">
					
                      <?php if($fin['type']==1){ ?>
					     <button type="button" class="btn blue" style=" color:white; margin-top:22px";> < 省级代理 > </button> 
	                  <?php } ?>

	                  <?php if($fin['type']==2){ ?>
	                     <button type="button" class="btn yellow" style=" color:white; margin-top:22px";> < 市级代理 > </button> 
	                  <?php } ?>
	                  <?php if($fin['type']==3){ ?>
                       <?php if($dali_id){ ?>
	                   <a href="/index.php/Shop/shop/return_daili?daili_id=<?php echo ($dali_id); ?>" style="display: inline-block;">
	                     <button type="button" class="btn yellow" style=" color:white; margin-top:22px";> << 返回代理平台  </button> 
	                     </a>
	                     <?php } ?>

	                  <?php } ?>
	                  <button type="button" class="btn blue" style=" color:white; margin-top:22px";> 有效期至：<?php echo (date("Y-m-d",$fin["end_time"])); ?> </button> 
						<a href="javascript:viod(0);" class="dropdown-toggle" data-toggle="dropdown">

						 <div type="button" class="btn red red11" id="submit">设置</div>

						<span class="username"><?php echo ($user); ?></span>

						<i class="icon-angle-down"></i>

						</a>

						<ul class="dropdown-menu">
<!-- 
							<li><a href="extra_profile.html"><i class="icon-user"></i> My Profile</a></li>

							<li><a href="page_calendar.html"><i class="icon-calendar"></i> My Calendar</a></li>

							<li><a href="inbox.html"><i class="icon-envelope"></i> My Inbox(3)</a></li>

							<li><a href="#"><i class="icon-tasks"></i> My Tasks</a></li>

							<li class="divider"></li>

							<li><a href="extra_lock.html"><i class="icon-lock"></i> Lock Screen</a></li> -->

							<li><a href="/index.php/Shop/login/logout"><i class="icon-key"></i>退出</a></li>

						</ul>

					</li>

					<!-- END USER LOGIN DROPDOWN -->

				</ul>

				<!-- END TOP NAVIGATION MENU --> 

			</div>

		</div>

		<!-- END TOP NAVIGATION BAR -->

	</div>

	<!-- END HEADER -->
  <!-- END HEADER -->
  <script type="text/javascript" src="/Public/city/jquery.min.js"></script>
  <script type="text/javascript" src="/Public/city/City_data.js"></script>
  <script type="text/javascript" src="/Public/city/areadata.js"></script>
  <!-- BEGIN CONTAINER -->
  <link href="/Public/city/zyzn_1.css" type="text/css" rel="stylesheet">
  <div class="page-container row-fluid">

    <!-- BEGIN SIDEBAR -->

     	<!-- BEGIN SIDEBAR -->

		<div class="page-sidebar nav-collapse collapse">

			<!-- BEGIN SIDEBAR MENU -->        

			<ul class="page-sidebar-menu">

				<li>

					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->

					<div class="sidebar-toggler hidden-phone"></div>

					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->

				</li>

				<li>

					<!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->

				<!-- 	<form class="sidebar-search">
				
					<div class="input-box">
				
						<a href="javascript:;" class="remove"></a>
				
						<input type="text" placeholder="Search..." />
				
						<input type="button" class="submit" value=" " />
				
					</div>
				
				</form> -->

					<!-- END RESPONSIVE QUICK SEARCH FORM -->

				</li>

               <?php  $data22['id'] = session('shopUser.id'); $shop_left = D('shop')->where($data22)->field('id,type')->find(); ?>	
				<li class="start active ">

					<a href="/index.php/Shop/index/index">

					<i class="icon-home"></i> 

					<span class="title">系统菜单</span>

					<span class="selected"></span>

					</a>

				</li>
				<li class="">

					<a href="javascript:;">

					<i class="icon-male"></i> 

					<span class="title">活动管理</span>

					<span class="arrow "></span>

					</a>

					<ul class="sub-menu">
                       <li >

							<a href="/index.php/Shop/activity/index">
                              <i class="icon-user"></i> 
							活动列表
							</a>

						</li>
						<li >

							<a href="/index.php/Shop/code/index">
                              <i class="icon-user"></i> 
							码段管理
							</a>

						</li>
						<li >

							<a href="/index.php/Shop/index/index">
                              <i class="icon-user"></i> 
							数据统计
							</a>

						</li>
						<li >

							<a href="/index.php/Shop/member/record">
                              <i class="icon-user"></i> 
							资金流水
							</a>

						</li>
						<li >

							<a href="/index.php/Shop/member/index">
                              <i class="icon-user"></i> 
							用户管理
							</a>

						</li>
					</ul>

				</li>
               
              <?php if($shop_left['type']!==3){ ?>
                <li class="">

					<a href="javascript:;">

					<i class="icon-male"></i> 

					<span class="title">代理 / 商户管理</span>

					<span class="arrow "></span>

					</a>

					<ul class="sub-menu">
                     <?php if($shop_left['type']==1){ ?>
                       <li >
                       
							<a href="/index.php/Shop/shop/daili_index">
                              <i class="icon-user"></i> 
							代理列表
							</a>

						</li>
                        <?php } ?>
						<li >

							<a href="/index.php/Shop/shop/store">
                              <i class="icon-user"></i> 
							商户列表
							</a>

						</li>
					</ul>

				</li>
             <?php } ?>

				<!-- <li class="">
				
					<a href="javascript:;">
				
					<i class="icon-male"></i> 
				
					<span class="title">码段管理</span>
				
					<span class="arrow "></span>
				
					</a>
				
					<ul class="sub-menu">
				                       <li >
				
							<a href="/index.php/Shop/code/index">
				                              <i class="icon-user"></i> 
							码段列表
							</a>
				
						</li>
						<li >
				
							<a href="/index.php/Shop/member/vip_index">
				                              <i class="icon-user"></i> 
							商户列表
							</a>
				
						</li>
					</ul>
				
				</li> -->
				<li class="">

					<a href="javascript:;">

					<i class="icon-male"></i> 

					<span class="title">奖券管理</span>

					<span class="arrow "></span>

					</a>

					<ul class="sub-menu">
                       <li >

							<a href="/index.php/Shop/ticket/index">
                              <i class="icon-user"></i> 
							兑换券管理
							</a>

						</li>
						<li >

							<a href="/index.php/Shop/ticket/you_index">
                              <i class="icon-user"></i> 
							优惠券管理
							</a>

						</li>
						<li >

							<a href="/index.php/Shop/ticket/ticket_hexiao">
                              <i class="icon-user"></i> 
							奖券核销
							</a>

						</li>
					</ul>

				</li>
			<!-- 
				<li class="">
			
					<a href="javascript:;">
			
					<i class="icon-male"></i> 
			
					<span class="title">会员管理</span>
			
					<span class="arrow "></span>
			
					</a>
			
					<ul class="sub-menu">
			                       <li >
			
							<a href="/index.php/Shop/member/putong">
			                              <i class="icon-user"></i> 
							普通粉丝列表
							</a>
			
						</li>
						<li >
			
							<a href="/index.php/Shop/member/index">
			                              <i class="icon-user"></i> 
							普通会员列表
							</a>
			
						</li>
						<li >
			
							<a href="/index.php/Shop/member/vip_index">
			                              <i class="icon-user"></i> 
							VIP会员列表
							</a>
			
						</li>
						<li >
			
							<a href="/index.php/Shop/member/daili_index">
			                              <i class="icon-user"></i> 
							总代理列表
							</a>
			
						</li>
			
					</ul>
			
				</li> -->
			
              
				<li>

					<a class="active" href="javascript:;">

					<i class="icon-cogs"></i> 

					<span class="title">系统设置</span>

					<span class="arrow "></span>

					</a>

					<ul class="sub-menu">
                       <li>

							<a href="/index.php/Shop/user/store">

							门店管理

							</a>

						</li>
						<li>

							<a href="/index.php/Shop/user/hexiao">

							核销成员管理

							</a>

						</li>
						 <li>

							<a href="/index.php/Shop/weixin/auth">

							微信公众号授权

							</a>

						</li>
						<li>

							<a href="/index.php/Shop/user/index">

							基本设置

							</a>

						</li>
						<li>

							<a href="/index.php/Shop/user/bian">

							修改密码

							</a>

						</li>

					</ul>

				</li>
			
      </ul>
			
					
		</div>

		<!-- END SIDEBAR -->

    <!-- END SIDEBAR -->

    <!-- BEGIN PAGE -->  

    <div class="page-content">

      <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->

      <div id="portlet-config" class="modal hide">

        <div class="modal-header">

          <button data-dismiss="modal" class="close" type="button"></button>

          <h3>portlet Settings</h3>

        </div>

        <div class="modal-body">

          <p>Here will be a configuration form</p>

        </div>

      </div>

      <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->

      <!-- BEGIN PAGE CONTAINER-->

      <div class="container-fluid">

        <!-- BEGIN PAGE HEADER-->   

        <div class="row-fluid">

          <div class="span12">

            <!-- BEGIN STYLE CUSTOMIZER -->

            
                     
            <!-- END BEGIN STYLE CUSTOMIZER -->   

            <h3 class="page-title">

              新增活动

            </h3>

            <ul class="breadcrumb">

              <li>

                <i class="icon-home"></i>

                <a href="index.html">活动管理</a> 

                <span class="icon-angle-right"></span>

              </li>

            <!--   <li>
            
              <a href="#">代理管理</a>
            
              <span class="icon-angle-right"></span>
            
            </li> -->

              <li><a href="#">新增活动</a></li>

            </ul>

          </div>

        </div>

        <!-- END PAGE HEADER-->

        <!-- BEGIN PAGE CONTENT-->

        <div class="row-fluid">

          <div class="span12">

            <!-- BEGIN SAMPLE FORM PORTLET-->   

            <div class="portlet box blue">

              <div class="portlet-title">

                <div class="caption"><i class="icon-reorder"></i>新增活动</div>

                <div class="tools">

                  <a href="javascript:;" class="collapse"></a>

                  <a href="#portlet-config" data-toggle="modal" class="config"></a>

                  <a href="javascript:;" class="reload"></a>

                  <a href="javascript:;" class="remove"></a>

                </div>

              </div>
           
              <div class="portlet-body form">

                <!-- BEGIN FORM-->

                <form action="#" class="form-horizontal" id="form">
                  <ul id="myTab" class="nav nav-tabs">
                    <li class="active"><a href="#home" data-toggle="tab">基础设置</a></li>
                    <li><a href="#zhubiaoti" data-toggle="tab">页面设置</a></li>
                    <li><a href="#hdjlzz" data-toggle="tab">活动奖励设置</a></li>
                    <li><a href="#cycs" data-toggle="tab">条件设置</a></li>
                   <!--  <li><a href="#ljtj" data-toggle="tab">领奖条件</a></li>
                   <li><a href="#sjyh" data-toggle="tab">收集用户</a></li> -->
                    <li><a href="#qyxz" data-toggle="tab">区域限制</a></li>
                  </ul>
               <div id="myTabContent" class="tab-content">
                <div id="home" class="control-group tab-pane fade in active">
                  <div  >

                     <label class="control-label"><span style="color: red;">*</span>活动名称</label>

                      <div class="controls">

                        <input type="text" class="span6 m-wrap" style="width:300px;" name="act_name" id="act_name" value=""/>
                        <span style="color:red;">*活动名称请不要超过10个汉字（微信红包要求活动名称不得超过10个汉字）</span>
                     </div>

                   </div>

                   <div style="margin-top: 20px;">

                      <label class="control-label"><span style="color: red;">*</span>码段绑定</label>

                      <div class="controls maduan_num" id="code_list">

                     <button type="button" class="btn blue click_shop" onclick="fenpei_maduan()">分配码段</button>
                     <div style="height: 44px; width:500px; border:1px dashed #CFCFCF; text-align:left; padding-left: 10px; line-height: 44px; font-size: 15px; display: none;" id="total_box">总计码量：<span id="total_code"></span> 个</div>
                    
                    </div>
                      
                   </div>
                  <div style="margin-top: 50px;">
                      <label class="control-label"><span style="color: red;"></span></label>
                      <div class="" id="" style="height: 100px;">
                         <a href="#zhubiaoti" data-toggle="tab"><button type="button" class="btn green"  id="next">下一步</button></a>
                         <button type="button" class="btn red" attr-id="2"  onclick="submit_form(2)">保存草稿</button>
                        <!--  <button type="button" class="btn blue" attr-id="1"  onclick="submit_form(1)">确认保存</button> -->
                         <a href="/index.php/Shop/Activity/index"><button type="button" class="btn">取消</button></a>
                      </div>
                    </div>  
                
                </div><!-- 1选项卡结束  -->
                <script>
                     $('#next').click(function(){
                      for (var i=0;i<$( "#myTab li" ).length;i++) {
                        $( "#myTab li" ).eq(i).removeClass( "active" );
                      }
                      $( "#myTab li" ).eq(1).addClass( "active" );

                     });
                </script>

                  <!--  <span style="margin-left: 100px; margin-bottom:50px;">====================================================*页面设置*=====================================================</span> -->


                <div class="control-group tab-pane fade" id="zhubiaoti">
                    <div  >

                      <label class="control-label"><span style="color: red;">*</span>填写完成后点击：</label>

                      <div class="controls">

                        <a href="#hdjlzz" data-toggle="tab"><button type="button" class="btn yellow"  id="next7">下一步</button></a>
                       <span style="color:red;">*如无需填写以下资料，可以直接点击下一步，如需填写请填写完成后再进行点击</span>
                      </div>

                   </div>
                   <script>
                    $('#next7').click(function(){
                      for (var i=0;i<$( "#myTab li" ).length;i++) {
                        $( "#myTab li" ).eq(i).removeClass( "active" );
                      }
                      $( "#myTab li" ).eq(2).addClass( "active" );

                     });
                </script>
                   <div  style="margin-top:20px;">

                      <label class="control-label"><span style="color: red;">*</span>主标题</label>

                      <div class="controls">

                        <input type="text" class="span6 m-wrap" style="width:300px;" name="title" id="title" value="领程科技邀你扫码领红包"/>
                       
                      </div>

                   </div>
                  
                    <div style="margin-top:20px;">

                      <label class="control-label">活动图片</label>

                      <div class="controls" style="position: relative;display: inline-block;overflow: hidden;margin-left:19px;margin-top: -5px;height: 34px;">
                        <span style="background: green;color: #fff;padding: 15px 10px;line-height: 35px;cursor: pointer; font-size: 14px;">上传文件</span>
                        <input type="file" class="imgfiles" style="position:absolute;right: 0px;top: 0px;opacity: 0;-ms-filter: 'alpha(opacity=0)';
              font-size: 200px;cursor: pointer;">
                        <input type="hidden" class="imgurl" name="picture">
                        
                          <span style="color: blue; margin-left: 20px;">*图片大小最大6M</span>
                      </div>
                       <div class="hidd" style=" margin-left: 180px;">
                         <?php if($typeid == 1): ?><img src="/Public/media/image/banner.png" alt="" class="imgpic" width="300" height="160"><?php endif; ?>
                      </div>
                  </div>

                  <div  style="height:200px;">

                    <label class="control-label">活动描述</label>

                    <div class="controls">

                      <textarea  id="content"  name="describe" id="describe">
                       <p>领程科技邀你扫码领红包</p>
                      </textarea>
                     

                    </div>

                  </div>
                  <div style="height:300px;">

                    <label class="control-label">活动规则</label>

                    <div class="controls">

                      <textarea  id="content2"  name="rule" id="rule"  >
                        <p>1. 前往线下活动站点参与活动，领取红包二维码；</p>
                        <p>2. 刮开二维码，手机微信扫一扫抽奖；</p>
                        <p>3. 按页面提示领奖；</p>
                       <p> 4. 完成任务后现金自动到账。</p>
                        <p>由于参与人数众多，到账时间可能稍有延时，请您耐心等待，感谢您的参与！</p>

                      </textarea>
                     

                    </div>

                  </div>
                  <div  style="height:200px;">

                    <label class="control-label">活动说明</label>
                    <div class="controls">
                      <textarea  id="content3"  name="instruction" id="instruction">
                        <p> *本活动最终解释权归主办方所有*</p>
                      </textarea>
                    </div>

                  </div>
                <!--    <div style="margin-top: 50px; position:absolute; z-index: 1000;">
                   <label class="control-label"><span style="color: red;"></span></label>
                   <div class="" id="" style="height: 100px;">
                      <button type="button" class="btn blue" attr-id="1"  onclick="submit_form(1)">确认保存</button>
                      <button type="button" class="btn red" attr-id="2"  onclick="submit_form(2)">保存草稿</button>
                      <a href="/index.php/Shop/Activity/index"><button type="button" class="btn">取消</button></a>
                   </div>
                 </div>  -->

            
             </div><!-- 2选项卡结束  -->

                      <script type="text/javascript" src="/Public/Ueditor/ueditor.config.js"></script>
                  <!-- 编辑器源码文件-->
                      <script type="text/javascript" src="/Public/Ueditor/ueditor.all.js"></script> 
                      <script type="text/javascript" src="/Public/Ueditor/lang/zh-cn/zh-cn.js"></script> 
                      <!-- 实例化编辑器 -->
                      <script type="text/javascript">
                          var ue = UE.getEditor('container',{
                              initialFrameHeight: 200,
                              /*serverUrl :'<?php echo U('Admin/Public/ueditor');?>',*/
                          })
                      </script>
                      <script type="text/javascript">
                          UE.getEditor('content',{initialFrameWidth:1000,initialFrameHeight:80,});
                      </script>
                      <script type="text/javascript">
                          UE.getEditor('content2',{initialFrameWidth:1000,initialFrameHeight:80,});
                      </script>
                      <script type="text/javascript">
                          UE.getEditor('content3',{initialFrameWidth:1000,initialFrameHeight:80,});
                      </script>

               <!--     <span style="margin-left: 100px; margin-bottom:50px;">====================================================*活动奖励设置*=====================================================</span> -->
                  <div class="control-group tab-pane fade" id="hdjlzz">

                    <label class="control-label"><span style="color: red;">*</span>活动奖励设置</label>

                    <div class="controls">

                      <div class="control-group sizz" style=" width:700px;">
                       <?php if($typeid != 2): if($typeid != 3): ?><button type="button" class="btn yellow" id="siz"  class="" >添加奖励</button><?php endif; endif; ?>
                       <div >
                       <br>
                           <p style="background-color: yellow; ">温馨提示：</p>
                           <p style="background-color: yellow; ">1、红包金额配置范围为0.30~20000.00元，数量必须为大于0的整数 </p>  
                           <p style="background-color: yellow; ">2、出于资金安全考虑，红包金额100.00元以内系统立即自动转款，金额超过100.00元，则24小时内人工审核后转款</p>
                           <p style="background-color: yellow; ">3、活动创建后奖励不能修改或删除，可以在活动列表页追加奖励！</p>
                         <br>
                       </div>
                       <?php if($typeid == 2): ?><div class="d" style="margin-top:5px;margin-bottom:5px;margin-left:5px; pandding:0px; "><span>奖励类型：</span><select class="span6 m-wrap money_type" onchange="changes(this)" data-placeholder="Choose a Category" tabindex="1" style="width:150px;" name="money_type[]" ><option value="1">--现金红包--</option><option value="2">--随机红包--</option><option value="3">--兑换券--</option><option value="4">--优惠券--</option></select> <div style="display: inline-block" class="a_nei"><span style="margin-left:10px;" class="wenzi">奖励内容</span><input type="text" name="money[]" style="width:100px; margin-left:5px;" placeholder="0.3"/> 元</div><span style="margin-left:10px;">数量</span><input type="number" min="1" name="amount[]" style="width:50px; margin-left:5px;" value="1" /></div>

                         <div class="d" style="margin-top:5px;margin-bottom:5px;margin-left:5px; pandding:0px; "><span>奖励类型：</span><select class="span6 m-wrap money_type" onchange="changes(this)" data-placeholder="Choose a Category" tabindex="1" style="width:150px;" name="money_type[]" ><option value="1">--现金红包--</option><option value="2">--随机红包--</option><option value="3">--兑换券--</option><option value="4">--优惠券--</option></select> <div style="display: inline-block" class="a_nei"><span style="margin-left:10px;" class="wenzi">奖励内容</span><input type="text" name="money[]" style="width:100px; margin-left:5px;" placeholder="0.3"/> 元</div><span style="margin-left:10px;">数量</span><input type="number" min="1" name="amount[]" style="width:50px; margin-left:5px;" value="1"/></div>

                         <div class="d" style="margin-top:5px;margin-bottom:5px;margin-left:5px; pandding:0px; "><span>奖励类型：</span><select class="span6 m-wrap money_type" onchange="changes(this)" data-placeholder="Choose a Category" tabindex="1" style="width:150px;" name="money_type[]" ><option value="1">--现金红包--</option><option value="2">--随机红包--</option><option value="3">--兑换券--</option><option value="4">--优惠券--</option></select> <div style="display: inline-block" class="a_nei"><span style="margin-left:10px;" class="wenzi">奖励内容</span><input type="text" name="money[]" style="width:100px; margin-left:5px;" placeholder="0.3"/> 元</div><span style="margin-left:10px;">数量</span><input type="number" min="1" name="amount[]" style="width:50px; margin-left:5px;" value="1"/></div>

                         <div class="d" style="margin-top:5px;margin-bottom:5px;margin-left:5px; pandding:0px; "><span>奖励类型：</span><select class="span6 m-wrap money_type" onchange="changes(this)" data-placeholder="Choose a Category" tabindex="1" style="width:150px;" name="money_type[]" ><option value="1">--现金红包--</option><option value="2">--随机红包--</option><option value="3">--兑换券--</option><option value="4">--优惠券--</option></select> <div style="display: inline-block" class="a_nei"><span style="margin-left:10px;" class="wenzi">奖励内容</span><input type="text" name="money[]" style="width:100px; margin-left:5px;" placeholder="0.3"/> 元</div><span style="margin-left:10px;">数量</span><input type="number" min="1" name="amount[]" style="width:50px; margin-left:5px;" value="1"/></div>

                         <div class="d" style="margin-top:5px;margin-bottom:5px;margin-left:5px; pandding:0px; "><span>奖励类型：</span><select class="span6 m-wrap money_type" onchange="changes(this)" data-placeholder="Choose a Category" tabindex="1" style="width:150px;" name="money_type[]" ><option value="1">--现金红包--</option><option value="2">--随机红包--</option><option value="3">--兑换券--</option><option value="4">--优惠券--</option></select> <div style="display: inline-block" class="a_nei"><span style="margin-left:10px;" class="wenzi">奖励内容</span><input type="text" name="money[]" style="width:100px; margin-left:5px;" placeholder="0.3"/> 元</div><span style="margin-left:10px;">数量</span><input type="number" min="1" name="amount[]" style="width:50px; margin-left:5px;" value="1"/></div>

                         <div class="d" style="margin-top:5px;margin-bottom:5px;margin-left:5px; pandding:0px; "><span>奖励类型：</span><select class="span6 m-wrap money_type" onchange="changes(this)" data-placeholder="Choose a Category" tabindex="1" style="width:150px;" name="money_type[]" ><option value="1">--现金红包--</option><option value="2">--随机红包--</option><option value="3">--兑换券--</option><option value="4">--优惠券--</option></select> <div style="display: inline-block" class="a_nei"><span style="margin-left:10px;" class="wenzi">奖励内容</span><input type="text" name="money[]" style="width:100px; margin-left:5px;" placeholder="0.3"/> 元</div><span style="margin-left:10px;">数量</span><input type="number" min="1" name="amount[]" style="width:50px; margin-left:5px;" value="1"/></div>

                         <div class="d" style="margin-top:5px;margin-bottom:5px;margin-left:5px; pandding:0px; "><span>奖励类型：</span><select class="span6 m-wrap money_type" onchange="changes(this)" data-placeholder="Choose a Category" tabindex="1" style="width:150px;" name="money_type[]" ><option value="1">--现金红包--</option><option value="2">--随机红包--</option><option value="3">--兑换券--</option><option value="4">--优惠券--</option></select> <div style="display: inline-block" class="a_nei"><span style="margin-left:10px;" class="wenzi">奖励内容</span><input type="text" name="money[]" style="width:100px; margin-left:5px;" placeholder="0.3"/> 元</div><span style="margin-left:10px;">数量</span><input type="number" min="1" name="amount[]" style="width:50px; margin-left:5px;" value="1"/></div><?php endif; ?>
                      <!--- 大转盘 -->
                        <?php if($typeid == 3): ?><div class="d" style="margin-top:5px;margin-bottom:5px;margin-left:5px; pandding:0px; "><span>奖励类型：</span><select class="span6 m-wrap money_type" onchange="changes(this)" data-placeholder="Choose a Category" tabindex="1" style="width:150px;" name="money_type[]" ><option value="1">--现金红包--</option><option value="2">--随机红包--</option><option value="3">--兑换券--</option><option value="4">--优惠券--</option></select> <div style="display: inline-block" class="a_nei"><span style="margin-left:10px;" class="wenzi">奖励内容</span><input type="text" name="money[]" style="width:100px; margin-left:5px;" placeholder="0.3"/> 元</div><span style="margin-left:10px;">数量</span><input type="number" min="1" name="amount[]" style="width:50px; margin-left:5px;" value="1" /></div>

                         <div class="d" style="margin-top:5px;margin-bottom:5px;margin-left:5px; pandding:0px; "><span>奖励类型：</span><select class="span6 m-wrap money_type" onchange="changes(this)" data-placeholder="Choose a Category" tabindex="1" style="width:150px;" name="money_type[]" ><option value="1">--现金红包--</option><option value="2">--随机红包--</option><option value="3">--兑换券--</option><option value="4">--优惠券--</option></select> <div style="display: inline-block" class="a_nei"><span style="margin-left:10px;" class="wenzi">奖励内容</span><input type="text" name="money[]" style="width:100px; margin-left:5px;" placeholder="0.3"/> 元</div><span style="margin-left:10px;">数量</span><input type="number" min="1" name="amount[]" style="width:50px; margin-left:5px;" value="1"/></div>

                         <div class="d" style="margin-top:5px;margin-bottom:5px;margin-left:5px; pandding:0px; "><span>奖励类型：</span><select class="span6 m-wrap money_type" onchange="changes(this)" data-placeholder="Choose a Category" tabindex="1" style="width:150px;" name="money_type[]" ><option value="1">--现金红包--</option><option value="2">--随机红包--</option><option value="3">--兑换券--</option><option value="4">--优惠券--</option></select> <div style="display: inline-block" class="a_nei"><span style="margin-left:10px;" class="wenzi">奖励内容</span><input type="text" name="money[]" style="width:100px; margin-left:5px;" placeholder="0.3"/> 元</div><span style="margin-left:10px;">数量</span><input type="number" min="1" name="amount[]" style="width:50px; margin-left:5px;" value="1"/></div>

                         <div class="d" style="margin-top:5px;margin-bottom:5px;margin-left:5px; pandding:0px; "><span>奖励类型：</span><select class="span6 m-wrap money_type" onchange="changes(this)" data-placeholder="Choose a Category" tabindex="1" style="width:150px;" name="money_type[]" ><option value="1">--现金红包--</option><option value="2">--随机红包--</option><option value="3">--兑换券--</option><option value="4">--优惠券--</option></select> <div style="display: inline-block" class="a_nei"><span style="margin-left:10px;" class="wenzi">奖励内容</span><input type="text" name="money[]" style="width:100px; margin-left:5px;" placeholder="0.3"/> 元</div><span style="margin-left:10px;">数量</span><input type="number" min="1" name="amount[]" style="width:50px; margin-left:5px;" value="1"/></div>

                         <div class="d" style="margin-top:5px;margin-bottom:5px;margin-left:5px; pandding:0px; "><span>奖励类型：</span><select class="span6 m-wrap money_type" onchange="changes(this)" data-placeholder="Choose a Category" tabindex="1" style="width:150px;" name="money_type[]" ><option value="1">--现金红包--</option><option value="2">--随机红包--</option><option value="3">--兑换券--</option><option value="4">--优惠券--</option></select> <div style="display: inline-block" class="a_nei"><span style="margin-left:10px;" class="wenzi">奖励内容</span><input type="text" name="money[]" style="width:100px; margin-left:5px;" placeholder="0.3"/> 元</div><span style="margin-left:10px;">数量</span><input type="number" min="1" name="amount[]" style="width:50px; margin-left:5px;" value="1"/></div><?php endif; ?>
                      <div class="e" style="margin-top:5px; margin-bottom:5px; margin-left:5px; background-color: #eee; width: 695px; height: 34px; line-height:34px; text-align: center;">
                       <!--  活动总金额：￥<span style="color:red;">1.5</span>元，活动总奖励数：<span style="color:red;">2</span>个，红包：<span style="color:red;">2</span>个，兑换券：<span style="color:red;">0</span>个，优惠券：<span style="color:red;">0</span>个 -->
                      </div>
                    </div>
                    
                     

                    </div>
                          <div style="margin-top: 50px;">
                           <label class="control-label"><span style="color: red;"></span></label>
                           <div class="" id="" style="height: 100px;">
                               <a href="#cycs" data-toggle="tab"><button type="button" class="btn green"  id="next2">下一步</button></a>
                               <button type="button" class="btn red" attr-id="2"  onclick="submit_form(2)">保存草稿</button>
                              <button type="button" class="btn blue" attr-id="1"  onclick="submit_form(1)">确认保存</button>
                              <a href="/index.php/Shop/Activity/index"><button type="button" class="btn">取消</button></a>
                           </div>
                         </div> 
                  </div>
 
                  <script>
                      $('#next2').click(function(){
                        for (var i=0;i<$( "#myTab li" ).length;i++) {
                          $( "#myTab li" ).eq(i).removeClass( "active" );
                        }
                        $( "#myTab li" ).eq(3).addClass( "active" );

                       });


                    $('#siz').click(function(){
                      //var a = $('.ad').index(this);
                      var size = "<div class=\"d\" style=\"margin-top:5px;margin-bottom:5px;margin-left:5px; pandding:0px;  \"><span>奖励类型：</span><select class=\"span6 m-wrap money_type\" onchange=\"changes(this)\" data-placeholder=\"Choose a Category\" tabindex=\"1\" style=\"width:150px;\" name=\"money_type[]\" ><option value=\"1\">--现金红包--</option><option value=\"2\">--随机红包--</option><option value=\"3\">--兑换券--</option><option value=\"4\">--优惠券--</option></select> <div style=\"display: inline-block\" class=\"a_nei\"><span style=\"margin-left:10px;\" class=\"wenzi\">奖励内容</span><input type=\"text\" name=\"money[]\" style=\"width:100px; margin-left:5px;\" placeholder=\"0.3\"/> 元</div><span style=\"margin-left:10px;\">数量</span><input type=\"number\" min=\"1\" value=\"1\" name=\"amount[]\" style=\"width:50px; margin-left:5px;\"/><a href='javascript:void(0);' class=\"delfj\" style=\"height:30px; line-height:30px; margin-left:10px;\" onclick=\"dele()\">删除</a></div>";
                        $(".sizz").append(size);
                        $(".sizz").css('border','1px dashed #CFCFCF');

                     });
                     function changes(aa){
                       var a = $('.money_type').index(aa);
                      // alert(a);
                       var zhi = $('.money_type').eq(a).val();
                       if(zhi==1){
                         var zz = "<span style=\"margin-left:10px;\" class=\"wenzi\">奖励内容</span><input type=\"text\" name=\"money[]\" style=\"width:100px; margin-left:5px;\" placeholder=\"0.3\"/> 元";
                         $('.a_nei').eq(a).html("");
                         $('.a_nei').eq(a).append(zz);
                       }
                       if(zhi==2){
                         var zz = "<span style=\"margin-left:10px;\" class=\"wenzi\">总金额</span><input type=\"text\" name=\"money[]\" style=\"width:100px; margin-left:5px;\" placeholder=\"0.3\"/> 元";
                         $('.a_nei').eq(a).html("");
                         $('.a_nei').eq(a).append(zz);
                       }
                      if(zhi==3){
                          var url = '/index.php/Shop/Activity/choose_quan';
                          var data = {'type':1};
                          $.post(url,data,function(res){
                              if (res.status == 1) {
                                var ss = '';
                                ss +="<span>兑换券：</span><select class=\"span6 m-wrap \" data-placeholder=\"Choose a Category\" tabindex=\"1\" style=\"width:110px;\" name=\"money[]\" >";
                                for (var i = 0; i < res.datas.length; i++) {
                                ss += "<option value=\""+res.datas[i].id+"\">--"+res.datas[i].name+"--</option>";
                               }
                                ss+="</select>";
                                $('.a_nei').eq(a).html("");
                                $('.a_nei').eq(a).append(ss);
                             } 

                           },'JSON');
                       
                      }
                       if(zhi==4){
                          var url = '/index.php/Shop/Activity/choose_quan';
                          var data = {'type':2};
                          $.post(url,data,function(res){
                              if (res.status == 1) {
                                var ss = '';
                                ss +="<span>优惠券：</span><select class=\"span6 m-wrap \" data-placeholder=\"Choose a Category\" tabindex=\"1\" style=\"width:110px;\" name=\"money[]\" >";
                                for (var i = 0; i < res.datas.length; i++) {
                                ss += "<option value=\""+res.datas[i].id+"\">--"+res.datas[i].name+"--</option>";
                               }
                                ss+="</select>";
                                $('.a_nei').eq(a).html("");
                                $('.a_nei').eq(a).append(ss);
                             } 

                           },'JSON');
                       
                      }
                      

                     };
 
                      function dele(){
                            var a = $('.delfj').index(this);
                            $(".d").eq(a).remove();
                        }

                  </script>

                <div class="control-group tab-pane fade" id="cycs">

                   <div >
 
                    <label class="control-label"><span style="color: red;">*</span>参与次数</label>
                      <div class="controls">

                        限制：
                        <label class="radio">

                        <input type="radio" name="cishu" class="cishu" value="1" />

                        开

                        </label>

                        <label class="radio">

                        <input type="radio" name="cishu" class="cishu" value="0" checked />

                        关

                        </label> 
                        <div style="margin-top:5px;"><div>限制用户共参与<input type="number" min="1"  style="width:25px; height: 15px;" name="cishu1"  value=""/>次</div>
                        <div style="margin-top:5px;">限制每个用户每天参与<input type="number" min="1" style="width:35px;height: 15px;" name="cishu2"  value=""/>次</div>
                        <div style="margin-top:5px;">限制活动每天抽奖奖励总数<input type="number" min="1" style="width:35px;height: 15px;" name="cishu3"  value=""/>次</div>

                        </div>

                      </div>
                  </div>
                    
                

                    <label class="control-label">领奖条件</label>
                                        <!-- direction 方向 -->
                    <div class="controls">

                      <label class="radio">

                      <input type="radio" name="condition" class="condition1" value="1" checked/>

                      扫码直接领红包

                      </label>

                      <label class="radio">

                      <input type="radio" name="condition" class="condition2" value="2"  />

                      分享朋友圈领红包

                      </label>  

                      <label class="radio">

                      <input type="radio" name="condition" class="condition3"  value="3" />

                      关注公众号领红包

                      </label> 
                    </div>
                 
                  <script>
                    $('.condition1').click(function(){
                       $('#share').css('display','none');
                       $('#guanzhu').css('display','none');
                    });
                     $('.condition2').click(function(){
                        $('#share').css('display','block');
                        $('#guanzhu').css('display','none');
                    });
                    $('.condition3').click(function(){
                        $('#share').css('display','none');
                        $('#guanzhu').css('display','block');
                    });


                  </script>
                    <div id="guanzhu" style="margin-top: 30px; display: none;">
                        <div class="control-group" >

                          <label class="control-label">授权：</label>

                          <div class="controls">
                          <?php if($auth == 1): ?><button class="btn blue" type="button">已授权</button>
                          <?php else: ?>   
                            <a href="<?php echo ($jump_url); ?>">
                               <button class="btn green" type="button">点击进入授权界面</button>
                            </a><?php endif; ?>
                           

                          </div>
                        </div>
                    </div>
                 <div style="display: none;" id="share">
                  <div class="control-group">

                    <label class="control-label">分享链接</label>

                    <div class="controls">

                      <input type="text" class="span6 m-wrap" style="width:300px;" name="share_link" id="share_link" value=""/>
                     

                    </div>
                  </div>
                  <div class="control-group">

                    <label class="control-label">分享标题</label>

                    <div class="controls">

                      <input type="text" class="span6 m-wrap" style="width:300px;" name="share_title" id="share_title" value=""/>
                     

                    </div>
                  </div>
                  <div class="control-group" style="margin-top:20px;">

                    <label class="control-label">分享图片</label>

                    <div class="controls" style="position: relative;display: inline-block;overflow: hidden;margin-left:19px;margin-top: -5px;height: 34px;">
                    <span style="background: green;color: #fff;padding: 15px 10px;line-height: 35px;cursor: pointer; font-size: 14px;">上传文件</span>
                      <input type="file" class="imgfiles" style="position:absolute;right: 0px;top: 0px;opacity: 0;-ms-filter: 'alpha(opacity=0)';
            font-size: 200px;cursor: pointer;">
                      <input type="hidden" class="imgurl" name="share_picture">
                      
                        <span style="color: blue; margin-left: 20px;">*图片大小最大6M</span>
                    </div>
                     <div class="hidd" style=" margin-left: 180px;">
                       <?php if($typeid == 1): ?><img src="" alt="" class="imgpic" width="300" height="160"><?php endif; ?>
                     </div>
                  </div>

                </div>
                       <div style="margin-top: 50px;">
                           <label class="control-label"><span style="color: red;"></span></label>
                           <div class="" id="" style="height: 100px;">
                              <a href="#qyxz" data-toggle="tab"><button type="button" class="btn green"  id="next3">下一步</button></a>
                              <button type="button" class="btn blue" attr-id="1"  onclick="submit_form(1)">确认保存</button>
                              <button type="button" class="btn red" attr-id="2"  onclick="submit_form(2)">保存草稿</button>
                              <a href="/index.php/Shop/Activity/index"><button type="button" class="btn">取消</button></a>
                           </div>
                         </div> 

                </div><!-- 选项卡</div>    -->
                <script>
                      $('#next3').click(function(){
                        for (var i=0;i<$( "#myTab li" ).length;i++) {
                          $( "#myTab li" ).eq(i).removeClass( "active" );
                        }
                        $( "#myTab li" ).eq(4).addClass( "active" );

                       });

                </script>


             <div class="control-group choos_area tab-pane fade" id="qyxz">
                   <div >

                    <label class="control-label">收集用户信息</label>
                                        <!-- direction 方向 -->
                    <div class="controls">

                      <label class="radio">

                      <input type="radio" name="user_data" class="user_data1" value="0" checked/>

                      否

                      </label>

                      <label class="radio">

                      <input type="radio" name="user_data" class="user_data2" value="1"  />

                      是

                      </label>  
                    </div>
                  </div>
                   <script>
                    $('.user_data1').click(function(){
                       var a = $('.user_content').css('display','none');
                    });
                     $('.user_data2').click(function(){
                       var a = $('.user_content').css('display','block');
                    });
                     
                   </script>
                   <div class="control-group user_content" style="display: none;">

                    <label class="control-label"><!-- <span style="color: red;">*</span>收集的内容 --></label> 

                    <div class="controls">

                      <div class="control-group intp " style=" width:700px;">
                       <button type="button" class="btn blue" id="add_input"  class="" >添加</button>
                      </div>

                    </div>

                  </div>

                  <script>
                      $('#add_input').click(function(){
                      //var a = $('.ad').index(this);
                      var size = "<div class=\"e\" style=\"margin-top:5px;margin-bottom:5px;margin-left:5px; pandding:0px;  \"><span>表单类型：</span><select class=\"span6 m-wrap\" data-placeholder=\"Choose a Category\" tabindex=\"1\" style=\"width:150px;\" name=\"input_type[]\" ><option value=\"1\">--单文本--</option><option value=\"2\">--多行文本--</option><option value=\"3\">--手机号--</option><option value=\"4\">--邮箱--</option><option value=\"5\">--身份证号--</option><option value=\"6\">--QQ号--</option></select><span style=\"margin-left:10px;\">表单名称</span><input type=\"text\" name=\"input_name[]\" style=\"width:100px; margin-left:5px;\" placeholder=\"例如：手机号码\"/> <span style=\"margin-left:10px;\">是否必填：</span><select class=\"\" data-placeholder=\"Choose a Category\" tabindex=\"1\" style=\"width:50px; height:30px;\" name=\"input_status[]\" ><option value=\"0\">否</option><option value=\"1\">是</option></select><a href='javascript:void(0);' class=\"del_int\" style=\"height:30px; line-height:30px; margin-left:10px;\" onclick=\"dele_2()\">删除</a></div>";
                        $(".intp").append(size);
                        $(".intp").css('border','1px dashed #CFCFCF');

                     });
                        function dele_2(){
                              var a = $('.del_int').index(this);
                              $(".e").eq(a).remove();
                          }

                  </script>

               
                

                  <div >

                    <label class="control-label">区域限制:</label>
                                        <!-- direction 方向 -->
                    <div class="controls">

                      <label class="radio">

                      <input type="radio" name="area_status" class="area_status1" value="0" checked/>

                      否

                      </label>

                      <label class="radio">

                      <input type="radio" name="area_status" class="area_status2" value="1"  />

                      是

                      </label>  
                    </div>
                  </div>
                
                   <script>
                    $('.area_status1').click(function(){
                       $('.area_data').css('display','none');
                    });
                     $('.area_status2').click(function(){
                        $('.area_data').css('display','block');
                    });
                     
                   </script>
                 
                  <div class="control-group area_data" style="display: none;">

                    <label class="control-label"><!-- <span style="color: red;">*</span>请选择活动区域 --></label>

                    <div class="controls">

                      <div class="control-group " style=" width:200px;">
                        <input type="text" name="area" placeholder="请选择活动区域" onclick="appendCity(this,'duoxuan')" readonly />
                      </div>

                    </div>
                  </div>
                     <div style="margin-top: 50px;">
                           <label class="control-label"><span style="color: red;"></span></label>
                           <div class="" id="" style="height: 100px;">
                              <button type="button" class="btn blue" attr-id="1"  onclick="submit_form(1)">确认保存</button>
                              <button type="button" class="btn red" attr-id="2"  onclick="submit_form(2)">保存草稿</button>
                              <a href="/index.php/Shop/Activity/index"><button type="button" class="btn">取消</button></a>
                           </div>
                         </div> 
                  </div>  <!-- 4选项卡结束 -->
                    <!-- 6选项卡结束 --> 
                 </div>
                 <input type="hidden" name="activity_type" value="<?php echo ($typeid); ?>">
                </form>

                <!-- END FORM-->

              </div>

            </div>

            <!-- END EXTRAS PORTLET-->

          </div>

        </div>
      <input type="hidden" id="type_id" value="<?php echo ($typeid); ?>">
        <!-- END PAGE CONTENT-->         
    <!--   <div class="form-actions" style="position: fixed;  bottom: 110px; width: 1616px;text-align: center; z-index: 9999;">
                  <button type="button" class="btn blue" attr-id="1"  onclick="submit_form(1)">确认保存</button>
                  <button type="button" class="btn red" attr-id="2"  onclick="submit_form(2)">保存草稿</button>
                  <a href="/index.php/Shop/Activity/index"><button type="button" class="btn">取消</button></a>
                 <button type="button" class="btn red" attr-id="2"  onclick="submit_form()">保存草稿</button>
        </div> -->


       
      </div>
      
      <div id="rjbbbb"></div>
      <!-- END PAGE CONTAINER-->

    </div>

    <!-- END PAGE -->  

  </div>
    <div class="modal-backdrop fade in zhezhao" style="text-align: center; display:none;">
         <h4 style=" color:white; margin-top:400px;">
           <p>温馨提示：活动正在创建中，请耐心等待</p>
           <p>正在创建 loading...</p>
         </h4>
      </div>
  <!-- END CONTAINER -->
   <script>

   jQuery(document).ready(function() {       

       // initiate layout and plugins

       App.init();

       FormComponents.init();

    });
    function submit_form(tpye){
          $(this).attr('disabled',true); 
          $('.zhezhao').css('display','block');
          var data=$('#form').serialize();  
          if(tpye==1){
           var url = '/index.php/Shop/Activity/add_activity';
          }else{
           var url = '/index.php/Shop/Activity/add_caogao';
          }
          var jump_url = '/index.php/Shop/Activity/index';
          $.post(url,data,function(res){
              if (res.status == 1) {
                  $('.zhezhao').css('display','none');
                  dialog.success(res.message,jump_url);
                    //window.location.href=jump_url;
                  } 
               if(res.status == 0){
                 $('.zhezhao').css('display','none');
                  dialog.error(res.message);
                 }

           },'JSON');
    }



   $('.imgfiles').change(function(){
                var a=$('.imgfiles').index(this);
                var imgUrlId='.imgfiles:eq('+a+')';
                var nameId='.imgurl:eq('+a+')';
                var imgpic='.imgpic:eq('+a+')';
                //alert(imgpic);
                var hid='.hidd:eq('+a+')';
                uploadimg(imgUrlId,nameId,imgpic,hid);
            })
//厂家图片上传
            function uploadimg(imgUrlId,nameid,imgpic,hid){  
                 var formData = new FormData();  //实例化上传方法
                 formData.append('file', $(imgUrlId)[0].files[0]); //file相当于 name值
                // alert(formData);
                 //console.log($(imgUrlId)[0].files[0]);return false;
                 var size = $(imgUrlId)[0].files[0].size;
                 var Max_Size=1024*1024;
                 if (size>Max_Size){dialog.error('图片大小不能大于一兆');return false; };

                $.ajax({
                    url: '/index.php/Shop/Activity/upload',//'<?php echo U("Activity/upload");?>',
                    type: 'POST',
                    cache: false,
                    data: formData,
                    dataType: 'text',
                    processData: false,
                    contentType: false,
                    success: function (data) {
                      $(nameid).val(data);
                     // alert(data);
                      $(imgpic).attr("src",data);
                      $(hid).css("display",'block');
                    }
                })
              }; 

/*     function ceshi(){
         var formData = new FormData();
        $.each($('.userpic1')[0].files, function(i, file) {
                formData.append('us('userpic', file)');
        });
        $.ajax({
          url: '<?php echo U("User/ajax_img");?>',
          type: 'POST',
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          success: function(ret) {
            if(ret.r == 'e') {
                    layer.msg(ret(ret.t, function() {});
            } else if(ret.r == '8') {
                    layer.msg('二维('二维码上传成功', {
                icon: 1,
                time: 1000
              });
              
              $('#preview1').attr('src', ret.t);
              $('#img_url1').val( ret.t);
            } else {
                    layer.msg('上传('上传失败', function() {});
            }
          },
          error: function(err) {
                  layer.msg('上传('上传失败', function(){});'

          }
        });

     }*/



    
  </script>


<div class="modal" id="fenpei_box" style="display: none;" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
<!-- ======= -->

         <form class="form-horizontal" id="form_code" action="/index.php/Shop/Activity/add" method="post" enctype="multipart/form-data" >
          <table class="table table-striped table-hover table-bordered" id="sample_editable_1">

                  <thead>
                      <tr>
                      <th colspan="10" style="text-align: center;">分配码段</th>
                      </tr>
                    <tr>
                      <th></th>
                      <th style="text-align: center;">ID</th>
                      <th style="text-align: center;">批号</th>
                      <th style="text-align: center;">码段</th>
                      <th style="text-align: center;">数量</th>
                      <th style="text-align: center;">拆分</th>
                    </tr>

                  </thead>
                                   
                  <tbody class="tbody">
                   <?php if(!empty($code_list)){ ?>
                      <?php if(is_array($code_list)): $i = 0; $__LIST__ = $code_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="">
                        <td style="width:20px;">
                          <input type="checkbox" name="code_num_id[]" value="<?php echo ($vo["id"]); ?>">
                        </td>
                        <td style="text-align: center;"><?php echo ($vo["id"]); ?></td>
                        <td style="text-align: center;"><?php echo ($vo["pici"]); ?></td>
                        <td style="text-align: center; color: blue;"><?php echo ($vo["code_number"]); ?></td>
                        <td style="text-align: center;" class="new_num"><?php echo (code_num($vo["id"])); ?></td>
                        <td style="text-align: center;"> 
                         <button type="button" class="btn green mini cf_c" onclick="cf()" attr-id="<?php echo (code_num($vo["id"])); ?>" data-toggle="modal" href="#chaifen<?php echo ($vo["id"]); ?>">拆分</button>
                        </td>    
                                                            
                      </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                       <?php }else{ ?>
                       <tr>
                          <td style="text-align: center;" colspan="10">暂未分配码段，快去联系代理商吧！</td>
                       </tr>
                      <?php  } ?>
                    <tr>
                     
                     <td colspan="10" style="text-align: center;">
                       <input type="hidden" id="click_shop_id" name="click_shop_id">
                       <button class="btn blue" id="click_fenpei" type="button" onclick="fenpei_code()">确认分配</button>
                       <button class="btn white" id="click_off" type="button" onclick="click_offs()">关闭窗口</button>
                      </td>
                    </tr>
                  </tbody>

                </table>
                <div class="pagination" style="float:right;">
                  <ul><li><?php echo ($code_page); ?></li></ul>
                </div>
        </form>
<!-- ============ -->
        
      </div>
    </div>
  </div>
</div>
<div class="modal-backdrop fade in" id="top_ceng" style="display: none;"></div>
<script>
 /*  function cf(){
   var num = $('.cf_c').eq(a).attr('attr-id');
   alert(num);return false;
    $('#click_chaifen_num').val(num);
    $('#click_chaifen_key').val(a);
  }*/
  function click_offs(){
    $('#fenpei_box').css('display','none');
    $('#top_ceng').css('display','none');
  }
  function fenpei_maduan(){
    $('#fenpei_box').css('display','block');
    $('#top_ceng').css('display','block');

  }

 function fenpei_code(){
//alert(1);
   var data = $('#form_code').serialize();
   //console.log(data);return false;
   /*$(data).each(function(){
              postData[this.name]=this.value;
          });*/
   var url = '/index.php/Shop/Activity/return_code';
    $.post(url,data,function(res){
      //alert(123);
     /* var q = jQuery.parseJSON(res);
      console.log(q);*/
        if(res.status==1){
           $('#fenpei_box').css('display','none');
           $('#top_ceng').css('display','none');
          var zz="";
          for (var i = 0; i < res.datas.length; i++) {
              zz += "<div class=\"c\" style=\"height: 44px; width:500px; border:1px dashed #CFCFCF; text-align:left; padding-left: 10px; line-height: 44px; font-size: 15px;\" >号段：  "+res.datas[i].maduan+"&nbsp;&nbsp;数量："+res.datas[i].num+" 个 <a href='javascript:void(0);' class=\"del_cod\" style=\"height:30px; line-height:30px; margin-left:10px; color:red;\" onclick=\"dele_code()\">删除</a><input type='hidden' name='choose_code_id[]' value='"+res.datas[i].id+"'></div>";
          }
           $('#code_list').append(zz);
           $('#total_box').css('display','block');
           $('#total_code').html(res.shuju);
          
        }else{
           dialog.error(res.message);
        }

     },'JSON');

  };
            function dele_code(){
                  var a = $('.del_cod').index(this);
                  $(".c").eq(a).remove();
              }

</script>

<?php if(is_array($code_list)): $i = 0; $__LIST__ = $code_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="modal fade off_box" id="chaifen<?php echo ($vo["id"]); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
<!-- ======= -->

         <form class="form-horizontal" id="form" action="" method="post" enctype="multipart/form-data">
           <table width="400" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" class="table">
                <tr>
                   <td colspan="2" style="border:1px #ccc solid; line-height:30px; background-color:#eee; text-align: center;" height="20" width="200" align=""><b>拆分码段</b></td>
                 </tr>
                 <tr>
                    <td style="border:1px #ccc solid; line-height:30px;" height="20" width="100" align="center">码段</td>
                    <td style="border:1px #ccc solid;" height="20" width="200" align="center">
                       <?php echo ($vo["code_number"]); ?>
                    </td>
                 </tr>
                  <tr>
                    <td style="border:1px #ccc solid; line-height:30px;" height="20" width="100" align="center">提示</td>
                    <td style="border:1px #ccc solid;" height="20" width="200" align="center">
                       您最多拆成<?php echo (code_num($vo["id"])); ?>组
                    </td>
                 </tr>
                   <tr>
                    <td style="border:1px #ccc solid; line-height:30px;" height="20" width="100" align="center">拆分数量</td>
                    <td style="border:1px #ccc solid;" height="20" width="200" align="center">
                       <input type="text" class="form-control input-sm chai" id="chai" name="chai" style="width:200px; height:30px;"  />
                    </td>
                 </tr>
                  
                  <tr>
                    <td style="border:1px #ccc solid; line-height:30px; text-align: center;" height="20" width="100" align="center" colspan="2">
                    <input type="hidden" class="chaifen_id" value="<?php echo ($vo["id"]); ?>">
                    <input type="hidden" id="click_chaifen_num" value="">
                    <input type="hidden" id="click_chaifen_key" value="">
                    <button class="btn blue kai" type="button" attr-id="<?php echo ($vo["id"]); ?>">确认拆分</button>
                    <button class="btn red " type="button" id="off_q" onclick="clos_v()">关闭窗口</button>
                    </td>
                 </tr>
                
          </table>
        </form>
<!-- ============ -->
        
      </div>
    </div>
  </div>
</div><?php endforeach; endif; else: echo "" ;endif; ?>
<div class="modal-backdrop fade in" id="top_ceng" style="display: none;"></div>

<script type="text/javascript">
function clos_v(){
     $('.off_box').modal('hide');
   };
  function click_chai_code(){
    $('#fenpei_box').css('display','none');
    $('#top_ceng').css('display','none');
  }
  function fenpei_maduan(){
    $('#fenpei_box').css('display','block');
    $('#top_ceng').css('display','block');

  }
  $('.kai').click(function(){
    $('.off_box').modal('hide');
    var yuan_num = $('#click_chaifen_num').val();
    var yuan_key = $('#click_chaifen_key').val();
    var a = $('.kai').index(this);
    var id = $('.kai').eq(a).attr('attr-id');
   // alert(id);
    var chai_num = $('.chai').eq(a).val();
   // alert(chai_num);
    var url = '/index.php/Shop/Activity/chaifen';
    var jump_url = '/index.php/Shop/Activity/add';
    var data = {'id':id,'chai_num':chai_num};
    $.post(url,data,function(res){
        if (res.status == 1) {
              var new_code = '';
              new_code += '<tr>';
              new_code += '<td style=\"width:20px;\">';
              new_code += '<input type=\"checkbox\" name=\"code_num_id[]\" value=\"'+res.datas.id+'\">';
              new_code += '</td>';
              new_code += ' <td style=\"text-align: center;\">'+res.datas.id+'</td>';
              new_code += '<td style=\"text-align: center;\">'+res.datas.pici+'</td>';
              new_code += '<td style=\"text-align: center; color: blue;\">'+res.datas.code_number+'</td>';
              new_code += '<td style=\"text-align: center;\">'+res.datas.count+'</td>';
              new_code += '<td style=\"text-align: center;\"> ';
              new_code += '<button type=\"button\" class=\"btn green mini\" attr-id=\"'+res.datas.id+'\" data-toggle=\"modal\" href=\"#chaifen'+res.datas.id+'\">拆分</button>';
              new_code += '</td>';
              new_code += '</tr>';
             $('.tbody').prepend(new_code);
             $('.off_box').modal('hide');
             $('.new_num').eq(a).html(res.datas.yuan_count);
            } 
         if(res.status == 0){
            dialog.error(res.message);
        }

     },'JSON');
  });


</script>
  <!-- BEGIN FOOTER -->                                       
                      
	<div class="footer" style="height:30px; background-color:#ccc;">

		<div class="footer-inner" style="color:#000;">

			2017 &copy; Metronic by keenthemes.

		</div>

		<div class="footer-tools" style="height:30px;">

			<span class="go-top">
            <span style="color:#fff;">顶部</span> 
			<i class="icon-angle-up"></i>

			</span>

		</div>

	</div>
  
  <script type="text/javascript">
  $(function() {

    // 单选
    var singleSelect1 = $('#single-select-1').citySelect({
      dataJson: cityData,
      multiSelect: true,//开启多选功能
      whole: true, //市级数据
      shorthand: true,
      search: true,//搜索功能
      multiMaximum: 10,//设置最多可选择的个数
      onInit: function () {
        console.log(this)
      },
      onTabsAfter: function (target) {
        console.log(target)
      },
      onCallerAfter: function (target, values) {
        console.log(JSON.stringify(values))
      }
    });

    // 单选设置城市
    singleSelect1.setCityVal('北京市');

    // 单选
    var singleSelect2 = $('#single-select-2').citySelect({
      dataJson: cityData
    });

    // 单选设置城市
    singleSelect2.setCityVal('北京市');

    // 禁止点击显示的接口
    singleSelect2.status('readonly');

    //单选
    var singleSelect3 = $('#single-select-3').citySelect({
      dataJson: cityData
    });

    // 单选设置城市
    singleSelect3.setCityVal('广州市');

    // 禁止点击显示的接口
    singleSelect3.status('disabled');

    // 多选
    var MulticitySelect1 = $('#multi-select-1').citySelect({
      dataJson: cityData,
      multiSelect: true,
      multiMaximum: 6,
      search: false,
      onInit: function () {
        console.log(this)
      },
      onForbid: function () {
        console.log(this)
      },
      onTabsAfter: function (target) {
        console.log(event)
      },
      onCallerAfter: function (target, values) {
        console.log(JSON.stringify(values))
      }
    });

    // 多选设置城市接口
    MulticitySelect1.setCityVal('北京市, 天津市, 上海市, 广州市, 长沙市, 唐山市');

    // 多选-自定义热门城市-搜索
    var MulticitySelect2 = $('#multi-select-2').citySelect({
      dataJson: cityData,
      multiSelect: true,
      search: true,
      multiType: 1,
      hotCity: ['北京市', '上海市', '广州市', '深圳市', '南京市', '杭州市', '天津市', '重庆市', '成都市', '青岛市', '苏州市', '无锡市', '常州市', '温州市', '武汉市', '长沙市', '石家庄市', '南昌市', '三亚市', '合肥市'],
      onInit: function () {
        console.log(this)
      },
      onForbid: function () {
        console.log(this)
      },
      onTabsAfter: function (target) {
        console.log(event)
      },
      onCallerAfter: function (target, values) {
        console.log(JSON.stringify(values))
      }
    });

    // 多选设置城市接口
    MulticitySelect2.setCityVal('北京市, 天津市, 上海市, 广州市, 长沙市, 唐山市');

  });
  </script>
  <!-- END FOOTER -->

  <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

  <!-- BEGIN CORE PLUGINS -->
  <script src="/Public/media/js/jquery-1.10.1.min.js" type="text/javascript"></script>

  <script src="/Public/media/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>

  <!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->

  <script src="/Public/media/js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>      

  <script src="/Public/media/js/bootstrap.min.js" type="text/javascript"></script>

  <!--[if lt IE 9]>

  <script src="/Public/media/js/excanvas.min.js"></script>

  <script src="/Public/media/js/respond.min.js"></script>  

  <![endif]-->   

  <script src="/Public/media/js/jquery.slimscroll.min.js" type="text/javascript"></script>

  <script src="/Public/media/js/jquery.blockui.min.js" type="text/javascript"></script>  

  <script src="/Public/media/js/jquery.cookie.min.js" type="text/javascript"></script>

  <script src="/Public/media/js/jquery.uniform.min.js" type="text/javascript" ></script>

  <!-- END CORE PLUGINS -->

  <!-- BEGIN PAGE LEVEL PLUGINS -->

  <script type="text/javascript" src="/Public/media/js/select2.min.js"></script>

  

  <script type="text/javascript" src="/Public/media/js/DT_bootstrap.js"></script>

  <!-- END PAGE LEVEL PLUGINS -->

  <!-- BEGIN PAGE LEVEL SCRIPTS -->

  <script src="/Public/media/js/app.js"></script>

  <script src="/Public/media/js/table-editable.js"></script>    


  <!-- END PAGE LEVEL SCRIPTS -->

 

  <!-- END JAVASCRIPTS -->   

</body>

<!-- END BODY -->

</html>