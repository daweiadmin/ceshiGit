<?php 
namespace Home\Controller;
use Think\Controller;
class WeixinController extends Controller{



   public function weixin(){   
        /*验证token*/
        
       /*  if (!$this->checkSignature()) {  
                      // 验证
               echo ("微信消息签名错误");
               file_put_contents ( '123.txt' ,'微信消息签名错误'); 
            } else {
                echo $_GET['echostr'];exit;
                file_put_contents ( '321.txt' ,'微信服务器认证通过666'); 
                //echo ("微信服务器认证通过:" . $_GET['echostr']);
            }*/
           // $this->responseMsg();
            $this->caidan();//公众号菜单
    }   

    /**
     * 验证签名
     * @return bool
     */
    private function checkSignature() {

        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce     = $_GET["nonce"];
        $token = C('TOKEN'); 
        //$token  = $this->wechat_config['w_token'];
        $tmpArr = array($token, $timestamp, $nonce);
        file_put_contents ( '456.txt' ,$tmpArr); 
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        return $tmpStr == $signature;
    }

  /*回复消息*/
  public function responseMsg()
    {
      $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
     if(!$postStr){
      $postStr = file_get_contents("php://input");
     }
     if(empty($postStr)){  
     	file_put_contents ( 'wx_t.txt' ,'没有推送消息');
       exit;
     }       
      
      libxml_disable_entity_loader(true);
      $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA); 
      
      $fromUsername = $postObj->FromUserName;
      $toUsername = $postObj->ToUserName;
      $keyword = trim($postObj->Content);
      $time = time();
      $event = $postObj->Event;
      $EventKey = $postObj->EventKey; 
     
      /*扫描二维码*/
       if ($event == "subscribe"&&$EventKey) {// 情景：二维码扫描并且未关注公众号
            $this->doUserReg($postObj,$q=1);
        } 
        if ($EventKey&&$event == "SCAN") {// 情景：二维码扫描但是<已关注>公众号
            $this->doUserReg($postObj,$q=2);
        } 
       /*关注事件*/
       if ($event == "subscribe") {// 情景：二维码扫描并且未关注公众号
            $this->guanzhu($postObj);
        } 

    }
    /*关注事件*/
	     public function guanzhu(&$postObj){
	     	//file_put_contents ( 'wx_t2.txt' ,'进入到注册会员111');
            $openid = (string) $postObj -> FromUserName;//发送方帐号（一个OpenID）
            // 判断是否已经注册
            $res = M('member')->where("wx_openid = '$openid'")->count();
             if(!$res||$res==0){
             	
                $access_token2 = $this->get_access_token();
                $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token2&openid=$openid";
                $subscribe_info = httpRequest($url,'GET');
                $subscribe_info = json_decode($subscribe_info,true);
                $datas = array(
                    //'refe_id'=>$qrscene,//推荐人id
                    'wx_openid'=>$openid,
                    'oauth'=>'公众号关注',
                    //base64_encode() 如果昵称存在特殊字符 存不进数据库 可尝试入库之前，使用 Base64 编码出库后，使用 Base64 解码
                    'wx_name'=>$subscribe_info['nickname'],
                    'sex'=>$subscribe_info['sex'],
                    'wx_pic'=>$subscribe_info['headimgurl'],
                    'time' => time()
                );
                $ok = D('member')->add($datas);
                if($ok){
                	$sess['id'] = $ok;
                  session('memberUser',$sess);//登录状态//登录状态
                  /*生成推广二维码*/
                    ob_end_clean();
                    //file_put_contents ( '3.txt' ,'二维码生成开始22');
                    $link_url = erweima_url($ok);
                    file_put_contents ( 'erwei.txt' ,$link_url);
      			        $level=3;  
      			        $size=4;  
      			        Vendor('phpqrcode.phpqrcode');  
      			        $errorCorrectionLevel =intval($level) ;//容错级别  
      			        $matrixPointSize = intval($size);//生成图片大小  
      			        //生成二维码图片  
      			        $object = new \QRcode();  
      			        $path = "Public/erweima/";
      			        $file = $path.'erweima'.$ok.".png";
      			        //print_r($url);exit;
      			        $object->png($link_url, $file, $errorCorrectionLevel, $matrixPointSize, 2); 
      			        $sss['erweima'] = '/Public/erweima/erweima'.$ok.".png";
      			        $sss['erweima_time'] = time()+2548800;//临时二维码 有效时间30天 提前12个小时更新 到  
      			        D('member')->where(array('id'=>$ok))->save($sss);
                    /*注册通知*/
                    $time = date("Y-m-d H:i:s",time());
                    huanying($openid,$ok,$time);
                }

             }else{
              $sess['id'] = $res['id'];
              session('memberUser',$sess);//登录状态
             //	session('memberUser_id',$res['id']);//登录状态
             }
   

	     }



/*扫描二维码事件*/
        private function doUserReg(&$postObj,$q){
        $qrscene = '';
        // 获取$qrscene，也就是代理id
        if ($q==1) {
            // 情景：二维码扫描并且未关注公众号
            $qrscene = preg_replace("/qrscene_/is", "", $postObj->EventKey);
        } else if ($q==2) {
            // 情景：二维码扫描但是<已关注>公众号
            $qrscene = intval($postObj->EventKey);
        }
        if ($qrscene > 0) {
                     $textTpl = "<xml>
                                <ToUserName><![CDATA[%s]]></ToUserName>
                                <FromUserName><![CDATA[%s]]></FromUserName>
                                <CreateTime>%s</CreateTime>
                                <MsgType><![CDATA[%s]]></MsgType>
                                <Content><![CDATA[%s]]></Content>
                                <FuncFlag>0</FuncFlag>
                                </xml>";
            $openid = (string) $postObj -> FromUserName;//发送方帐号（一个OpenID）
            // 情景Id有效 判断是否已经注册
            $res = M('member')->where("wx_openid = '$openid'")->find();
            if(!$res||empty($res)){
                $access_token2 = $this->get_access_token();
                $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token2&openid=$openid";
                $subscribe_info = httpRequest($url,'GET');
                $subscribe_info = json_decode($subscribe_info,true);
                $datas = array(
                    'refe_id'=>$qrscene,//推荐人id
                    'wx_openid'=>$openid,
                    'oauth'=>'扫码关注',
                    'wx_name'=>$subscribe_info['nickname'],
                    'sex'=>$subscribe_info['sex'],
                    'wx_pic'=>$subscribe_info['headimgurl'],
                    'time' => time()
                );
                $ok = D('member')->add($datas);

                //推送消息 
                if($ok){
                	$sess['id'] = $ok;
                  session('memberUser',$sess);//登录状态
                  /*发送注册欢迎通知*/
                    $time = date("Y-m-d H:i:s",time());
                    huanying($openid,$ok,$time);
                    //获取推荐人昵称
                    $ref['id'] = $qrscene;
                    $puserinfo = M('member')->where($ref)->find(); 
                    /*给推荐人 发送粉丝提醒*/
                    $openid2 = $puserinfo['wx_openid'];
                    $nikname = $subscribe_info['nickname'];
                    $send = new_mem_tosend($openid2,$nikname,$ok);
                    if($send=='ok'){
                       /*生成推广二维码*/
	                    ob_end_clean();
	                    //file_put_contents ( '3.txt' ,'二维码生成开始22');
	                    $link_url = erweima_url($ok);
	                    file_put_contents('erwei.txt',$link_url);
      				        $level=3;  
      				        $size=4;  
      				        Vendor('phpqrcode.phpqrcode');  
      				        $errorCorrectionLevel =intval($level) ;//容错级别  
      				        $matrixPointSize = intval($size);//生成图片大小  
      				        //生成二维码图片  
      				        $object = new \QRcode();  
      				        $path = "Public/erweima/";
      				        $file = $path.'erweima'.$ok.".png";
      				        //print_r($url);exit;
      				        $object->png($link_url, $file, $errorCorrectionLevel, $matrixPointSize, 2); 
      				        $sss['erweima'] = '/Public/erweima/erweima'.$ok.".png";
      				        $sss['erweima_time'] = time()+2548800;//临时二维码 有效时间30天 提前12个小时更新 到  
      				        D('member')->where(array('id'=>$ok))->save($sss);
                    }else{
                      exit('false');
                    }
                }else{  
		              exit('系统错误！');
		           }
            }else{ 
              $sess['id'] = $res['id'];
              session('memberUser',$sess);//登录状态
	            $time = date("Y-m-d H:i:s",time());
              huanying($openid,$res['id'],$time);
           }
        }
    }

     public function caidan(){
      
   	    $access_token = $this->get_access_token(); 
   	    $curl ="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$access_token";
   	    $jsonmenu = '{
				     "button":[     
				      {
				           "name":"个人中心",
                   "url":"http://redbag.lingcheng888.com/index.php/home/index/index"
				           
				       },
				     
				       ]
				 }'; 
        
            ' {
                 "button":[
                 {    
                      "type":"click",
                      "name":"今日歌曲",
                      "key":"V1001_TODAY_MUSIC"
                  },
                  {
                       "name":"菜单",
                       "sub_button":[
                       {    
                           "type":"view",
                           "name":"搜索",
                           "url":"http://www.soso.com/"
                        }]
                        {
                             "type":"miniprogram",
                             "name":"wxa",
                             "url":"http://mp.weixin.qq.com",
                             "appid":"wx286b93c14bbf93aa",
                             "pagepath":"pages/lunar/index"
                         },
                        {
                           "type":"click",
                           "name":"赞一下我们",
                           "key":"V1001_GOOD"
                        }]
                   }]
             }'
				return $access_token = httpRequest($curl,POST,$jsonmenu);
						 
            }

      private function get_access_token(){
        $t['id'] = 1;
        $token = D('wx_token')->where($t)->find();
        $two = 60*60*2;
        $time = time()-$token['time'];
        //判断是否过了缓存期
        if($time>$two){
          $wechat = C('WEIXINPAY_CONFIG');
          $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$wechat[APPID]}&secret={$wechat[APPSECRET]}";
          $return = httpRequest($url,'GET');
          $return = json_decode($return,1);
          $data['access_token'] = $return['access_token'];
          $data['time'] = time();
          $a['id'] = 1;
          $aa = D('wx_token')->where($a)->save($data);
          return $return['access_token'];
        }else{
          return $token['access_token'];
        }
        
        
    }





}