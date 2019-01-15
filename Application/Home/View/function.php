<?php 
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
   //file_put_contents ( 'json4.txt' ,$res);
   $result = json_decode($res,true);//有true参数 解析为数组 没有则解析为对象
  // file_put_contents ( 'json2.txt' ,$result['url']);

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



 ?>