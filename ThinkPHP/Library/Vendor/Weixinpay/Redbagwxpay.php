<?php 
class wxPay {
    //配置参数信息
    const SHANGHUHAO = "1518635501";//商户号
    const PARTNERKEY = "FDbHW9u7V8iFFrctpE74XLtn81Imd3lf";    //api，商户后台
    //核心支付函数,参数：请求地址和参数
   public function pay($url,$obj) {
        $obj['nonce_str'] = $this->create_noncestr();    //创建随机字符串
        $stringA = $this->create_qianming($obj,false);    //创建签名
        $stringSignTemp = $stringA."&key=FDbHW9u7V8iFFrctpE74XLtn81Imd3lf"; //注：key为商户平台设置的密钥key 
        $sign = strtoupper(md5($stringSignTemp));    //签名加密并大写
        $obj['sign'] = $sign;    //将签名传入数组
        //var_dump($obj);exit;    
        $postXml = $this->toXml($obj);    //将参数转为xml格式

        //print_r($postXml);exit;
        //var_dump($postXml);exit;      
        $responseXml = $this->curl_post_ssl($url,$postXml);    //提交请求
        return $responseXml;
    }

   public function xmlToArray($xml)
    {    
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);        
        return $values;
    }
    
    //生成签名,参数：生成签名的参数和是否编码
  public  function create_qianming($arr,$urlencode) {
        $buff = "";
        ksort($arr); //对传进来的数组参数里面的内容按照字母顺序排序，a在前面，z在最后（字典序）
        foreach ($arr as $k=>$v) {
            if(null!=$v && "null" != $v && "sign" != $k) {    //签名不要转码
                if ($urlencode) {
                    $v = urlencode($v);
                }
                $buff.=$k."=".$v."&";
            }
        }
        if (strlen($buff)>0) {    
            $reqPar = substr($buff,0,strlen($buff)-1); //去掉末尾符号“&”
        }
        return $reqPar;
    }
    
    //生成随机字符串，默认32位
   public function create_noncestr($length=32) {
        //创建随机字符
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for($i=0;$i<$length;$i++) {
            $str.=substr($chars, mt_rand(0,strlen($chars)-1),1);
        }
        return $str;    
    }
    //数组转xml
   public  function ArrToXml($arr)
    {
            if(!is_array($arr) || count($arr) == 0) return '';

            $xml = "<xml>";
            foreach ($arr as $key=>$val)
            {
                    if (is_numeric($val)){
                            $xml.="<".$key.">".$val."</".$key.">";
                    }else{
                            $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
                    }
            }
            $xml.="</xml>";
            return $xml; 
    }
    public function xml($arr){
       $xml = " <xml><sign><![CDATA[".$arr['sign']."]]></sign><mch_billno><![CDATA[".$arr['mch_billno']."]]></mch_billno><mch_id><![CDATA[".$arr['mch_id']."]]></mch_id><wxappid><![CDATA[".$arr['wxappid']."]]></wxappid><send_name><![CDATA[".$arr['send_name']."]]></send_name><re_openid><![CDATA[".$arr['re_openid']."]]></re_openid><total_amount><![CDATA[".$arr['total_amount']."]]></total_amount><total_num><![CDATA[".$arr['total_num']."]]></total_num><wishing><![CDATA[".$arr['wishing']."]]></wishing><client_ip><![CDATA[".$arr['client_ip']."]]></client_ip><act_name><![CDATA[".$arr['act_name']."]]></act_name><remark><![CDATA[".$arr['remark']."]]></remark><nonce_str><![CDATA[".$arr['nonce_str']."]]></nonce_str></xml> ";
       return $xml; 
       

    }

    
 

    /**
     * 输出xml字符
     * @throws WxPayException
    **/
    public function toXml($data){
        if(!is_array($data) || count($data) <= 0){
            throw new WxPayException("数组数据异常！");
        }
        //var_dump($data);exit;
        $xml = "<xml>";
        foreach ($data as $key=>$val){
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            //var_dump($key);exit;
            }
        }
        $xml.="</xml>";
        //print_r($xml);exit;
        return $xml; 
    }

    
    //post请求网站，需要证书
   public function curl_post_ssl($url, $vars, $second=30,$aHeader=array())
    {
        $ch = curl_init();
        //超时时间
        curl_setopt($ch,CURLOPT_TIMEOUT,$second);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
        //这里设置代理，如果有的话
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        //cert 与 key 分别属于两个.pem文件
        //请确保您的libcurl版本是否支持双向认证，版本高于7.20.1  DIRECTORY_SEPARATOR 相当于 /
        curl_setopt($ch,CURLOPT_SSLCERT,dirname(__FILE__).DIRECTORY_SEPARATOR.
                'cert'.DIRECTORY_SEPARATOR.'apiclient_cert.pem');
        curl_setopt($ch,CURLOPT_SSLKEY,dirname(__FILE__).DIRECTORY_SEPARATOR.
                'cert'.DIRECTORY_SEPARATOR.'apiclient_key.pem');
        curl_setopt($ch,CURLOPT_CAINFO,dirname(__FILE__).DIRECTORY_SEPARATOR.
                'cert'.DIRECTORY_SEPARATOR.'rootca.pem');
        if( count($aHeader) >= 1 ){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
        }
        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$vars);
        $data = curl_exec($ch);
        if($data){
            curl_close($ch);
            return $data;
        }
        else {
            $error = curl_errno($ch);
            echo "call faild, errorCode:$error\n";
            curl_close($ch);
            return false;
        }
    }
    
}











 ?>