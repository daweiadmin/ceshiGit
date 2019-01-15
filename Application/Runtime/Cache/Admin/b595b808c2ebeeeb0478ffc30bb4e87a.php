<?php if (!defined('THINK_PATH')) exit();?>



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

	<!-- BEGIN CONTAINER -->

	<div class="page-container" style="margin-top: 80px;">
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
	

		<!-- BEGIN PAGE -->

		<div class="page-content">

			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->

			<div id="portlet-config" class="modal hide">

				<div class="modal-header">

					<button data-dismiss="modal" class="close" type="button"></button>

					<h3>Widget Settings</h3>

				</div>

				<div class="modal-body">

					Widget settings form goes here

				</div>

			</div>

			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->

			<!-- BEGIN PAGE CONTAINER-->

			<div class="container-fluid">

				<!-- BEGIN PAGE HEADER-->

				<div class="row-fluid">

					<div class="span12">

						<!-- BEGIN STYLE CUSTOMIZER -->

						<div class="color-panel hidden-phone">

							<div class="color-mode-icons icon-color"></div>

							<div class="color-mode-icons icon-color-close"></div>

							<div class="color-mode">

								<p>THEME COLOR</p>

								<ul class="inline">

									<li class="color-black current color-default" data-style="default"></li>

									<li class="color-blue" data-style="blue"></li>

									<li class="color-brown" data-style="brown"></li>

									<li class="color-purple" data-style="purple"></li>

									<li class="color-grey" data-style="grey"></li>

									<li class="color-white color-light" data-style="light"></li>

								</ul>

								<label>

									<span>Layout</span>

									<select class="layout-option m-wrap small">

										<option value="fluid" selected>Fluid</option>

										<option value="boxed">Boxed</option>

									</select>

								</label>

								<label>

									<span>Header</span>

									<select class="header-option m-wrap small">

										<option value="fixed" selected>Fixed</option>

										<option value="default">Default</option>

									</select>

								</label>

								<label>

									<span>Sidebar</span>

									<select class="sidebar-option m-wrap small">

										<option value="fixed">Fixed</option>

										<option value="default" selected>Default</option>

									</select>

								</label>

								<label>

									<span>Footer</span>

									<select class="footer-option m-wrap small">

										<option value="fixed">Fixed</option>

										<option value="default" selected>Default</option>

									</select>

								</label>

							</div>

						</div>

						<!-- END BEGIN STYLE CUSTOMIZER -->    

						<!-- BEGIN PAGE TITLE & BREADCRUMB-->

						<h2 class="page-title">

							数据统计 <small><!-- 给您一双业绩冲刺的翅膀 --></small>

						</h2>

						<ul class="breadcrumb">

							<li>

								<i class="icon-home"></i>

								<a href="javascript:viod(0);">活动管理</a> 

								<i class="icon-angle-right"></i>

							</li>
                            <li>

								<i class="icon-home"></i>

								<a href="javascript:viod(0);">数据统计</a> 

								<i class="icon-angle-right"></i>

							</li>
					

						</ul>

						<!-- END PAGE TITLE & BREADCRUMB-->

					</div>

				</div>

				<!-- END PAGE HEADER-->

				<div id="dashboard">

					<!-- BEGIN DASHBOARD STATS -->

					<div class="row-fluid">

						<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
                          <a href="/index.php/Admin/member/putong">
							<div class="dashboard-stat blue">

								<div class="visual">

									<i class="icon-home"></i>

								</div>

								<div class="details">

									<div class="number" style="font-size:18px;">

										省级代理:<?php echo ($sheng_count); ?> 个

									</div>

								</div>

								<a class="more" href="javascript:viod(0);">

								

								</a>                 

							</div>
                          </a>
						</div>

						<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
                          <a href="/index.php/Admin/member/index">
							<div class="dashboard-stat green">

								<div class="visual">

									<i class="icon-home"></i>

								</div>

								<div class="details">

									<div class="number" style="font-size:18px;">市级代理:<?php echo ($shi_count); ?> 个</div>

								</div>

								<a class="more" href="javascript:viod(0);">

								

								</a>                 

							</div>
                           </a>
						</div>

						<div class="span3 responsive" data-tablet="span6  fix-offset" data-desktop="span3">
                         <a href="/index.php/Admin/member/vip_index"> 
							<div class="dashboard-stat purple">

								<div class="visual">
                                 <i class="icon-home"></i>
									

								</div>

								<div class="details">

									<div class="number" style="font-size:18px;">商户总数：<?php echo ($store_count); ?> 个</div>

								</div>

								<a class="more" href="javascript:viod(0);">

								

								</a>                 

							</div>
                           </a> 
						</div>

						<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
                           <a href="javascript:viod(0)">
							<div class="dashboard-stat red">

								<div class="visual">

									
                                     <i class="icon-globe"></i>
								</div>

								<div class="details">

									<div class="number" style="font-size:18px;">充值总额：<?php echo ($money_total); ?> 元</div>

								</div>
                                 
								<a class="more" href="javascript:viod(0);" style="font-size:18px;">

								<!-- 去充值 <i class="m-icon-swapright m-icon-white"></i> -->

								</a>                 

							</div>

						</div>
                       </a>
					</div>
					<button class="btn blue">充值手续费：<?php echo ($per*100); ?> %</button>
                     <button type="button" class="btn green " attr-id="<?php echo ($vo["id"]); ?>" data-toggle="modal" href="#sum">点击重设</button>

                 <div class="btn-group" style="width: 100%; text-align: center; margin-top: 50px;">
                   
                        <select class="span6 m-wrap lev" data-placeholder="Choose a Category" tabindex="1" style="width:200px;" id="date_num">
                         <option value='7'>- 近7天数据 -</option>
                         <option value='10'>- 近10天数据 -</option>
                         <option value='20'>- 近20天数据 -</option>
                         <option value='30'>- 近30天数据 -</option>

                      </select>
                     
                  </div>
        <div id="main" style="width: 1630px;height:400px; margin-bottom:100px; margin-top:50px;""></div>
		</div>

		<!-- END PAGE -->

	</div>
    

	<!-- END CONTAINER -->

	<!-- BEGIN FOOTER -->

	<div class="footer" style="background-color:#eee; text-align: center;">

		<div class="footer-inner" style="text-align: center;">

			领程科技
          
		</div>

		 <div class="footer-tools">

			<span class="go-top">

			<i class="icon-angle-up"></i>

			</span>

		</div> 

	</div>
<div class="modal fade" id="sum" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
<!-- ======= -->

         <form class="form-horizontal" id="form" action="" method="post" enctype="multipart/form-data">
         <table width="400" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce" class="table">
                <tr>
                   <td colspan="2" style="border:1px #ccc solid; line-height:30px; background-color:#eee; text-align: center;" height="20" width="200" align=""><b>充值手续费设置</b></td>
                 </tr>
                 <tr>
                    <td style="border:1px #ccc solid; line-height:30px;" height="20" width="100" align="center">现阶段手续费</td>
                    <td style="border:1px #ccc solid;" height="20" width="200" align="center">
                       <input type="text" class="form-control input-sm" id="number" name="number" style="width:100px; height:25px;" attr-id="<?php echo ($per); ?>" value="<?php echo ($per); ?>" readonly />
                    </td>
                 </tr>
                   <tr>
                    <td style="border:1px #ccc solid; line-height:30px;" height="20" width="100" align="center">您要改成</td>
                    <td style="border:1px #ccc solid;" height="20" width="200" align="center">
                       <input type="text" class="form-control input-sm" id="zhi" name="zhi" style="width:100px; height:25px;"  />
                       <span style="color:red;">*请输入小数值（例：0.05 ）</span>
                    </td>
                 </tr>
                   <tr>
                    <td style="border:1px #ccc solid; line-height:30px; text-align: center;" height="20" width="100" colspan="2">
                        <button type="button" class="btn blue " id="chongzhi">确认设置</button>
                    </td>
                 </tr>
           </table>
        </form>
<!-- ============ -->
        
      </div>
    </div>
  </div>
</div>
	<script src="/Public/media/js/echarts.js" type="text/javascript"></script>      
<script>
 $('#chongzhi').click(function(){
  var zhi = $('#zhi').val();
  var url = '/index.php/Admin/Index/chongzhi';
  var jump_url = '/index.php/Admin/Index/index';
  var data={'zhi':zhi}
  $.post(url,data,function(res){
      if (res.status == 1) {
         dialog.success(res.message,jump_url);
          } 
       if(res.status == 0){
          alert('设置失败');
         }

   },'JSON');
  });

var myChart = echarts.init(document.getElementById('main'));
 option = {
			    title: {
			        text: '日统计折线图'
			    },
			    tooltip : {
			        trigger: 'axis',
			        axisPointer: {
			            type: 'cross',
			            label: {
			                backgroundColor: '#6a7985'
			            }
			        }
			    },
			    legend: {
			        data:['每日充值总额','每日省级代理增长量','每日市级代理增长量','每日商户增长量']
			    },
			    toolbox: {
			        feature: {
			            saveAsImage: {}
			        }
			    },
			    grid: {
			        left: '3%',
			        right: '4%',
			        bottom: '3%',
			        containLabel: true
			    },
			    xAxis : [
			        {
			            type : 'category',
			            boundaryGap : false,
			            data : res.datas.date

			        }
			    ],
			    yAxis : [
			        {
			            type : 'value'
			        }
			    ],
			    series : [
			        {
			            name:'每日充值总额',
			            type:'line',
			            stack: '总量',
			            areaStyle: {},
			            data:res.datas.money_total
			        },
			        {
			            name:'每日省级代理增长量',
			            type:'line',
			            stack: '总量',
			            areaStyle: {},
			            data:res.datas.sheng_count
			        },
			        {
			            name:'每日市级代理增长量',
			            type:'line',
			            stack: '总量',
			            areaStyle: {},
			            data:res.datas.shi_count
			        },
			        {
			            name:'每日商户增长量',
			            type:'line',
			            stack: '总量',
			            areaStyle: {normal: {}},
			            data:res.datas.store_count
			        },
			     
			    ]
			};
		// 使用刚指定的配置项和数据显示图表。
           myChart.setOption(option);
  $('#date_num').change(function(){
    chartss();
  });
  chartss();
  function chartss(){
     var date_num = $('#date_num').val();
     var url = '/index.php/Admin/Index/charts';
     var data={'day_num':date_num}
       $.post(url,data,function(res){
         if(res.status==1){
            option = {
			    title: {
			        text: '日统计折线图'
			    },
			    tooltip : {
			        trigger: 'axis',
			        axisPointer: {
			            type: 'cross',
			            label: {
			                backgroundColor: '#6a7985'
			            }
			        }
			    },
			    legend: {
			        data:['每日充值总额','每日省级代理增长量','每日市级代理增长量','每日商户增长量']
			    },
			    toolbox: {
			        feature: {
			            saveAsImage: {}
			        }
			    },
			    grid: {
			        left: '3%',
			        right: '4%',
			        bottom: '3%',
			        containLabel: true
			    },
			    xAxis : [
			        {
			            type : 'category',
			            boundaryGap : false,
			            data : res.datas.date

			        }
			    ],
			    yAxis : [
			        {
			            type : 'value'
			        }
			    ],
			    series : [
			        {
			            name:'每日充值总额',
			            type:'line',
			            stack: '总量',
			            areaStyle: {},
			            data:res.datas.money_total
			        },
			        {
			            name:'每日省级代理增长量',
			            type:'line',
			            stack: '总量',
			            areaStyle: {},
			            data:res.datas.sheng_count
			        },
			        {
			            name:'每日市级代理增长量',
			            type:'line',
			            stack: '总量',
			            areaStyle: {},
			            data:res.datas.shi_count
			        },
			        {
			            name:'每日商户增长量',
			            type:'line',
			            stack: '总量',
			            areaStyle: {normal: {}},
			            data:res.datas.store_count
			        },
			     
			    ]
			};
		// 使用刚指定的配置项和数据显示图表。
           myChart.setOption(option);

            
         }
         if(res.status==0){
            dialog.error(res.message);
         }

       },'JSON');

   }




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

	<script src="media/js/excanvas.min.js"></script>

	<script src="media/js/respond.min.js"></script>  

	<![endif]-->   

	<script src="/Public/media/js/jquery.slimscroll.min.js" type="text/javascript"></script>

	<script src="/Public/media/js/jquery.blockui.min.js" type="text/javascript"></script>  

	<script src="/Public/media/js/jquery.cookie.min.js" type="text/javascript"></script>

	<script src="/Public/media/js/jquery.uniform.min.js" type="text/javascript" ></script>

	<!-- END CORE PLUGINS -->

	<!-- BEGIN PAGE LEVEL PLUGINS -->


	<!-- <script src="/Public/media/js/jquery.vmap.russia.js" type="text/javascript"></script>
	
	<script src="/Public/media/js/jquery.vmap.world.js" type="text/javascript"></script>
	
	<script src="/Public/media/js/jquery.vmap.europe.js" type="text/javascript"></script>
	
	<script src="/Public/media/js/jquery.vmap.germany.js" type="text/javascript"></script>
	
	<script src="/Public/media/js/jquery.vmap.usa.js" type="text/javascript"></script>
	
	<script src="/Public/media/js/jquery.vmap.sampledata.js" type="text/javascript"></script>   -->

	<script src="/Public/media/js/jquery.flot.js" type="text/javascript"></script>

	<script src="/Public/media/js/jquery.flot.resize.js" type="text/javascript"></script>

	<script src="/Public/media/js/jquery.pulsate.min.js" type="text/javascript"></script>

	<script src="/Public/media/js/date.js" type="text/javascript"></script>

	<script src="/Public/media/js/daterangepicker.js" type="text/javascript"></script>     

	<script src="/Public/media/js/jquery.gritter.js" type="text/javascript"></script>

	<script src="/Public/media/js/fullcalendar.min.js" type="text/javascript"></script>

	<script src="/Public/media/js/jquery.easy-pie-chart.js" type="text/javascript"></script>

	<script src="/Public/media/js/jquery.sparkline.min.js" type="text/javascript"></script>  

	<!-- END PAGE LEVEL PLUGINS -->

	<!-- BEGIN PAGE LEVEL SCRIPTS -->

	<script src="/Public/media/js/app.js" type="text/javascript"></script>

	<script src="/Public/media/js/index.js" type="text/javascript"></script>        

	<!-- END PAGE LEVEL SCRIPTS -->  

	<script>

		jQuery(document).ready(function() {    

		   App.init(); // initlayout and core plugins

		   Index.init();

		   Index.initJQVMAP(); // init index page's custom scripts

		   Index.initCalendar(); // init index page's custom scripts

		   Index.initCharts(); // init index page's custom scripts

		   Index.initChat();

		   Index.initMiniCharts();

		   Index.initDashboardDaterange();

		   Index.initIntro();

		});

	</script>

	<!-- END JAVASCRIPTS -->

<script type="text/javascript">  var _gaq = _gaq || [];  _gaq.push(['_setAccount', 'UA-37564768-1']);  _gaq.push(['_setDomainName', 'keenthemes.com']);  _gaq.push(['_setAllowLinker', true]);  _gaq.push(['_trackPageview']);  (function() {    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);  })();</script></body>

<!-- END BODY -->

</html>