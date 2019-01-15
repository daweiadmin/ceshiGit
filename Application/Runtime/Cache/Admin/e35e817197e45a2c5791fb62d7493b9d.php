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

	<title>来客二维码红包系统-总后台</title>

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
.btn.reds{
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

<body class="page-header-fixed">
	<div class="header navbar navbar-inverse navbar-fixed-top">

		<!-- BEGIN TOP NAVIGATION BAR -->

		<div class="navbar-inner">

			<div class="container-fluid">

				<!-- BEGIN LOGO -->

				<a class="brand" href="javascript:(0);">

				 <span>来客二维码红包系统</span>

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
                    <?php $user = session('true_name'); ?>
					<!-- BEGIN USER LOGIN DROPDOWN -->
               
					<li class="dropdown user">
					 <button type="button" class="btn yellow" style=" color:white; margin-top:22px";> < 总平台 > </button> 

						<a href="javascript:viod(0);" class="dropdown-toggle" data-toggle="dropdown">

						 <div type="button" class="btn red reds" id="submit">设置</div>

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

							<li><a href="/index.php/Admin/login/logout"><i class="icon-key"></i>退出</a></li>

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

  <!-- BEGIN CONTAINER -->

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

				<li class="start active ">

					<a href="/index.php/Admin/index/index">

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
                     <!--   <li >
                     
                     							<a href="/index.php/Admin/activity/index">
                            <i class="icon-user"></i> 
                     							活动列表
                     							</a>
                     
                     						</li> -->
						
						<li >
                            <a href="/index.php/Admin/activity/index">
                              <i class="icon-user"></i> 
							活动列表
							</a>
							<a href="/index.php/Admin/activity/activity_shenhe">
                              <i class="icon-user"></i> 
							活动审核
							</a>


						</li>
					</ul>

				  </li>

                	<li class="">

					<a href="javascript:;">

					<i class="icon-male"></i> 

					<span class="title">代理 / 商户管理</span>

					<span class="arrow "></span>

					</a>

					<ul class="sub-menu">
                       <li >

							<a href="/index.php/Admin/shop/daili_index">
                              <i class="icon-user"></i> 
							代理列表
							</a>

						</li>
						
						<li >

							<a href="/index.php/Admin/shop/store">
                              <i class="icon-user"></i> 
							商户列表
							</a>

						</li>
						<li >

							<a href="/index.php/Admin/shop/check_index">
                              <i class="icon-user"></i> 
							代理 / 商户审核
							</a>

						</li>
					</ul>

				</li>
				  <li>

					<a class="active" href="javascript:;">

					<i class="icon-gift"></i> 

					<span class="title">码段管理</span>

					<span class="arrow "></span>

					</a>

					<ul class="sub-menu">
                         <li>

							<a href="/index.php/Admin/code/index">
                            <i class="icon-gift"></i> 
							码段列表

							</a>
							<a href="/index.php/Admin/activity/record">
                            <i class="icon-gift"></i> 
							充值记录

							</a>

						</li>

					</ul>

				</li>
			
				
		
					<li>

					<a class="active" href="javascript:;">

					<i class="icon-cogs"></i> 

					<span class="title">系统设置</span>

					<span class="arrow "></span>

					</a>

					<ul class="sub-menu">

						<li>

							<a href="/index.php/Admin/user/bian">

							密码变更

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
                  <?php if($shop['type']==1){ ?>
                   <div class="control-group" style="">
                    <label class="control-label">账户类型</label>
                    <div class="controls">
                      <select class="span6 m-wrap" data-placeholder="Choose a Category" tabindex="1" style="width:150px;" name="type" id="type">
                       <option value="0">--请选择类型--</option>
                       <option value="2">--市级代理--</option>
                       <option value="3">--商户--</option>
                      </select>
                    </div>
                   </div>
                   <?php  }else{ ?>
                    <input type="hidden" name="type" id="type" value="3">
                   <?php  } ?>
                  <input type="hidden" id="type_now" name="type_now" value="<?php echo ($shop["type"]); ?>">
                  <div class="control-group">

                    <label class="control-label"><span style="color: red;">*</span>登录账户</label>

                    <div class="controls">

                      <input type="text" class="span6 m-wrap" style="width:300px;" name="username" id="username" value=""/>
                     

                    </div>

                  </div>
                   <div class="control-group">

                    <label class="control-label"><span style="color: red;">*</span>登录密码</label>

                    <div class="controls">

                      <input type="password" class="span6 m-wrap" style="width:300px;" name="password" id="password" placeholder="不能少于6位" value=""/>
                     

                    </div>

                  </div>
                    <div class="control-group">

                    <label class="control-label"><span style="color: red;">*</span>确认密码</label>

                    <div class="controls">

                      <input type="password" class="span6 m-wrap" style="width:300px;" name="password2" id="password2" placeholder="请再输入一次密码" value=""/>
                     

                    </div>

                  </div>
                  <script>
                    $('#password2').change(function(){
                      var p1 = $('#password').val();
                      var p2 = $('#password2').val();
                      if(p1!==p2){
                        dialog.error('两次密码输入不一致，请重新输入');return false;
                      }

                    });

                  </script>
                  <div class="control-group">

                    <label class="control-label"><span style="color: red;">*</span>活动名称</label>

                    <div class="controls">

                      <input type="text" class="span6 m-wrap" style="width:300px;" name="name" id="name" value=""/>
                     

                    </div>

                  </div>
                  <div class="control-group">

                    <label class="control-label"><span style="color: red;">*</span>联系人</label>

                    <div class="controls">

                      <input type="text" class="span6 m-wrap" style="width:300px;" name="link_man" id="link_man" value=""/>
                     

                    </div>

                  </div>
                 <div class="control-group">

                    <label class="control-label"><span style="color: red;">*</span>联系电话</label>

                    <div class="controls">

                      <input type="text" class="span6 m-wrap" style="width:300px;" name="phone" id="phone" value=""/>
                     

                    </div>

                  </div>
                   <div class="control-group">

                    <label class="control-label">邮箱</label>

                    <div class="controls">

                      <input type="text" class="span6 m-wrap" style="width:300px;" name="email" id="email" value=""/>
                      

                    </div>

                  </div>

                  <div class="control-group">

                    <label class="control-label">地址</label>

                    <div class="controls">

                      <input type="text" class="span6 m-wrap" style="width:300px;" name="address" id="address" value=""/>
                      

                    </div>

                  </div>
                  <div class="control-group" style="margin-top:20px;">

                    <label class="control-label">logo</label>

                    <div class="controls">
                      <input type="file" class="imgfiles">
                      <input type="hidden" class="imgurl" name="picture">
                       <div class="hidd" style="display:none;">
                        <img src="" alt="" class="imgpic" width="70" height="70">
                       </div>
                        <span style="color: blue;">*该logo图片将在活动页进行显示，图片大小最大2M</span>
                    </div>
                    
                  </div>
                   <div class="control-group">

                    <label class="control-label"><span style="color: red;">*</span>有效期</label>

                    <div class="controls">

                      <input type="date" class="span6 m-wrap" style="width:300px;" name="end_time" id="end_time" value=""/>
                      <span style="color: red;">*选择商户账号的最后有效日期，超过有效日期商户则不能正常登陆系统</span>

                    </div>

                  </div>
                

                  <div class="form-actions">
                    <button type="button" class="btn blue"  onclick="submit_form()">确认添加</button>
                     
                    <a href="/index.php/Admin/Activity/index"><button type="button" class="btn">返回</button></a>

                  </div>
                </div>
                </form>

                <!-- END FORM-->

              </div>

            </div>

            <!-- END EXTRAS PORTLET-->

          </div>

        </div>

        <!-- END PAGE CONTENT-->         

      </div>

      <!-- END PAGE CONTAINER-->

    </div>

    <!-- END PAGE -->  

  </div>
  <!-- END CONTAINER -->
   <script>

   jQuery(document).ready(function() {       

       // initiate layout and plugins

       App.init();

       FormComponents.init();

    });
    function submit_form(){
           
          var data=$('#form').serializeArray();  
          var postData={};
          $(data).each(function(){
              postData[this.name]=this.value;
          });
          var typ = $('#type_now').val();
          if(typ==2){
            if(postData['type']==0){
             dialog.error('请选择类型');return false;
            }            
          }
          if(!postData['username']){
           dialog.error('用户名不能为空');return false;
          }
          if(!postData['password']){
           dialog.error('密码不能为空');return false;
          }
            var reg = /^.{6,}$/;
            if(!reg.test(postData['password'])){
             dialog.error('密码不能少于6位');return false;
           }
           if(postData['password']!==postData['password2']){
             dialog.error('两次密码输入不一致');return false;
            }
          if(!postData['name']){
           dialog.error('名称不能为空');return false;
          }
          if(!postData['link_man']){
           dialog.error('联系人不能为空');return false;
          }
          if(!postData['phone']){
           dialog.error('联系方式不能为空');return false;
          }
           var partten = /^1[3,5,7,8,9]\d{9}$/;
            if(!partten.test(postData['phone'])){
              dialog.error('请输入正确的手机号码');return false;
            }
          if(!postData['end_time']){
           dialog.error('有效日期不能为空');return false;
          }
          var url = '/index.php/Admin/Activity/add_daili';
          
          if(postData['type']==3){
            var jump_url = '/index.php/Admin/Activity/store';
          }else{
            var jump_url = '/index.php/Admin/Activity/daili_index';
          }
          $.post(url,postData,function(res){
              if (res.status == 1) {
                  dialog.success(res.message,jump_url);
                    //window.location.href=jump_url;
                  } 
               if(res.status == 0){
                  dialog.error(res.message);
                 }

           },'JSON');
    }
/*   $('#submit').click(function(){
     var url = '/index.php/Admin/Activity/add_daili';
     var jump_url = '/index.php/Admin/Activity/daili_index';
     var data=$('#form').serializeArray();  
      var postData={};
      $(data).each(function(){
          postData[this.name]=this.value;
      });
      if(postData['type']==0){
       dialog.error('请选择类型');return false;
      }
      if(postData['type']>1){
         if(!postData['parentid']){
           dialog.error('请选择上级代理');return false;
          }
      }
      if(!postData['username']){
     dialog.error('用户名不能为空');return false;
    }
      if(!postData['password']){
     dialog.error('密码不能为空');return false;
    }
      var reg = /^.{6,}$/;
      if(!reg.test(postData['password'])){
       dialog.error('密码不能少于6位');return false;
     }
     if(postData['password']!==postData['password2']){
       dialog.error('两次密码输入不一致');return false;
      }
    if(!postData['name']){
     dialog.error('名称不能为空');return false;
    }
    if(!postData['link_man']){
     dialog.error('联系人不能为空');return false;
    }
    if(!postData['phone']){
     dialog.error('联系方式不能为空');return false;
    }
     var partten = /^1[3,5,7,8,9]\d{9}$/;
      if(!partten.test(postData['phone'])){
        dialog.error('请输入正确的手机号码');return false;
      }
    if(!postData['end_time']){
     dialog.error('有效日期不能为空');return false;
    }
    $.post(url,postData,function(res){
        if (res.status == 1) {
            dialog.success(res.message,jump_url);
              //window.location.href=jump_url;
            } 
         if(res.status == 0){
            dialog.error(res.message);
           }

     },'JSON');

    })*/



   $('.imgfiles').change(function(){
                var a=$('.imgfiles').index(this);
                var imgUrlId='.imgfiles:eq('+a+')';
                var nameId='.imgurl:eq('+a+')';
                var imgpic='.imgpic:eq('+a+')';
                var hid='.hidd:eq('+a+')';
                uploadimg(imgUrlId,nameId,imgpic,hid);
            })
//厂家图片上传
            function uploadimg(imgUrlId,nameid,imgpic,hid){  
                 var formData = new FormData();  //实例化上传方法
                 formData.append('file', $(imgUrlId)[0].files[0]); //file相当于 name值

                 var size = $(imgUrlId)[0].files[0].size;
                 var Max_Size=1024*1024;
                 if (size>Max_Size){dialog.error('图片大小不能大于一兆');return false; };

                $.ajax({
                    url: "/index.php/Admin/product/upload",
                    type: 'POST',
                    cache: false,
                    data: formData,
                    dataType: 'text',
                    processData: false,
                    contentType: false,
                    success: function (data) {
                      $(nameid).val(data);
                      $(imgpic).attr("src",data);
                      $(hid).css("display",'block');
                    }
                })
              }; 
    
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

  <!-- END FOOTER -->

  <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

  <!-- BEGIN CORE PLUGINS -->
  <script src="/Public/media/js/jquery-1.10.1.min.js" type="text/javascript"></script>

  <script src="/Public/media/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>

  <!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->

  <script src="/Public/media/js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>      

  <script src="/Public/media/js/bootstrap.min.js" type="text/javascript"></script>

  

  <script src="/Public/media/js/jquery.slimscroll.min.js" type="text/javascript"></script>

  <script src="/Public/media/js/jquery.blockui.min.js" type="text/javascript"></script>  

  <script src="/Public/media/js/jquery.cookie.min.js" type="text/javascript"></script>

  <script src="/Public/media/js/jquery.uniform.min.js" type="text/javascript" ></script>

  <!-- END CORE PLUGINS -->

  <!-- BEGIN PAGE LEVEL PLUGINS -->

  <script type="text/javascript" src="/Public/media/js/ckeditor.js"></script>  

  <script type="text/javascript" src="/Public/media/js/bootstrap-fileupload.js"></script>

  <script type="text/javascript" src="/Public/media/js/chosen.jquery.min.js"></script>

  <script type="text/javascript" src="/Public/media/js/select2.min.js"></script>

  <script type="text/javascript" src="/Public/media/js/wysihtml5-0.3.0.js"></script> 

  <script type="text/javascript" src="/Public/media/js/bootstrap-wysihtml5.js"></script>

  <script type="text/javascript" src="/Public/media/js/jquery.tagsinput.min.js"></script>

  <script type="text/javascript" src="/Public/media/js/jquery.toggle.buttons.js"></script>

  <script type="text/javascript" src="/Public/media/js/bootstrap-datepicker.js"></script>

  <script type="text/javascript" src="/Public/media/js/bootstrap-datetimepicker.js"></script>

  <script type="text/javascript" src="/Public/media/js/clockface.js"></script>

  <script type="text/javascript" src="/Public/media/js/date.js"></script>

  <script type="text/javascript" src="/Public/media/js/daterangepicker.js"></script> 

  <script type="text/javascript" src="/Public/media/js/bootstrap-colorpicker.js"></script>  

  <script type="text/javascript" src="/Public/media/js/bootstrap-timepicker.js"></script>

  <script type="text/javascript" src="/Public/media/js/jquery.inputmask.bundle.min.js"></script>   

  <script type="text/javascript" src="/Public/media/js/jquery.input-ip-address-control-1.0.min.js"></script>

  <script type="text/javascript" src="/Public/media/js/jquery.multi-select.js"></script>   

  <script src="/Public/media/js/bootstrap-modal.js" type="text/javascript" ></script>

  <script src="/Public/media/js/bootstrap-modalmanager.js" type="text/javascript" ></script> 

  <!-- END PAGE LEVEL PLUGINS -->

  <!-- BEGIN PAGE LEVEL SCRIPTS -->

  <script src="/Public/media/js/app.js"></script>

  <script src="/Public/media/js/form-components.js"></script>     

  <!-- END PAGE LEVEL SCRIPTS -->

 

  <!-- END JAVASCRIPTS -->   

</body>

<!-- END BODY -->

</html>