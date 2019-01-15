<?php 
namespace Home\Controller;
use Think\Controller;
class WxpayController extends Controller{
    public function __construct(){

      parent::__construct();
    }
    public function notify(){
      /*  $xml=file_get_contents('php://input', 'r');
        libxml_disable_entity_loader(true);
        $data= json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA));
        file_put_contents('./notify.text', $data);*/
        // 导入微信支付sdk
        Vendor('Weixinpay.Weixinpay');
        $wxpay=new \Weixinpay();
        $result=$wxpay->notify();
        
        if ($result) {
          //file_put_contents('./result.text', $result['out_trade_no']);
          // 验证成功 修改数据库的订单状态等 $result['out_trade_no']为订单号
           /*支付成功*/
           $data['indents'] = $result['out_trade_no'];
           $indent = D('indent')->where($data)->find();
           //file_put_contents('./indent.text', $indent);
           $member = D('member')->where(array('id'=>$indent['member_id']))->find();
           //file_put_contents('./22.text', $member);
           /*改变订单状态*/
           $sta['status'] = 1;
           $sta['indent_start_time'] = time();
           $ok = D('indent')->where($data)->save($sta);
           /*如果会员是 普通粉丝 则变为普通会员 如果是通过 */
           if($member['level']==0){
            $bian['level'] = 1;
            //$ref = session('get_refe_id');
           // file_put_contents('11.text', $result['attach']);
            if($result['attach']!=-1&&$result['attach']){
             $bian['refe_id'] = $result['attach'];
            }
            D('member')->where(array('id'=>$indent['member_id']))->save($bian);
           }
           /*分润*/
           $fen = D('indent')->fenrun($indent['id']);

           //file_put_contents('./fen.text', $fen);
        }
    }

    /**
     * 公众号支付 必须以get形式传递 out_trade_no 参数
     * 示例请看 /Application/Home/Controller/IndexController.class.php
     * 中的weixinpay_js方法
     */
    public function pay(){
           if(IS_POST){
            //print_r($_POST);

             $ind_id['id'] = I('indent_id');
             $find = D('indent')->where($ind_id)->find();
             $add['address_id'] = I('address_id');
             if(!$add['address_id']){
              $this->error('请选择收货地址');
             }

             $a = D('indent')->where($ind_id)->save($add);
             if(!empty($a)||$a==1||$a){
              // 
              $find = D('indent')->where($ind_id)->find();
               // 导入微信支付sdk
              Vendor('Weixinpay.Weixinpay');
              $wxpay=new \Weixinpay();
            // 获取jssdk需要用到的数据
              $cah = session('get_refe_id');//分享id
              if($cah){
                $data=$wxpay->getParameters($ind_id['id']);
              }else{
                $data=$wxpay->getParameters($ind_id['id']);
              }
              
            // 将数据分配到前台页面
              $assign=array(
                'total_money' =>$find['total'],
                'data'=>json_encode($data)
                );
             $this->assign($assign);


               }
             }
             /*会员中心 代付款订单 调用支付接口*/
             if($_GET){
              $ind_id['id'] = I('indent_id');
              $find = D('indent')->where($ind_id)->find();
              if($find['address_id']==0||!$find['address_id']){
               $this->error('您未选择地址，不能支付哦亲');
              }
              Vendor('Weixinpay.Weixinpay');
              $wxpay=new \Weixinpay();
            // 获取jssdk需要用到的数据
              $data=$wxpay->getParameters($ind_id['id']);
            // 将数据分配到前台页面
              $assign=array(
                'total_money' =>$find['total'],
                'data'=>json_encode($data)
                );
              $this->assign($assign);
             }
            
        $this->display();
     }


    public function rebagpay(){
      echo 1;exit;
      header("Content-type:text/html;charset=utf-8");
      Vendor('Weixinpay.Redbagwxpay');
      //$money = 1; //最低1元，单位分
      $sender = "领程科技";
      $indents = time().rand(1000,9999);
      $money = 100;
      $openid = 'onwdU54ZLMpDOsT7wssGzBqdynvE';
      $shop_name = "领程科技";
      $activity_name = "领程科技邀你抢红包";
      $data = array();
      $data['wxappid'] = 'wx58b98e1625d1af4b';  //appid
      $data['mch_id'] = '1518635501';  //商户id
      $data['mch_billno'] = $indents;  //商户订单号
      $data['client_ip'] = $_SERVER['REMOTE_ADDR']; //Ip地址
      $data['re_openid'] = $openid;  //接收红包openid
      $data['total_amount'] = $money;   //付款金额，单位分
      $data['total_num'] = 1;  //红包发放总人数
      $data['send_name'] = $shop_name; //红包发送者名称
      $data['wishing'] = '恭喜发财';  //红包祝福语
      $data['act_name'] = $activity_name;   //活动name
      $data['remark'] = '恭喜发财';  //备注信息 必填
      $data['scene_id'] = 'PRODUCT_2'; //场景
      $url = "https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack";
      $wxpay = new \wxPay();
      /*$res = $wxpay->toXml($data);
      print_r($res);exit;*/
      $res = $wxpay->pay($url, $data);
      $return_arr = $wxpay->xmlToArray($res);
      print_r($return_arr);exit;
      if($return_arr['result_code']=='SUCCESS'){
        
      }
      if($return_arr['result_code']=='FAIL'){
        
      }

    }


    public function set_redbag(){
    

     Vendor('Weixinpay.redbag');
     $wxpay = new \Reward();
     $money = 0.3;
     $num = 1;
     $max =10;
     $min = 0.3;
     $res = $wxpay->splitReward($money,$num,$max,$min);
     
     print_r($res);exit;

    }
    //银联支付 msgSrc msgType  requestTimestamp merOrderId mid
    public function bank_pay(){
      $config = C('YINLIANPAY_CONFIG');
      $indents = $config['msgSrcId'].time();
      $data['msgSrc'] = $config['msgSrc'];  //消息来源
      $data['msgType'] = 'WXPay.jsPay';  //消息类型
      $data['requestTimestamp'] = date("Y-d-m H:i:s",time());  //报文请求时间，
      $data['merOrderId'] = $indents; //订单号
      $data['mid'] = $config['mid'];  //商户号
      $data['tid'] = $config['tid'];   //终端号
      $data['instMid'] = $config['instMid'];  //机构商户号
      $data['totalAmount'] = 1; //支付总金额，单位分
      $data['notifyUrl'] = $config['NOTIFY_URL'];  //支付结果通知地址
      $data['returnUrl'] = 'http://redbag.lingcheng888.com/index.php/home/index/index';   //网页跳转地址
      $data['subOpenId'] = 'onwdU54ZLMpDOsT7wssGzBqdynvE';
      $sign = $this->makeSign($data);
      $data['sign'] = $sign; 
      $host = 'https://qr-test2.chinaums.com/netpay-portal/webpay/pay.do?';
      $arr_url = http_build_query($data);
      //$arr_url = urldecode($arr_url);
     // print_r($arr_url);exit;
      $get_url = $host.$arr_url;
      header('Location: '.$get_url);

    }

   /* $str = '';
      foreach ($data as $key => $value) {
        $str.= $key.'='.$value.'&';
      }
      $arr_url = rtrim($str,'&');*/

     /**
      * 
     * 生成签名
     * @return 签名，本函数不覆盖sign成员变量，如要设置签名需要调用SetSign方法赋值
     */
     public function makeSign($data){
        $config = C('YINLIANPAY_CONFIG');
        // 去空
        $data=array_filter($data);
        //签名步骤一：按字典序排序参数
        ksort($data);
         $str = '';
        foreach ($data as $key => $value) {
          $str.=$key.'='.$value.'&';
        }
        $string = rtrim($str,'&');
        //签名步骤二：在string后加入KEY
        $string_sign_temp=$string.$config['KEY'];
       //print_r($string_sign_temp);exit;
        //签名步骤三：MD5加密
        $sign = MD5($string_sign_temp);
        // 签名步骤四：所有字符转为大写
        $result=strtoupper($sign);
        return $result;
    }


      public function return_back(){
         $data = file_get_contents('php://input', 'r'); 
         file_put_contents ('222yinlianpay.txt' ,$data);
         $result = $this->yanqian();
         if($result){//验签成功
           echo 'SUCCESS';exit;
         }else{
          echo 'FAILED';exit;
         }



      }

      public function yanqian(){
        header("Content-type:text/html;charset=utf-8");
        $string = file_get_contents('222yinlianpay.txt'); 
        $list = explode('&', urldecode($string));
        foreach ($list as $key => $value) {
           $kkk = explode('=',$value);
           $data[$kkk[0]] = $kkk[1];
        }
        $sign = $this->makeSign2($data);
        if($sign==$data['sign']){
          return true;
        }else{
          return false;
        }

      }

      //验签
     public function makeSign2($data){
        $config = C('YINLIANPAY_CONFIG');
        // 去空
        //$data=array_filter($data);
        //签名步骤一：按字典序排序参数
        ksort($data);
         $str = '';
        foreach ($data as $key => $value) {
         if($key!=='sign'){
          $str.=$key.'='.$value.'&';
          }
        }
        $string = rtrim($str,'&');
        //签名步骤二：在string后加入KEY
        $string_sign_temp=$string.$config['KEY'];
       //print_r($string_sign_temp);exit;
        //签名步骤三：MD5加密
        $sign = MD5($string_sign_temp);
        // 签名步骤四：所有字符转为大写
        $result=strtoupper($sign);
        return $result;
    }
      
      public function ceshi2(){
        $config = C('YINLIANPAY_CONFIG');
        $date = date("Y-d-m H:i:s",time());
        $date = urlencode($date);
        $merOrderId = "3194".time();
        $notifyUrl = urlencode($config['NOTIFY_URL']);
        $returnUrl = urlencode('http://redbag.lingcheng888.com/index.php/home/index/index');
        $restr = 'instMid=YUEDANDEFAULT&merOrderId='.$merOrderId.'&mid=898340149000005&msgSrc=WWW.TEST.COM&msgType=WXPay.jsPay&notifyUrl='.$notifyUrl.'&requestTimestamp='.$date.'&returnUrl='.$returnUrl.'&subOpenId=onwdU54ZLMpDOsT7wssGzBqdynvE&tid=88880001&totalAmount=100fcAmtnx7MwismjWNhNKdHC44mNXtnEQeJkRrhKJwyrW2ysRR';
        print_r($restr);exit;
        $sign = strtoupper(md5($restr));
          
          $host = 'https://qr-test2.chinaums.com/netpay-portal/webpay/pay.do?';
          $data_send['msgSrc'] = $config['msgSrc'];  //消息来源
          $data_send['msgType'] = 'WXPay.jsPay';  //消息类型
          $data_send['requestTimestamp'] = $date; //报文请求时间，
          $data_send['merOrderId'] = $merOrderId; //订单号
          $data_send['mid'] = $config['mid'];  //商户号
          $data_send['tid'] = $config['tid'];   //终端号
          $data_send['instMid'] = $config['instMid'];  //机构商户号
          $data_send['totalAmount'] = 100; //支付总金额，单位分
          $data_send['notifyUrl'] = $notifyUrl;  //支付结果通知地址
          $data_send['returnUrl'] =  $returnUrl;   //网页跳转地址
          $data_send['subOpenId'] = 'onwdU54ZLMpDOsT7wssGzBqdynvE';
          $data_send['sign'] = $sign;

          $arr_url = http_build_query($data_send);
          $get_url = $host.$arr_url;
          header('Location: '.$get_url);


      }
 
  


}