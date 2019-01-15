<?php 

//echo date("Y-m-d H:i:s")."123456" . "\r\n<br>";
//$contents = file_get_contents("test.txt");

$data['status'] = 2;//已发货 未收货订单
$list = D('indent')->where($data)->select();
foreach ($list as $key => $value) {
  $ten_day = 60*60*24*10;	
  $time = time();
  $jian = $time-$value['fahuo_time'];
  /*如果发货后十天 还没确认收货 系统自动确认收货*/
  if($jian>$ten_day){
  	$zi['id'] = $value['id'];
  	$dong['status'] = 3;
    $ok = D('indent')->where($zi)->save($dong);
    if($ok){
    	$status['indent_id'] = $value['id'];
    	$new['status'] = 1;
    	$ok2 = D('indent_money_control')->where($status)->save($new);
    	if($ok2){
    	 /*发送短信*/
         money_control($value['id']);
    	}
    }
  }
}


 ?>