<?php 
 

 //生成永不重复字符串
   function set_code_sn($length = 10,$num) {
          $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';//
          $charactersLength = strlen($characters);
          $randomString = '';
          for ($j=0;$j<$num;$j++){
              for ($i = 0; $i < $length; $i++) {
                  $randomString .= $characters[rand(0, $charactersLength - 1)];
              }
              $randomString;
          }

          return $randomString;
      }

      //取出任意天数 近7天 近30天 每天开始 与结束得时间戳
  function date_charts($day_num){
       for ($i=0; $i <= $day_num; $i++) {
        $j = $day_num-$i;
        $date = strtotime("-$j day");
        $month = date('m', $date);
        $start_day = date('d', $date);//开始时间
        $year = date('Y', $date);
       //print_r($year);exit;
        $day_start = mktime(0,0,0,$month,$start_day,$year);
        $day_end = mktime(23,59,59,$month,$start_day,$year);
        $w = date("Y-m-d H:i:s",$day_start);
        $a['start_time'] = $day_start;
        $a['end_time'] = $day_end;
        $b[] = $a;
       }
    return json_encode($b);

  }
  function userdata_string($member_id){
    $data['member_id'] = $member_id;
    $list = D('userdata')->where($data)->select(); 
    foreach ($list as $key => $value) {
      $string .=$value['data_name'].'：'.$value['data_value'].'， ';
    }
    return $string;

  }
  //商店累计充值金额
function chongzhi_total($shop_id){
    $data['userid'] = $shop_id;
    $data['moneytype'] = 1;
    $data['status'] = 0;
    $money = D('money_record')->where($data)->field('money')->select();
    $total=0;
    foreach ($money as $key => $value) {
       $total +=$value['money'];
     }

     return $total;
  }
  //商店累计活动金额
  function act_total($shop_id){
    $data['userid'] = $shop_id;
    $data['moneytype'] = 2;
    $data['status'] = 0;
    $money = D('money_record')->where($data)->field('money')->select();
    $total=0;
    foreach ($money as $key => $value) {
       $total +=$value['money'];
     }
     return $total;
  }

  function member_wxname($member_id){
    $data['id'] = $member_id;
    $name = D('member')->where($data)->field('wx_name')->find();
    if($name['wx_name']){
       return $name['wx_name'];
    }else{
      return '未授权';
    }
  }
 function m_sex($sex){
    if($sex==1){
            return '男';
          }else{
             return '女';
          }

 }
  function member_wxsex($member_id){
    $data['id'] = $member_id;
    $name = D('member')->where($data)->field('sex')->find();
    if($name['sex']){
          if($name['sex']==1){
            return '男';
          }else{
             return '女';
          }
       
     }else{
      return '';
    }
  }
 
 //会员领取奖励次数  按商户计算
 function member_record_count($mem){
    
    $shop['shop_id'] = session('shopUser.id');
    $act = D('activity')->where($shop)->field('id')->select();
    $str = '';
    foreach ($act as $key => $value) {
      $str.=$value['id'].',';
    }
    $in = rtrim($str,',');
    $data['member_id'] = $mem;
    $data['activity_id'] = array('in',$in);
    $count = D('get_record')->where($data)->count();
    return $count;
 }

 //会员领取奖励金额  按商户计算
 function member_record_money($mem){
    
    $shop['shop_id'] = session('shopUser.id');
    $act = D('activity')->where($shop)->field('id')->select();
    $str = '';
    foreach ($act as $key => $value) {
      $str.=$value['id'].',';
    }
    $in = rtrim($str,',');
    $data['member_id'] = $mem;
    $data['activity_id'] = array('in',$in);
    $list = D('get_record')->where($data)->field('prize_type,prize')->select();
    $total = 0;
    foreach ($list as $key => $value) {
       if($value['prize_type']==1||$value['prize_type']==2){
       $total+=$value['prize'];
       }
    }
    return $total;
 }
 //会员最后参与活动时间  按商户计算
 function member_record_time($mem){
    
    $shop['shop_id'] = session('shopUser.id');
    $act = D('activity')->where($shop)->field('id')->select();
    $str = '';
    foreach ($act as $key => $value) {
      $str.=$value['id'].',';
    }
    $in = rtrim($str,',');
    $data['member_id'] = $mem;
    $data['activity_id'] = array('in',$in);
    $count = D('get_record')->where($data)->field('time')->order('id desc')->find();
    $time = date('Y-m-d H:i:s',$count['time']);
    return $time;
 }

   function member_wxpic($member_id){
    $data['id'] = $member_id;
    $name = D('member')->where($data)->field('wx_pic')->find();
    if($name['wx_pic']){
       return $name['wx_pic'];
    }else{
      return '';
    }
  }
  //再投活动金额
  function total_prize_money($activity_id){
     $data['id'] = $activity_id;
     


  }
  function set_hexiao_code($id){
        ob_end_clean();
        $link_url = 'http://redbag.lingcheng888.com/index.php/home/wechat/hexiao_info?hexiao_id='.$id;
        $level=3;  
        $size=4;  
        Vendor('phpqrcode.phpqrcode');  
        $errorCorrectionLevel =intval($level) ;//容错级别  
        $matrixPointSize = intval($size);//生成图片大小  
        //生成二维码图片  
        $object = new \QRcode();  
        $path = "Public/erweima/hexiao/";
        $file = $path.'hexiao_code'.$id.".png";
        //print_r($url);exit;
        $object->png($link_url, $file, $errorCorrectionLevel, $matrixPointSize, 2); 
        $path2 = '/Public/erweima/hexiao/hexiao_code'.$id.".png"; 
        return $path2;
  }
 
  function saoma_total($shop_id){

    $count=D('code')
     ->table('red_code co,red_activity act,red_shop sho,red_code_num co_n') 
     ->field('co.status,act.name,sho.name,co_n.id')
     ->where('co.code_num_id=co_n.id and co.status>0 and co_n.activity_id=act.id and  act.shop_id="'.$shop_id.'"')
     ->count();
    return $count;

  }
 function share_total($shop_id){

    $count=D('activity')
     ->table('red_code co,red_activity act,red_shop sho') 
     ->field('co.status,act.name,sho.name')
     ->where('co.status>0 and co.activity_id=act.id and act.condition=2 and co.share=1 and act.shop_id="'.$shop_id.'"')
     ->count();
    return $count;

  }

 function condition($con){
    if($con==1){
       return '直接领取';
    }
    if($con==2){
      return '分享领取';
    }
    if($con==3){
      return '关注领取';
    }

   }

  
   //活动总金额
   function prize_total($actie_id){
     $data['activity_id'] = $actie_id;
     $data['prize_type'] = array('in','1,2'); 
     $list = D('activity_prize')->where($data)->select();
     $total = 0;
     foreach ($list as $key => $value) {
      if($value['prize_type']==1){
        $total1 += $value['prize']*$value['prize_amount'];
      }
      if($value['prize_type']==2){
        $total2 += $value['prize'];
      }
     }
      $total = $total1+$total2;
     return $total;
    }
     //码号
   function code_number($code){
     $data['id'] = $code;
     $num = D('code')->where($data)->field('number')->find();
     return $num['number'];
   }


   //已领取金额
    function get_total($actie_id){
     $data['activity_id'] = $actie_id;
     $data['prize_type'] = array('in','1,2'); 
     $list = D('get_record')->where($data)->select();
     foreach ($list as $key => $value) {
       $total += $value['prize'];
     }
     if($total){
      return $total;
     }else{
      return '0';
     }
     
   }
   //活动总码量
    function act_z_num($active_id){
      $data['activity_id'] = $active_id;
      $num = D('code_num')->where($data)->field('id')->select();
      $str = '';
      foreach ($num as $key => $value) {
        $str.=$value['id'].',';
      }
      $string = rtrim($str,',');
      $vvv['code_num_id'] = array('in',$string);
      $qw = D('code')->where($vvv)->field('id')->count();
      return $qw;

   }
   //活动所包含码段
    function act_c_num($active_id){
      $data['activity_id'] = $active_id;
      $num = D('code_num')->where($data)->field('code_number')->select();
      $str = '';
      foreach ($num as $key => $value) {
        $str.=$value['code_number'].'<br/>';
      }
      return $str;

   }
   //活动总抽奖次数
   function prize_total_num($active_id){
      $data['activity_id'] = $active_id;
      $num = D('activity_prize')->where($data)->count();
      return $num;

   }
   //已抽奖次数
    function get_prize_num($active_id){
      $data['activity_id'] = $active_id;
      $num = D('get_record')->where($data)->count();
      return $num;
   }
   function jindu($active_id){
     $a = code_have($active_id);
     $b = act_code_num($active_id);
     $d = $b-$a;
     $c = $d/$b;
     return round($c*100);

   }
   //有奖码量
   function code_have($active_id){
    /*$data['activity_id'] = $active_id;
    $code_n = D('code_num')->where($data)->field('id')->select();
    foreach ($code_n as $key => $value) {
      $string.=$value['id'].',';
    }
    $str = rtrim($string,',');
    $data_c['code_num_id'] = array('in',$str);
    $data_c['status'] = 0;
    $num = D('code')->where($data_c)->count();*/
    $data['status'] = 0;
    $data['activity_id'] = $active_id;
    $num = D('code')->where($data)->count();
    return $num;
   }
   //总码量
   function act_code_num($active_id){
    /*$data['activity_id'] = $active_id;
    $code_n = D('code_num')->where($data)->field('id')->select();
    foreach ($code_n as $key => $value) {
      $string.=$value['id'].',';
    }
    $str = rtrim($string,',');
    $data_c['code_num_id'] = array('in',$str);*/
    $data_c['activity_id'] = $active_id;
    $num = D('code')->where($data_c)->count();
    return $num;
   }
   //分享
     function share_title($active_id){
       $data['activity_id'] = $active_id;
       $code_n = D('share_data')->where($data)->find();
       return $code_n['share_title'];
    }
     function share_link($active_id){
       $data['activity_id'] = $active_id;
       $code_n = D('share_data')->where($data)->find();
       return $code_n['share_title'];
    }
     function share_picture($active_id){
       $data['activity_id'] = $active_id;
       $code_n = D('share_data')->where($data)->find();
       return $code_n['share_picture'];
    }

    function active_type($type){
     switch ($type) {
       case '1':
         return '扫码领红包';
         break;
      case '2':
         return '九宫格';
         break;
      case '3':
         return '大转盘';
         break;
      case '4':
         return '刮刮乐';
         break;
      case '5':
         return '砸金蛋';
         break;
     }


   }
   function prize_ino(){


    
   }
   function activity_status($status){
     switch ($status) {
        case '0':
         return '<span style="color:blue;">未审核</span>';
         break;
        case '1':
         return '<span style="color:green;">已审核</span>';
         break;
        case '-1':
         return '<span style="color:red;">审核未通过</span>';
         break;
         case '-2':
         return '<span style="color:red;">草稿</span>';
         break;
     }

   }
   function act_status($status){
     switch ($status) {
        case '0':
         return '<span style="color:blue;">未开始</span>';
         break;
        case '1':
         return '<span style="color:green;">已开始</span>';
         break;
        case '2':
         return '<span style="color:red;">已暂停</span>';
         break;
        case '-1':
         return '<span style="color:red;">已关闭</span>';
         break;
     }


   }
   
   function prize_value($record){
    $data['id'] = $record;
    $rec = D('get_record')->where($data)->field('prize_type,prize')->find();
    if($rec['prize_type']==1){
      return '现金红包：'.$rec['prize'].'元';
    }
    if($rec['prize_type']==2){
      return '随机红包：'.$rec['prize'].'元';
    }
    if($rec['prize_type']==3){
      $tic['id'] = $rec['prize'];
      $tickname = D('ticket')->where($tic)->field('name')->find();
      return '兑换券：'.$tickname['name'];
    }
     if($rec['prize_type']==4){
      $tic['id'] = $rec['prize'];
      $tickname = D('ticket')->where($tic)->field('name')->find();
      return '优惠券：'.$tickname['name'];
    }
 
   }
   
   function activity_shopname($activityid){
     $data['id'] = $activityid;
     $rec = D('activity')->where($data)->field('shop_id')->find();
     $aa['id'] = $rec['shop_id'];
     $name = D('shop')->where($aa)->field('name')->find();
     return $name['name'];
   }


  function activity_name($id){
     $data['id'] = $id;
     $name = D('activity')->where($data)->field('act_name')->find();
     return $name['act_name'];
  }
 function code_status($sta){
   switch ($sta) {
        case '0':
         return '<span style="color:green;">未扫码</span>';
         break;
        case '1':
         return '<span style="color:#333;">已扫码未领取</span>';
         break;
        case '2':
         return '<span style="color:red;">已领取</span>';
         break;
     }


 }

function kucun($id){
    $data['member_id'] = $id;
    $name = D('member_product')->where($data)->find();
    //$re = $name['location'].'-'.$name['address'];
    if($name){
     return $name['goods_num'];
    }else{
      return '0';
    }
  }
function show($status,$message,$data,$change=array()){
  $array=array(
    'status'=>$status,
    'message'=>$message,
    'datas'=>$data,
    'shuju'=>$change,
    );
  exit(json_encode($array));
 }
 function get_md5($pwd){
   $string = 'red'.md5($pwd).'bag';
   return md5($string); 
 }

function code_num($id){
  $data['code_num_id'] = $id;
  $name = D('code')->where($data)->count();
  return $name;
}
 function shop_name($id){
  $data['id'] = $id;
  if(!$data['id']){
    return '无';
  }
  $name = D('shop')->where($data)->field('name')->find();
  return $name['name'];
 }
 
  

 function level($type){
   if($type==1){
     return '省级代理';
   }
   if($type==2){
     return '市级代理';
   }
   if($type==3){
     return '普通商户';
   }
 }
 function shop_status($sta){
   if($sta==1){
     return '正常';
   }
   if($sta==0){
     return '未审核';
   }
   if($sta==-1){
     return '冻结';
   }
    if($sta==-2){
     return '未审核通过';
   }
 }


//九宫格数据
 function prize($id){
  $data['id'] = $id;
  $prize = D('activity_prize')->where($data)->find();
  if($prize['prize_type']==1){
     return $prize['prize'].'元现金红包';
  }
  if($prize['prize_type']==2){
     return $prize['prize'].'元随机红包';
  }
  if($prize['prize_type']==3){
    $ddd['id'] = $prize['prize'];
    $dui = D('ticket')->where($ddd)->field('name')->find();
     return $dui['name'];
  }
  if($prize['prize_type']==4){
    $yyy['id'] = $prize['prize'];
    $you = D('ticket')->where($yyy)->field('name')->find();
     return $you['name'];
  }

 }


/*
发送微信推送消息
*/
  /*会员欢迎通知*/

 function huanying($openid,$mem_id,$time){
   $ACCESS_TOKEN = get_access_token();
   $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$ACCESS_TOKEN";
   $data['touser'] = $openid;
   $data['template_id'] = 'L8hOh3C-TdOUWq6QYtrFcHqam79jQ3vyWBQBi1vcrgk';//模板id
   $data['topcolor'] = '#FF0000';
   $data['data'] = array(
                    'first' => array('value'=>'欢迎来到星优集！'),
                    'keyword1'=>array('value'=>$mem_id,'color'=>'#173177'),
                    'keyword2'=>array('value'=>$time,'color'=>'#173177'),
                    'remark' => array('value'=>'感谢您的加入！'),

                  );
   $json_data = json_encode($data);
   $res = httpRequest($url,'POST',$json_data);
   $result = json_decode($res,true);
   return $result['errmsg'];
 }



  /*会员注册 新粉丝提醒*/
 
 function new_mem_tosend($openid,$nikname,$new_mem_id){
   $ACCESS_TOKEN = get_access_token();
   $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$ACCESS_TOKEN";
   $data['touser'] = $openid;
   $data['template_id'] = 'tAKwu3GW4hMfTJc6Zs5QDWkRekx9dvYk8e21Gq1MCos';//模板id
   $data['topcolor'] = '#FF0000';
   $data['data'] = array(
   	                'first' => array('value'=>'您有新粉丝了！'),
                    'keyword1'=>array('value'=>$nikname,'color'=>'#173177'),
                    'keyword2'=>array('value'=>$new_mem_id,'color'=>'#173177'),
                    'remark' => array('value'=>'感谢您的信任与支持！'),

                  );
   $json_data = json_encode($data);
   $res = httpRequest($url,'POST',$json_data);
   $result = json_decode($res,true);
   return $result['errmsg'];
 }



/*分润 消息提醒   分销订单提成通知  积分变动通知*/
 function fenrun_tosend($openid,$content,$money,$fen_money,$member,$time){
   $ACCESS_TOKEN = get_access_token();
   $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$ACCESS_TOKEN";
   $data['touser'] = $openid;
   $data['template_id'] = 'isyo66lXVj12LwYAlOuqnemP8XRE1HLao7cLnFZfWBo';//模板id
   $data['topcolor'] = '#FF0000';
   $data['data'] = array(
                    'first' => array('value'=>$content),
                    'keyword1'=>array('value'=>$time,'color'=>'#173177'),//获得时间
                    'keyword2'=>array('value'=>$money,'color'=>'#173177'),//获得积分
                    'keyword3'=>array('value'=>'会员消费','color'=>'#173177'),//获得原因
                    'keyword4'=>array('value'=>$fen_money,'color'=>'#173177'),//当前积分
                    'remark' => array('value'=>'订单还未完成，请耐心等待'),

                  );
   $json_data = json_encode($data);
   $res = httpRequest($url,'POST',$json_data);
   $result = json_decode($res,true);
   return $result['errmsg'];
 }


 /*订单发货通知*/
   function indent_fahuo($openid,$ind,$time,$member,$phone){
   $ACCESS_TOKEN = get_access_token();
   $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$ACCESS_TOKEN";
   $data['touser'] = $openid;
   $data['template_id'] = '6u7BNGcxA96cjWDagzShjyewPoAusyeJFcMSRaABuHs';//模板id
   $data['topcolor'] = '#FF0000';
   $data['data'] = array(
                    'first' => array('value'=>'您的订单已发货，正在配送中，请耐心等待。'),
                    'keyword1'=>array('value'=>$ind,'color'=>'#173177'),//订单编号
                    'keyword2'=>array('value'=>$time,'color'=>'#173177'),//购买时间
                    'keyword3'=>array('value'=>$member,'color'=>'#173177'),//收货人
                    'keyword4'=>array('value'=>$phone,'color'=>'#173177'),//收货电话
                    'remark' => array('value'=>'如果五天内没有收到商品，请及时与客服联系'),

                  );
   $json_data = json_encode($data);
   $res = httpRequest($url,'POST',$json_data);
   $result = json_decode($res,true);
   return $result['errmsg'];
 }
/*积分兑换成功提醒*/
   function money_duihuan_send($openid,$wx_name,$jifen,$time){
   $ACCESS_TOKEN = get_access_token();
   $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$ACCESS_TOKEN";
   $data['touser'] = $openid;
   $data['template_id'] = 'Donwa3LjML4kv8y7I5Ldge5pa90JVYBjfzUvgJ02OH0';//模板id
   $data['topcolor'] = '#FF0000';
   $data['data'] = array(
                    'first' => array('value'=>'您的积分兑换申请已完成，快去查看吧'),
                    'keyword1'=>array('value'=>$wx_name,'color'=>'#173177'),//会员昵称
                    'keyword2'=>array('value'=>$wx_name,'color'=>'#173177'),//会员账号
                    'keyword3'=>array('value'=>$jifen,'color'=>'#173177'),//会员积分
                    'keyword4'=>array('value'=>$time,'color'=>'#173177'),//时间
                    'remark' => array('value'=>'感谢您的信赖'),

                  );
   $json_data = json_encode($data);
   $res = httpRequest($url,'POST',$json_data);
   $result = json_decode($res,true);
   return $result['errmsg'];
 }

 /*订单收货通知*/
  function indent_shouhuo($openid,$member,$ind,$totalmoney,$start_time,$content){
   $ACCESS_TOKEN = get_access_token();
   $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$ACCESS_TOKEN";
   $data['touser'] = $openid;
   $data['template_id'] = 'IZKhweOsQ0pxRQ3Dj5ObDkV1tYlwzWO3yRoyQHBv4Iw';//模板id
   $data['topcolor'] = '#FF0000';
   $data['data'] = array(
                    'first' => array('value'=>'您下级有订单确认收货'),
                    'keyword1'=>array('value'=>$member,'color'=>'#173177'),//客户账号
                    'keyword2'=>array('value'=>$ind,'color'=>'#173177'),//订单编号
                    'keyword3'=>array('value'=>$totalmoney,'color'=>'#173177'),//付款金额
                    'keyword4'=>array('value'=>$start_time,'color'=>'#173177'),//付款时间
                    'remark' => array('value'=>$content),

                  );
   $json_data = json_encode($data);
   $res = httpRequest($url,'POST',$json_data);
   $result = json_decode($res,true);
   return $result['errmsg'];
 }



 /*红包到账通知*/
  function send_redbag($openid,$money,$time,$content,$indents){
   $ACCESS_TOKEN = get_access_token();
   $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$ACCESS_TOKEN";
   $data['touser'] = $openid;
   $data['template_id'] = '4sGY4WTV7xgSfflVgbPnGya09q82F4hAWdJ61lHl5fQ';//模板id
   $data['topcolor'] = '#FF0000';
   $data['data'] = array(
                    'first' => array('value'=>'活动奖励'),
                    'keyword1'=>array('value'=>$money,'color'=>'#173177'),//入账金额
                    'keyword2'=>array('value'=>$time,'color'=>'#173177'),//入账时间
                    'keyword3'=>array('value'=>'活动奖励','color'=>'#173177'),//入账类型
                    'keyword4'=>array('value'=>$content,'color'=>'#173177'),//入账详情
                    'keyword5'=>array('value'=>$indents,'color'=>'#173177'),//交易单号
                    'remark' => array('value'=>'感谢您的参与'),

                  );
   $json_data = json_encode($data);
   $res = httpRequest($url,'POST',$json_data);
   $result = json_decode($res,true);
   return $result['errmsg'];
 }
 /*奖励到账通知*/
  function send_ticket($openid,$money,$activity,$time){
   $ACCESS_TOKEN = get_access_token();
   $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$ACCESS_TOKEN";
   $data['touser'] = $openid;
   $data['template_id'] = 'WqcA1yF3Vy8KKooUh6N6MfnNLkFazXvx_LrxtmRn-BY';//模板id
   $data['topcolor'] = '#FF0000';
   $data['data'] = array(
                    'first' => array('value'=>'活动奖励'),
                    'keyword1'=>array('value'=>$activity,'color'=>'#173177'),//活动
                    'keyword2'=>array('value'=>$money,'color'=>'#173177'),//奖品
                    'keyword3'=>array('value'=>$time,'color'=>'#173177'),//时间
                    'remark' => array('value'=>'感谢您的参与'),

                  );
   $json_data = json_encode($data);
   $res = httpRequest($url,'POST',$json_data);
   $result = json_decode($res,true);
   return $result['errmsg'];
 }


 /*发送 上边的接口*/
function money_control($indent_id){
   $list = D('indent_money_control')->where(array('indent_id'=>$indent_id))->select();
   $indent = D('indent')->where(array('id'=>$indent_id))->find();
   $mem= D('member')->where(array('id'=>$indent['member_id']))->find();
   //print_r($mem);exit;
   $have = D('member_data')->where(array('member_id'=>$mem['id']))->find();
   if(empty($have)){
    $mem_name = $mem['wx_name'];//昵称
   }else{
    $mem_name = $have['name'];//真实姓名
   }
   foreach ($list as $key => $value) {
      $mem_ref= D('member')->where(array('id'=>$value['mem_ref_id']))->find();
      $openid = $mem_ref['wx_openid'];
      $member = $mem['wx_name'];
      $ind = $indent['indents'];
      $totalmoney = $indent['total'];
      $start_time = date("Y-m-d h:i:sa", $indent['indent_start_time']);//支付时间
      $content = "会员【".$mem_name."】已确认收货，您的可兑换积分+".$value['money'];
      indent_shouhuo($openid,$member,$ind,$totalmoney,$start_time,$content);

   }
  }



 /*生成临时二维码*/
  function erweima_url($id){
   $ACCESS_TOKEN = get_access_token();
   $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$ACCESS_TOKEN";

   $data['expire_seconds'] = '2591992';//有效时间30天
   $data['action_name'] = 'QR_SCENE';//二维码类型 为临时的整型参数值，
   $data['action_info'] = array(
      'scene'=>array('scene_id'=>$id),//场景值ID，临时二维码时为32位非0整型
     );
   
   $json_data = json_encode($data);

   $res = httpRequest($url,'POST',$json_data);
   ///file_put_contents ( 'json4.txt' ,$res);
   $result = json_decode($res,true);//有true参数 解析为数组 没有则解析为对象
  // file_put_contents ( 'json2.txt' ,$result['url']);

   return $result['url'];

  }
  /*生成临时关注带参数二维码*/
  function guanzhu_erweima_url($code_id,$token){
    $member_id = session('memberUser.id');
   //$ACCESS_TOKEN = get_access_token();
   $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$token";
   $data['expire_seconds'] = '7200';//有效时间2小时
   $data['action_name'] = 'QR_SCENE';//二维码类型 为临时的整型参数值，
   $scene_id = $code_id.'_'.$member_id;
   // file_put_contents ( 'scene_id.txt' ,$scene_id);
   $data['action_info'] = array(
      'scene'=>array('scene_id'=>$scene_id),//场景值ID，临时二维码时为32位非0整型
     );
   $json_data = json_encode($data);
   $res = httpRequest($url,'POST',$json_data);
   $result = json_decode($res,true);//有true参数 解析为数组 没有则解析为对象
   //$ticket = UrlEncode($result['ticket']);
  // $code = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=$ticket";
   return $result['url'];

  }

 function get_access_token(){
        //
        $wechat = C('WEIXINPAY_CONFIG');
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$wechat[APPID]}&secret={$wechat[APPSECRET]}";
        $return = httpRequest($url,'GET');
        $return = json_decode($return,true);
        return $return['access_token'];
    }

 /**
 * CURL请求
 * @param $url 请求url地址
 * @param $method 请求方法 get post
 * @param null $postfields post数据数组
 * @param array $headers 请求header信息
 * @param bool|false $debug  调试开启 默认false
 * @return mixed
 */
function httpRequest($url, $method, $postfields = null, $headers = array(), $debug = false) {
    $method = strtoupper($method);
    $ci = curl_init();
    /* Curl settings */
    curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
    curl_setopt($ci, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.2; WOW64; rv:34.0) Gecko/20100101 Firefox/34.0");
    curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 60); /* 在发起连接前等待的时间，如果设置为0，则无限等待 */
    curl_setopt($ci, CURLOPT_TIMEOUT, 7); /* 设置cURL允许执行的最长秒数 */
    curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
    switch ($method) {
        case "POST":
            curl_setopt($ci, CURLOPT_POST, true);
            if (!empty($postfields)) {
                $tmpdatastr = is_array($postfields) ? http_build_query($postfields) : $postfields;
                curl_setopt($ci, CURLOPT_POSTFIELDS, $tmpdatastr);
            }
            break;
        default:
            curl_setopt($ci, CURLOPT_CUSTOMREQUEST, $method); /* //设置请求方式 */
            break;
    }
    $ssl = preg_match('/^https:\/\//i',$url) ? TRUE : FALSE;
    curl_setopt($ci, CURLOPT_URL, $url);
    if($ssl){
        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, FALSE); // 不从证书中检查SSL加密算法是否存在
    }
    //curl_setopt($ci, CURLOPT_HEADER, true); /*启用时会将头文件的信息作为数据流输出*/
    curl_setopt($ci, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ci, CURLOPT_MAXREDIRS, 2);/*指定最多的HTTP重定向的数量，这个选项是和CURLOPT_FOLLOWLOCATION一起使用的*/
    curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ci, CURLINFO_HEADER_OUT, true);
    /*curl_setopt($ci, CURLOPT_COOKIE, $Cookiestr); * *COOKIE带过去** */
    $response = curl_exec($ci);
    $requestinfo = curl_getinfo($ci);
    $http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
    if ($debug) {
        echo "=====post data======\r\n";
        var_dump($postfields);
        echo "=====info===== \r\n";
        print_r($requestinfo);
        echo "=====response=====\r\n";
        print_r($response);
    }
    curl_close($ci);
    return $response;
  //return array($http_code, $response,$requestinfo);
}
 /*查看三级内有无VIP或者总代*/
  function find_in_three($ref_id,$i=0){
    $find = D('member')->where(array('id'=>$ref_id))->find();
    $i++;
    if($i<=3){
     if($find['level']==2||$find['level']==3){
       return 1;
      }else{
       return find_in_three($find['refe_id'],$i);
      }

    }else{
      return -1;
    }
   
 }

 function erwei_array_string($arr){
       $str = '';
       foreach ($arr as $key => $value) {
        $str .= $value['id'].',';
       }
       $in = rtrim($str,',');
       return $in;
 }

    function weixinpay($order){
        header('Content-type:text/html;charset=utf-8');
        //print_r('进来了');exit;
        $order['trade_type']='NATIVE';
        Vendor('Weixinpay.Weixinpay');
        $weixinpay=new \Weixinpay();
        $url = $weixinpay->pay($order);
       // return $url;
         /*生成推广二维码*/
        ob_end_clean();
       // file_put_contents ( '3.txt' ,'二维码生成开始22');
            $level=3;  
            $size=6;  
            Vendor('phpqrcode.phpqrcode');  
            $errorCorrectionLevel =intval($level) ;//容错级别  
            $matrixPointSize = intval($size);//生成图片大小  
            //生成二维码图片  
            $object = new \QRcode();  
            $path = "Public/erweima/pay_code/";
            $file = $path.'pay_erweima'.$order['out_trade_no'].".png";
            //print_r($url);exit;
            $object->png($url, $file, $errorCorrectionLevel, $matrixPointSize, 2); 
            $erweima_url = '/Public/erweima/pay_code/pay_erweima'.$order['out_trade_no'].".png";
        return $erweima_url;
        //print_r($url);exit;

    }

    //生成二维码图片
      function set_code_img($sn,$path,$code_number){
        ob_end_clean();
        $link_url = 'http://redbag.lingcheng888.com/index.php/home/wechat/index?sn='.$sn;
        $level=3;  
        $size=4;  
        Vendor('phpqrcode.phpqrcode');  
        $errorCorrectionLevel =intval($level) ;//容错级别  
        $matrixPointSize = intval($size);//生成图片大小  
        //生成二维码图片  
        $object = new \QRcode();  
        $file = $path.$code_number.".png";
        //print_r($url);exit;
        $object->png($link_url, $file, $errorCorrectionLevel, $matrixPointSize, 2); 
        return 1;
     }

   //************生成新的文件夹
     function set_wenjianjia($shop_id){
        $shop = 'shop'.$shop_id;
        $dir = iconv("UTF-8", "GBK", "Public/erweima/$shop/");
        if (!file_exists($dir)){
            mkdir ($dir,0777,true);
            return $dir;
        } else {
            return $dir;
        }



     }
    
    //***取出一个文件夹内 所有文件得名称
    function list_dir($dir){
       $result = array();
       if (is_dir($dir)){
       $file_dir = scandir($dir);
       foreach($file_dir as $file){
        if ($file == '.' || $file == '..'){
        continue;
        }
        elseif (is_dir($dir.$file)){
        $result = array_merge($result, list_dir($dir.$file.'/'));
        }
        else{
        array_push($result, $dir.$file);
        }
       }
       }
       return $result;
      }
  
  //清空文件夹函数和清空文件夹后删除空文件夹函数的处理
     function deldir($path){
         //如果是目录则继续
         if(is_dir($path)){
             //扫描一个文件夹内的所有文件夹和文件并返回数组
            $p = scandir($path);
            foreach($p as $val){
                //排除目录中的.和..
                if($val !="." && $val !=".."){
                    //如果是目录则递归子目录，继续操作
                    if(is_dir($path.$val)){
                        //子目录中操作删除文件夹和文件
                        deldir($path.$val.'/');
                        //目录清空后删除空文件夹
                        @rmdir($path.$val.'/');
                    }else{
                        //如果是文件直接删除
                        unlink($path.$val);
                    }
                }
            }
        }
     }



/**
 * 经纬度转换
 * @param 
 * int type 需要转换的目标类型
 * int to   百度类型
 * String $x,$y 经纬度
 */
function getXy($x,$y,$ak,$type,$to)
{
  //调用百度地图接口
  $apiUrl = "http://api.map.baidu.com/geoconv/v1/?coords={$x},{$y}&from={$type}&to={$to}&ak={$ak}";
  
  $jsonData = curlHttp($apiUrl);
 
  $data = json_decode($jsonData,true);
 
  return $data;
}




/**
 * @param
 * $x $y 微信获取的经纬度
 * $ak 百度地图key   通过注册成为开放者得到
 */
function getAddress($x,$y,$ak){
   header("Content-type:text/html;charset=utf-8");
  //转换成百度认可的经纬度
  $res = getXy($x,$y,$ak,1,5);
  
  $y1 = $res['result'][0]['y'];
  $x1 = $res['result'][0]['x'];
  
    //调用百度地图接口
    $apiUrl = "http://api.map.baidu.com/geocoder/v2/?location={$y1},{$x1}&output=json&ak={$ak}";   //百度地图接口地址
    
    $jsonData = curlHttp($apiUrl);
    //$data = json_decode($jsonData,true);                                                                               // 将返回的结果进行json处理
 //print_r($data);exit;
    return $jsonData;
}



/*curl*/
function curlHttp($url,$https = false,$post = false,$post_data = array())
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_HEADER,0);
    /*是否post提交数据*/
    if($post){
        curl_setopt($ch,CURLOPT_POST,1);
        if(!empty($post_data)){
            curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
        }
    }
    /*是否需要安全证书*/
    if($https){
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    // https请求 不验证证书和hosts
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    }
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}


///++++++++++++************************
///*****************第三方开放平台**/
///
//component_access_token 属于第三方平台
  function get_component_access_token(){
    $ad['id'] = 2;
    $comp = D('admin')->where($ad)->field('component_access_token,component_time')->find();
    $two = 60*60*1.8;
    $time = time()-$comp['component_time'];
   // file_put_contents('json_get_component',date('Y-m-d H:i:s',$comp['component_time']));
    if($time>$two||!$comp['component_access_token']){
        $config = C('WXKAI_CONFIG');
        $url = "https://api.weixin.qq.com/cgi-bin/component/api_component_token";
        $file_path = 'wx_ticket/ticket.log';
        $ticket = file_get_contents($file_path);
        $data = array(
                  "component_appid"=>$config['appId'],
                  "component_appsecret"=>$config['appsecret'],
                  "component_verify_ticket"=>$ticket
              );
        $send_result = https_request($url, json_encode($data));
        
        $token = json_decode($send_result,true);
        if($token['component_access_token']){
        //print_r($token);exit;
          $save['component_access_token'] = $token['component_access_token'];
          $save['component_time'] = time();
          $ok = D('admin')->where($ad)->save($save);
        }
        if($ok){
            return $token['component_access_token'];
        }
        
    }else{
        return $comp['component_access_token'];
    }



  }


 function get_pre_auth_code(){
    $config = C('WXKAI_CONFIG');
    $token = get_component_access_token();
    $url = "https://api.weixin.qq.com/cgi-bin/component/api_create_preauthcode?component_access_token={$token}";
    $data = array(
              "component_appid"=>$config['appId']
          );
    $send_result = https_request($url, json_encode($data));
    $send_result = json_decode($send_result,true);
    return $send_result['pre_auth_code'];

 }

 //获取authorizer_access_token
   function set_authorizer_token($code){
      $config = C('WXKAI_CONFIG');
      $component = get_component_access_token();
      $url = "https://api.weixin.qq.com/cgi-bin/component/api_query_auth?component_access_token=$component";
      $data['component_appid'] = $config['appId'];
      $data['authorization_code'] = $code;
      $send_result = https_request($url, json_encode($data));
      $result = json_decode($send_result,true);
      $save['authorizer_access_token'] = $result['authorization_info']['authorizer_access_token'];
      $save['authorizer_refresh_token'] = $result['authorization_info']['authorizer_refresh_token'];
      $save['authorizer_appid'] = $result['authorization_info']['authorizer_appid'];//授权方appid
      $save['authorizer_time'] = time();
      $save['shop_id'] = session('shopUser.id');
      //file_put_contents ('shop_id.txt' ,'session_'.session('shopUser.id'));
      $ok = D('wx_token')->add($save);
   }
   //更新authorizer_access_token
  function get_authorizer_access_token($shop_id){
    $config = C('WXKAI_CONFIG');
    $shop['shop_id'] = $shop_id;
    $auth = D('wx_token')->where($shop)->field('authorizer_access_token,authorizer_time,authorizer_refresh_token,authorizer_appid')->find();
        //如果此token存在 但过期 则重新生成 2小时有效时间
        $two = 60*60*1.8;
        $time = time()-$auth['authorizer_time'];
        file_put_contents ('time1.txt' ,date('Y-m-d H:i:s',$auth['authorizer_time']));
       if($time>$two){
        $component = get_component_access_token();
        $url = "https://api.weixin.qq.com/cgi-bin/component/api_authorizer_token?component_access_token=$component";
        $data['component_appid'] = $config['appId']; //第三方平台appid
        $data['authorizer_refresh_token'] = $auth['authorizer_refresh_token']; //授权方的刷新令牌
        $data['authorizer_appid'] = $auth['authorizer_appid'];    //授权方appid
        $send_result = https_request($url, json_encode($data));
        $result = json_decode($send_result,true);
        //更新
        if($result['authorizer_access_token']){
          $add['authorizer_access_token'] = $result['authorizer_access_token']; 
          $add['authorizer_time'] = time();
        }                            
        $ok = D('wx_token')->where($shop)->save($add);
        return $result['authorizer_access_token'];
       }else{
         return $auth['authorizer_access_token'];
       }

     
  }


  //获取授权方公众账号信息
  function wechat_info(){
   $config = C('WXKAI_CONFIG');
   $data['shop_id'] = session('shopUser.id');
   $app = D('wx_token')->where($data)->field('authorizer_appid')->find();
   $send['component_appid'] = $config['appId']; //第三方平台appid
   $send['authorizer_appid'] = $app['authorizer_appid'];
   $component = get_component_access_token();
   $url = "https://api.weixin.qq.com/cgi-bin/component/api_get_authorizer_info?component_access_token=$component";
   $send_result = https_request($url, json_encode($send));
   //file_put_contents ( 'wechat_info.txt' ,$send_result);
   $results = json_decode($send_result,true);
   $result = $results['authorizer_info'];
   $arr['nick_name'] = $result['nick_name'];
   $arr['head_img'] = $result['head_img'];
   $arr['user_name'] = $result['user_name'];
   $arr['service_type_info'] = $result['service_type_info']['id'];
   $arr['verify_type_info'] = $result['verify_type_info']['id'];
   $arr['business_info'] = json_encode($result['business_info']);
   $arr['qrcode_url'] = $result['qrcode_url'];
   $arr['authorization_appid'] = $results['authorization_info']['authorization_appid'];
   $arr['func_info'] = json_encode($results['authorization_info']['func_info']);
   $arr['shop_id'] = session('shopUser.id');
   D('shop_authinfo')->add($arr);
  }


 /**
 * http/https请求函数
 */
function https_request($url,$data=null){
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,FALSE);
        if(!empty($data)){
            curl_setopt($curl,CURLOPT_POST,1);
            curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
        }
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

 ?>