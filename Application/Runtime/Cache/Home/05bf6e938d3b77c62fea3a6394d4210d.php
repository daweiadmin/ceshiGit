<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>我的优惠券</title>
        <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport"/>
        <meta content="yes" name="apple-mobile-web-app-capable"/>
        <meta content="black" name="apple-mobile-web-app-status-bar-style"/>
        <meta content="telephone=no" name="format-detection"/>
        <link href="/Public/red_bag/css/style.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="/Public/red_bag/js/jquery-1.js"></script>
        <script type="text/javascript" src="/Public/red_bag/js/tab.js"></script>
    </head>
    <body>

   
        <section class="aui-flexView">
            <header class="aui-navBar aui-navBar-fixed">
                <a href="javascript:;" class="aui-navBar-item">
                    <i class="icon icon-return"></i>
                </a>
                <div class="aui-center">
                    <span class="aui-center-title">我的优惠券</span>
                </div>
                <a href="javascript:;" class="aui-navBar-item">
                    <i class="icon icon-sys"></i>优惠券说明
                </a>
            </header>
            <section class="aui-scrollView">
                <div class="aui-tab" data-ydui-tab="">
                    <ul class="tab-nav">
                        <li class="tab-nav-item tab-active">
                            <a href="javascript:;">未使用
                            </a>
                        </li>
                        <li class="tab-nav-item">
                            <a href="javascript:;">已使用
                            </a>
                        </li>
                        <li class="tab-nav-item">
                            <a href="javascript:;">已过期
                            </a>
                        </li>
                    </ul>
                    <div class="tab-panel">
                        <div class="tab-panel-item tab-active">
                            <div class="tab-item">
                                <!--<div class="aui-tab-search-box">
                                    <div class="aui-tab-search-bg">
                                        <input type="text" placeholder="请输入兑换码">
                                        <button>兑换</button>
                                    </div>
                                </div>-->
                                <div class="aui-coupon-box">

                                <?php if(is_array($wei_arr)): $i = 0; $__LIST__ = $wei_arr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="aui-coupon-list">
                                    
                                        <div class="aui-coupon-list-flex">
                                            <div class="aui-coupon-list-flex-hd">
                                                <!-- <h2> <i>￥</i> 100</h2>
                                                <p>无金额门槛</p> -->
                                                <img src="<?php echo ($vo["ticket_picture"]); ?>" alt="">
                                            </div>
                                            <div class="aui-coupon-list-flex-bd">
                                                <h3>  <em>现金券</em> <?php echo ($vo["name"]); ?> </h3>
                                                <p><?php echo (date("y-m-d",$vo["end_time"])); ?>到期<i></i><em>立即使用</em> </p>
                                            </div>
                                        </div>

                                    </div><?php endforeach; endif; else: echo "" ;endif; ?> 
                                </div>
                            </div>
                        </div>





                        <div class="tab-panel-item -active">
                            <div class="tab-item tab-item-two">

                                <div class="aui-coupon-box">


                                 <?php if(is_array($yi_arr)): $i = 0; $__LIST__ = $yi_arr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="aui-coupon-list">
                                        <div class="aui-coupon-list-flex">
                                            <div class="aui-coupon-list-flex-hd">
                                               <!--  <h2> <i>￥</i> 100</h2>
                                               <p>无金额门槛</p> -->
                                                <img src="<?php echo ($vo["ticket_picture"]); ?>" alt="">
                                            </div>
                                            <div class="aui-coupon-list-flex-bd">
                                                <h3>签到礼-{<?php echo ($vo["name"]); ?>} </h3>
                                                <p><?php echo (date("y-m-d",$vo["end_time"])); ?>到期 已使用</p>
                                            </div>
                                        </div>

                                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
                             </div>
                            </div>
                        </div>




                        <div class="tab-panel-item ">
                            <div class="tab-item tab-item-two">
                                <div class="aui-coupon-box">

                                 <?php if(is_array($guo_arr)): $i = 0; $__LIST__ = $guo_arr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="aui-coupon-list">
                                        <div class="aui-coupon-list-flex">
                                            <div class="aui-coupon-list-flex-hd">
                                               <!--  <h2> <i>￥</i> 100</h2>
                                               <p>无金额门槛</p> -->
                                               <img src="<?php echo ($vo["ticket_picture"]); ?>" alt="">
                                            </div>
                                            <div class="aui-coupon-list-flex-bd">
                                                <h3>签到礼-{<?php echo ($vo["name"]); ?>} </h3>
                                                <p><?php echo (date("y-m-d",$vo["end_time"])); ?>到期 已使用</p>
                                            </div>
                                        </div>

                                    </div><?php endforeach; endif; else: echo "" ;endif; ?>


                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </section>

    </body>
</html>