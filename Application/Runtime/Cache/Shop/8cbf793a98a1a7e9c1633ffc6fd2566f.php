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
<?php  $shop['id'] = session('shopUser.id'); $find = D('shop')->where($shop)->field('id,type,name,end_time')->find(); $dali_id = session('shopUser.top_daili_id'); ?>	<?php ?>
<body class="page-header-fixed">
	<div class="header navbar navbar-inverse navbar-fixed-top">

		<!-- BEGIN TOP NAVIGATION BAR -->

		<div class="navbar-inner">

			<div class="container-fluid">

				<!-- BEGIN LOGO -->
                
				<a class="brand" href="javascript:(0);">
                  <?php if($find['type']==3){ ?>
				     <span><?php echo ($find["name"]); ?>--商户后台</span>
                  <?php }else{ ?>
                     <span><?php echo ($find["name"]); ?>--代理后台</span>
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
					
                      <?php if($find['type']==1){ ?>
					     <button type="button" class="btn blue" style=" color:white; margin-top:22px";> < 省级代理 > </button> 
	                  <?php } ?>

	                  <?php if($find['type']==2){ ?>
	                     <button type="button" class="btn yellow" style=" color:white; margin-top:22px";> < 市级代理 > </button> 
	                  <?php } ?>
	                  <?php if($find['type']==3){ ?>
                       <?php if($dali_id){ ?>
	                   <a href="/index.php/Shop/shop/return_daili?daili_id=<?php echo ($dali_id); ?>" style="display: inline-block;">
	                     <button type="button" class="btn yellow" style=" color:white; margin-top:22px";> << 返回代理平台  </button> 
	                     </a>
	                     <?php } ?>

	                  <?php } ?>
	                  <button type="button" class="btn blue" style=" color:white; margin-top:22px";> 有效期至：<?php echo (date("Y-m-d",$find["end_time"])); ?> </button> 
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

  <!-- BEGIN CONTAINER -->

  <div class="page-container row-fluid">

    <!-- BEGIN SIDEBAR   MENU-->

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

               <?php  $data['id'] = session('shopUser.id'); $shop = D('shop')->where($data)->field('id,type')->find(); ?>	
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

              <?php if($shop['type']!==3){ ?>
                <li class="">

					<a href="javascript:;">

					<i class="icon-male"></i> 

					<span class="title">代理 / 商户管理</span>

					<span class="arrow "></span>

					</a>

					<ul class="sub-menu">
                     <?php if($shop['type']==1){ ?>
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

            <!-- BEGIN PAGE TITLE & BREADCRUMB-->

            <h3 class="page-title">

              奖券管理 <small></small>

            </h3>

            <ul class="breadcrumb">


              <li>

                <a href="#">奖券管理</a>

                <i class="icon-angle-right"></i>

              </li>

              <li><a href="#">奖券列表</a></li>

            </ul>

            <!-- END PAGE TITLE & BREADCRUMB-->

          </div>

        </div>

        <!-- END PAGE HEADER-->

        <!-- BEGIN PAGE CONTENT-->

        <div class="row-fluid">

          <div class="span12">

            <!-- BEGIN EXAMPLE TABLE PORTLET-->

            <div class="portlet box blue">

              <div class="portlet-title">

                <div class="caption"><i class="icon-edit"></i>奖券列表</div>

                <div class="tools">

                  <a href="javascript:;" class="collapse"></a>

                  <a href="#portlet-config" data-toggle="modal" class="config"></a>

                  <a href="javascript:;" class="reload"></a>

                  <a href="javascript:;" class="remove"></a>

                </div>

              </div>

              <div class="portlet-body">

                <div class="clearfix" style="height: 50px;">

                  <div class="btn-group">
                     <a href="/index.php/Shop/Ticket/add"><button type="button" class="btn blue ">新增奖券</button> </a>

                     <form class="sidebar-search" style="display:inline-block; float:right; margin-left:10px; " method="get" action="/index.php/Shop/Ticket/index">

                       <input type="text" placeholder="奖券名称" name="key" style="width:200px; display:inline-block; height:24px;"/>
                       <button type="submit"  class="btn green" style=" display:inline-block; float:right;">
                       <i class="icon-search"></i>
                             搜索
                        </button>
                      
                  </form>
                  </div>

                </div>

                <table class="table table-striped table-hover table-bordered" id="sample_editable_1">

                  <thead>

                    <tr>
                      <th></th>
                      <th style="text-align: center;">序号</th>
                      <th style="text-align: center;">兑换券名称</th>
                      <th style="text-align: center;">奖励图片</th>
                      <th style="text-align: center;">兑换内容</th>
                      <th style="text-align: center;">兑换有效期</th>
                      <th style="text-align: center;">创建时间</th>
                      <th style="text-align: center;">状态</th>
                      <th style="text-align: center;">外部链接</th>
                      <th style="text-align: center;">操作</th>
                    </tr>

                  </thead>
                                   
                  <tbody>
                      <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="">
                        <td style="width:20px;"><input type="checkbox" name="goodsid" value="<?php echo ($vo[id]); ?>" class="selall"></td>
                        <td style="text-align: center;"><?php echo ($vo["id"]); ?></td>
                        <td style="text-align: center;"><?php echo ($vo["name"]); ?></td>
                        <td style="text-align: center;">
                          <?php if($vo[ticket_picture] != ''): ?><img src="<?php echo ($vo["ticket_picture"]); ?>" width="50" height="20">
                          <?php else: ?>
                           <span style="color: red;">暂未上传</span><?php endif; ?>
                        </td>
                        <td style="text-align: center;"><?php echo ($vo["content"]); ?></td>
                        <td style="text-align: center;"><?php echo (date("y-m-d H:i",$vo["start_time"])); ?>~<?php echo (date("y-m-d H:i",$vo["end_time"])); ?></td>
                        <td style="text-align: center;"><?php echo (date("y-m-d H:i",$vo["time"])); ?></td>
                        <td style="text-align: center;"><?php echo ($vo["status"]); ?></td>
                        <td style="text-align: center;"><?php echo ($vo["link"]); ?></td>                       
                        <td style="text-align: center;">
                           <button type="button" class="btn green mini" attr-id="<?php echo ($vo["id"]); ?>" data-toggle="modal" href="#level<?php echo ($vo["id"]); ?>">统计数据</button>
                           <a href="/index.php/Shop/Ticket/dui_edit?dui_ticket_id=<?php echo ($vo["id"]); ?>"><button type="button" class="btn blue mini">修改</button></a>
                           <button type="button" class="btn red mini del" attr-id="<?php echo ($vo["id"]); ?>">删除</button>
                        </td>
                                                            
                      </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    
                  </tbody>

                </table>
                <div class="pagination" style="float:right;">
                  <ul><li><?php echo ($page); ?></li></ul>
                </div>
              </div>

            </div>

            <!-- END EXAMPLE TABLE PORTLET-->

          </div>

        </div>
      <script type="">
         //申请不通过按钮点击事件
      $('.jujue').click(function(){
       var a = $('.jujue').index(this);
       var val = $('.jujue').eq(a).attr('attr-val');
       dialog.error(val);
      });

    $('.suo').click(function(){
     var a = $('.suo').index(this);
     var id = $('.suo').eq(a).attr('attr-id');
     var url = "/index.php/Shop/Ticket/suo";
     var jump_url = "/index.php/Shop/Ticket/daili_index";
     var data = {'id':id};
     $.post(url,data,function(result){
      if(result.status==1){
            dialog.success(result.message,jump_url);
        }
        if(result.status==0){
            dialog.error(result.message);
        }

     },'JSON');

    });

    $('.jie').click(function(){
     var a = $('.jie').index(this);
     var id = $('.jie').eq(a).attr('attr-id');
     var url = "/index.php/Shop/Ticket/jie";
     var jump_url = "/index.php/Shop/Ticket/daili_index";
     var data = {'id':id};
     $.post(url,data,function(result){
      if(result.status==1){
            dialog.success(result.message,jump_url);
        }
        if(result.status==0){
            dialog.error(result.message);
        }

     },'JSON');

    });

 
  $('.change_pwd').click(function(){
     var a = $('.change_pwd').index(this);
     var id = $('.change_pwd').eq(a).attr('attr-id');
     //alert(id);
     var url = '/index.php/Shop/Ticket/change';
     var jump_url = '/index.php/Shop/Ticket/daili_index';
     var data={'id':id}
     layer.open({
        type:0,
        title:'重置',
        btn:['确认重置','我再想想'], 
        icon:3,
        closeBtn:2,
        content: '是否真的要重置该账号的密码？',
        scrollbar:true,
        yes:function () {
         $.post(url,data,function(res){
         if(res.status==1){
            dialog.success(res.message,jump_url);
         }
         if(res.status==0){
            dialog.error(res.message);
         }

       },'JSON');
 
        },
    });
     
    });

  </script>
        <!-- END PAGE CONTENT -->


      </div>

      <!-- END PAGE CONTAINER-->

    </div>

    <!-- END PAGE -->

  </div>
  <!--=================================-分配码段===========================-->
       
<div class="modal fade" id="fenpei" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
<!-- ======= -->

         <form class="form-horizontal" id="form_fenpei" action="" method="post" enctype="multipart/form-data">
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
                      <th style="text-align: center;">生成时间</th>
                    </tr>

                  </thead>
                                   
                  <tbody>
                   <?php if(!empty($code_list)){ ?>
                      <?php if(is_array($code_list)): $i = 0; $__LIST__ = $code_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="">
                        <td style="width:20px;">
                          <input type="checkbox" name="code_num_id[]" value="<?php echo ($vo["id"]); ?>">
                        </td>
                        <td style="text-align: center;"><?php echo ($vo["id"]); ?></td>
                        <td style="text-align: center;"><?php echo ($vo["pici"]); ?></td>
                        <td style="text-align: center; color: blue;"><?php echo ($vo["code_number"]); ?></td>
                        <td style="text-align: center;"><?php echo (code_num($vo["id"])); ?></td>
                        <td style="text-align: center;"><?php echo (date("y-m-d H:i",$vo["time"])); ?></td>    
                                                            
                      </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                       <?php }else{ ?>
                       <tr>
                          <td style="text-align: center;" colspan="10">暂未分配码段，快去联系奖券商吧！</td>
                       </tr>
                      <?php  } ?>
                    <tr>
                     
                     <td colspan="10" style="text-align: center;">
                       <input type="hidden" id="click_shop_id" name="click_shop_id">
                       <button class="btn blue" id="click_fenpei" type="button">确认分配</button>
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


<script>
      $('.click_shop').click(function(){
       var a = $('.click_shop').index(this);
       var id = $('.click_shop').eq(a).attr('attr-id');
       $('#click_shop_id').val(id);

      });

    $('#click_fenpei').click(function(){
     var data=$('#form_fenpei').serialize(); 
     var url = "/index.php/Shop/Ticket/fenpei";
     var jump_url = "/index.php/Shop/Ticket/daili_index";
     $.post(url,data,function(result){
        
       if(result.status==1){
            dialog.success(result.message,jump_url);
        }
        if(result.status==0){
            dialog.error(result.message);
        }

     },'JSON');

    });

</script>
        <!--=================================-模态框===========================-->
 <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="modal fade" id="level<?php echo ($vo["id"]); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">

         <form class="form-horizontal" id="form" action="" method="post" enctype="multipart/form-data">
         <table width="400" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" class="table">
                <tr>
                   <td colspan="2" style="border:1px #ccc solid; line-height:30px; background-color:#eee; text-align: center;" height="20" width="200" align=""><b>兑换券数据统计</b></td>
                 </tr>
                 <tr>
                    <td style="border:1px #ccc solid; line-height:30px; text-align: center;" height="20" width="100" align="center">
                    已发放总个数：4个<br>
                    已核销总个数：1个<br>
                    未核销总个数：3个<br>
                    </td>
                 </tr>
                   
         </table>
        </form>
        
      </div>
    </div>
  </div>
</div><?php endforeach; endif; else: echo "" ;endif; ?> 
<script type="text/javascript">
  $('.edit').click(function(){
    var a = $('.edit').index(this);
    var id = $('.edit').eq(a).attr('attr-id');
    var level = $('.lev').eq(a).val();
    var url = '/index.php/Shop/Ticket/edit_level_save';
    var jump_url = '/index.php/Shop/Ticket/daili_index';
    var data = {'id':id,'level':level};
    $.post(url,data,function(res){
        if (res.status == 1) {
            dialog.success(res.message,jump_url);
              //window.location.href=jump_url;
            } 
         if(res.status == 0){
            dialog.error(res.message);
        }

     },'JSON');
  });


</script>
<!--=================================-统计数据===========================-->
<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="modal fade" id="sum<?php echo ($vo["id"]); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
<!-- ======= -->

         <form class="form-horizontal" id="form" action="" method="post" enctype="multipart/form-data">
         <table width="400" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" class="table">
                <tr>
                   <td colspan="2" style="border:1px #ccc solid; line-height:30px; background-color:#eee; text-align: center;" height="20" width="200" align=""><b>名下奖券数量信息</b></td>
                 </tr>
                 <tr>
                    <td style="border:1px #ccc solid; line-height:30px;" height="20" width="100" align="center">直招奖券人数</td>
                    <td style="border:1px #ccc solid;" height="20" width="200" align="center">
                       <span class="q">100</span> 人
                    </td>
                 </tr>
                   <tr>
                    <td style="border:1px #ccc solid; line-height:30px;" height="20" width="100" align="center">直卖VIP人数</td>
                    <td style="border:1px #ccc solid;" height="20" width="200" align="center">
                       <span class="q"></span> 人
                    </td>
                 </tr>
                   <tr>
                    <td style="border:1px #ccc solid; line-height:30px;" height="20" width="100" align="center">奖券团队人数</td>
                    <td style="border:1px #ccc solid;" height="20" width="200" align="center">
                       <span class="q"></span> 人
                    </td>
                 </tr>
                   <tr>
                    <td style="border:1px #ccc solid; line-height:30px;" height="20" width="100" align="center">VIP总人数</td>
                    <td style="border:1px #ccc solid;" height="20" width="200" align="center">
                       <span class="q"></span> 人
                    </td>
                 </tr>
              
             
         </table>
        </form>
<!-- ============ -->
        
      </div>
    </div>
  </div>
</div><?php endforeach; endif; else: echo "" ;endif; ?>
<script type="text/javascript">
/*  $('.edit').click(function(){
    var a = $('.edit').index(this);
    var id = $('.edit').eq(a).attr('attr-id');
    var level = $('.lev').eq(a).val();
    var url = '/index.php/Shop/Ticket/edit_level_save';
    var jump_url = '/index.php/Shop/Ticket/daili_index';
    var data = {'id':id,'level':level};
    $.post(url,data,function(res){
        if (res.status == 1) {
            dialog.success(res.message,jump_url);
              //window.location.href=jump_url;
            } 
         if(res.status == 0){
            dialog.error(res.message);
        }

     },'JSON');
  });*/


</script>

  <!-- END CONTAINER -->

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

  <script>

    jQuery(document).ready(function() {       

       App.init();

       TableEditable.init();

    });

/*   $('#add').click(function(){
     var quname = $('#quname').val();
     var pid = $('#pid').val();
     var url = '/index.php/Shop/Ticket/add';
     var jump_url = '/index.php/Shop/Ticket/index';
     var data={'pid':pid,'name':quname}
       $.post(url,data,function(res){
         if(res.status==1){
            dialog.success(res.message,jump_url);
         }
         if(res.status==0){
            dialog.error(res.message);
         }

       },'JSON');

   })*/
  $('.del').click(function(){
     var a = $('.del').index(this);
     var id = $('.del').eq(a).attr('attr-id');
     //alert(id);
     var url = '/index.php/Shop/Ticket/del';
     var jump_url = '/index.php/Shop/Ticket/index';
     var data={'id':id}
     layer.open({
        type:0,
        title:'删除',
        btn:['yes','no'], 
        icon:3,
        closeBtn:2,
        content: '是否真的删除这条数据？',
        scrollbar:true,
        yes:function () {
         $.post(url,data,function(res){
         if(res.status==1){
            dialog.success(res.message,jump_url);
         }
         if(res.status==0){
            dialog.error(res.message);
         }

       },'JSON');
 
        },
    });
     
    });

     $('#delall').click(function(){
    var goodsid={};
    $("input[name='goodsid']:checked").each(function (i) {
          goodsid[i]=$(this).val();
     });
    var url="/index.php/Shop/Ticket/bdel";
    var jump_url="/index.php/Shop/Ticket/index";
        layer.open({
        type:0,
        title:'批量删除',
        btn:['yes','no'], 
        icon:3,
        closeBtn:2,
        content: '是否真的删除这些数据？',
        scrollbar:true,
        yes:function () {
         $.post(url,goodsid,function(res){
         if(res.status==1){
            dialog.success(res.message,jump_url);
         }
         if(res.status==0){
            dialog.error(res.message);
         }

       },'JSON');
 
        },
    });
  })
  </script>

<!-- <script type="text/javascript">  var _gaq = _gaq || [];  _gaq.push(['_setAccount', 'UA-37564768-1']);  _gaq.push(['_setDomainName', 'keenthemes.com']);  _gaq.push(['_setAllowLinker', true]);  _gaq.push(['_trackPageview']);  (function() {    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);  })();</script> --></body>

<!-- END BODY -->

</html>