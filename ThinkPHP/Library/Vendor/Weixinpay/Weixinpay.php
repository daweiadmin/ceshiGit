<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

// 定义时区
ini_set('date.timezone','Asia/Shanghai');

class Weixinpay {
    // 定义配置项
    private $config=array(
        'APPID'              => 'wxca05d393a6bda86b', // 微信支付APPID
        'MCHID'              => '1516034011 ', // 微信支付MCHID 商户收款账号
        'KEY'                => 'wlk287dSEG32kIMuBBnp33L1KPobBffS', // 微信支付KEY
        'APPSECRET'          => '45fc154c57fed86920813d7b340bcfc3',  //公众帐号secert
        'NOTIFY_URL'         => 'http://hbjrxny.com/index.php/home/wxpay/notify', // 接收支付状态的连接  改成自己的域名
        );

    // 构造函数
    public function __construct(){
        // 如果是在thinkphp中 那么需要补全/Application/Common/Conf/config.php中的配置
        // 如果不是在thinkphp框架中使用；那么注释掉下面一行代码；直接补全 private $config 即可
        $this->config=C('WEIXINPAY_CONFIG');
    }



   //获取+++++++++++++++++++++++++++++++++++++++++++++++++++openid
   public function GetOpenid($baseUrl)
    {
        //通过code获得openid
        if (!isset($_GET['code'])){
            //触发微信返回code码
            $url = $this->__CreateOauthUrlForCode($baseUrl);
            //print_r($url);exit;
            Header("Location: $url");
            exit();
        } else {
            //获取code码，以获取openid
            $code = $_GET['code'];
            //print_r($code);exit;
            $openid = $this->getOpenidFromMp($code);
            return $openid;
        }
    }

        /**
     * 
     * 构造获取code的url连接
     * @param string $redirectUrl 微信服务器回跳的url，需要url编码
     * 
     * @return 返回构造好的url
     */
    private function __CreateOauthUrlForCode($redirectUrl)
    {
        $config = $this->config;
        $urlObj["appid"] = $config['APPID'];
        $urlObj["redirect_uri"] = "$redirectUrl";
        $urlObj["response_type"] = "code";
        $urlObj["scope"] = "snsapi_userinfo";
        $urlObj["state"] = "STATE"."#wechat_redirect";
        $bizString = $this->ToUrlParams($urlObj);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?".$bizString;
    }

  public function GetOpenidFromMp($code)
    {
        $config = $this->config;
        $url = $this->__CreateOauthUrlForOpenid($code);
        //初始化curl
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->curl_timeout);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        if($config['CURL_PROXY_HOST'] != "0.0.0.0" 
            && $config['CURL_PROXY_PORT'] != 0){
            curl_setopt($ch,CURLOPT_PROXY, $config['CURL_PROXY_HOST']);
            curl_setopt($ch,CURLOPT_PROXYPORT,$config['CURL_PROXY_PORT']);
        }
        //运行curl，结果以jason形式返回
        $res = curl_exec($ch);
        curl_close($ch);
        //取出openid
       /* $data = json_decode($res,true);
        $this->data = $data;
        $openid = $data['openid'];*/
        return $res;
    }

    /**
     * 
     * 拼接签名字符串
     * @param array $urlObj
     * 
     * @return 返回已经拼接好的字符串
     */
    private function ToUrlParams($urlObj)
    {
        $buff = "";
        foreach ($urlObj as $k => $v)
        {
            if($k != "sign"){
                $buff .= $k . "=" . $v . "&";
            }
        }
        
        $buff = trim($buff, "&");
        return $buff;
    }
    
        /**
     * 
     * 构造获取open和access_toke的url地址
     * @param string $code，微信跳转带回的code
     * 
     * @return 请求的url
     */
    private function __CreateOauthUrlForOpenid($code)
    {   $config = $this->config;
        $urlObj["appid"] = $config['APPID'];
        $urlObj["secret"] = $config['APPSECRET'];
        $urlObj["code"] = $code;
        $urlObj["grant_type"] = "authorization_code";
        $bizString = $this->ToUrlParams($urlObj);
        return "https://api.weixin.qq.com/sns/oauth2/access_token?".$bizString;
    }


   //++++++++++++++++++++++++++++++++++获取openid结束


    /**
     * 统一下单
     * @param  array $order 订单 必须包含支付所需要的参数 body(产品描述)、total_fee(订单金额)、out_trade_no(订单号)、product_id(产品id)、trade_type(类型：JSAPI，NATIVE，APP)
     */
    public function unifiedOrder($order){
        // 获取配置项
        $weixinpay_config=$this->config;
        //print_r($weixinpay_config);exit;
        $config=array(
            'appid'=>$weixinpay_config['APPID'],
            'mch_id'=>$weixinpay_config['MCHID'],
            'nonce_str'=>'test',
            'spbill_create_ip'=>'47.92.53.70',
            'notify_url'=>$weixinpay_config['NOTIFY_URL']

            );
        //print_r($config);exit;
        // 合并配置数据和订单数据
        $data=array_merge($order,$config);
        // 生成签名
        $sign=$this->makeSign($data);
        $data['sign']=$sign;
        $xml=$this->toXml($data);
        $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';//接收xml数据的文件
        $header[] = "Content-type: text/xml";//定义content-type为xml,注意是数组
        $ch = curl_init ($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 兼容本地没有指定curl.cainfo路径的错误
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        $response = curl_exec($ch);
        if(curl_errno($ch)){
            // 显示报错信息；终止继续执行
            die(curl_error($ch));
        }
        curl_close($ch);
        $result=$this->toArray($response);
        // 显示错误信息
        if ($result['return_code']=='FAIL') {
            die($result['return_msg']);
        }
        $result['sign']=$sign;
        $result['nonce_str']='test';
        return $result;
    }


    /**
     * 验证
     * @return array 返回数组格式的notify数据
     */
    public function notify(){
        // 获取xml
        $xml=file_get_contents('php://input', 'r'); 
        //file_put_contents ('66666666.txt' ,$xml);
        // 转成php数组
        $data=$this->toArray($xml);
        // 保存原sign
        $data_sign=$data['sign'];
        // sign不参与签名
        unset($data['sign']);
        $sign=$this->makeSign($data);
        // 判断签名是否正确  判断支付状态
        if ($sign===$data_sign && $data['return_code']=='SUCCESS' && $data['result_code']=='SUCCESS') {
            $result=$data;
        }else{
            $result=false;
        }
        // 返回状态给微信服务器
        if ($result) {
            $str='<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';
        }else{
            $str='<xml><return_code><![CDATA[FAIL]]></return_code><return_msg><![CDATA[签名失败]]></return_msg></xml>';
        }
        echo $str;
        return $result;
    }

    /**
     * 输出xml字符
     * @throws WxPayException
    **/
    public function toXml($data){
        if(!is_array($data) || count($data) <= 0){
            throw new WxPayException("数组数据异常！");
        }
        $xml = "<xml>";
        foreach ($data as $key=>$val){
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml; 
    }

    /**
     * 生成签名
     * @return 签名，本函数不覆盖sign成员变量，如要设置签名需要调用SetSign方法赋值
     */
    public function makeSign($data){
        // 去空
        $data=array_filter($data);
        //签名步骤一：按字典序排序参数
        ksort($data);
        $string_a=http_build_query($data);
        $string_a=urldecode($string_a);
        //签名步骤二：在string后加入KEY
        $config=$this->config;
        $string_sign_temp=$string_a."&key=".$config['KEY'];
        //签名步骤三：MD5加密
        $sign = md5($string_sign_temp);
        // 签名步骤四：所有字符转为大写
        $result=strtoupper($sign);
        return $result;
    }

    /**
     * 将xml转为array
     * @param  string $xml xml字符串
     * @return array       转换得到的数组
     */
    public function toArray($xml){   
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $result= json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);        
        return $result;
    }

    /**
     * 获取jssdk需要用到的数据
     * @return array jssdk需要用到的数据
     */
    public function getParameters($indent_id,$attach=-1){
        // 获取配置项
             $config=$this->config;
     
             /*$order_pay = D('indent')->where(array('id'=>$indent_id))->find();
             $member = D('member')->where(array('id'=>$order_pay['member_id']))->find();*/
             $openid = $member['wx_openid'];
             $ref_id = session('get_refe_id');
             $order=array(
                'body'=>'test',// 商品描述（需要根据自己的业务修改）
                'total_fee'=>1,// 订单金额  以(分)为单位（需要根据自己的业务修改）
                'out_trade_no'=>'123456789',// 订单号（需要根据自己的业务修改）
                'product_id'=>1,// 分享（需要根据自己的业务修改）
                'trade_type'=>'JSAPI',// JSAPI公众号支付
                'openid'=>$openid,// 获取到的openid
                'attach'=>''//附加参数 如果存在分享 购买 推荐人
            );
             //file_put_contents('./order.text', $order);
            // 统一下单 获取prepay_id
            $unified_order=$this->unifiedOrder($order);
 //print_r($unified_order);exit;
            // 获取当前时间戳
            $time=time();
            // 组合jssdk需要用到的数据
            $data=array(
                'appId'=>$config['APPID'], //appid
                'timeStamp'=>strval($time), //时间戳
                'nonceStr'=>$unified_order['nonce_str'],// 随机字符串
                'package'=>'prepay_id='.$unified_order['prepay_id'],// 预支付交易会话标识
                'signType'=>'MD5'//加密方式
            );

            // 生成签名
            $data['paySign']=$this->makeSign($data);
            return $data;
        
    }

    /**
     * 生成支付二维码
     * @param  array $order 订单 必须包含支付所需要的参数 body(产品描述)、total_fee(订单金额)、out_trade_no(订单号)、product_id(产品id)、trade_type(类型：JSAPI，NATIVE，APP)
     */
    public function pay($order){
        Vendor('phpqrcode.phpqrcode'); 
        $object = new \QRcode();
        $result=$this->unifiedOrder($order);
        return $result['code_url'];
        /*$decodeurl=urldecode($result['code_url']);
        $object->png($decodeurl);*/
    }

    /**
     * curl 请求http
     */
    public function curl_get_contents($url){
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);                //设置访问的url地址
        // curl_setopt($ch,CURLOPT_HEADER,1);               //是否显示头部信息
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);               //设置超时
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);   //用户访问代理 User-Agent
        curl_setopt($ch, CURLOPT_REFERER,$_SERVER['HTTP_HOST']);        //设置 referer
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);          //跟踪301
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        //返回结果
        $r=curl_exec($ch);
        curl_close($ch);
        return $r;
    }




}
