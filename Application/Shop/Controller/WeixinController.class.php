<?php 
namespace Shop\Controller;
use Think\Controller;
class WeixinController extends Controller {
  
		 public function get_url(){
		 	//$a = $_SERVER['DOCUMENT_ROOT'];
		 	//print_r($a);exit;
		 	
					define('LOGPATH','wx_ticket');
          Vendor('wx_kai.wxBizMsgCrypt');
					//以下三个变量，自己去开放平台上管理中心根据实际情况填写。
					$config = C('WXKAI_CONFIG');
					$encodingAesKey = $config['encodingAesKey']; 
					$token = $config['token'];
					$appId = $config['appId'];
					$timeStamp  = empty($_GET['timestamp'])     ? ""    : trim($_GET['timestamp']) ;
					$nonce      = empty($_GET['nonce'])     ? ""    : trim($_GET['nonce']) ;
					$msg_sign   = empty($_GET['msg_signature']) ? ""    : trim($_GET['msg_signature']) ;
					$encryptMsg = file_get_contents('php://input');
					//file_put_contents(LOGPATH.'/yuanwen.log', $encryptMsg);
					$pc = new \WXBizMsgCrypt($token, $encodingAesKey, $appId);

					$xml_tree = new \DOMDocument();
					$xml_tree->loadXML($encryptMsg);
					$array_e = $xml_tree->getElementsByTagName('Encrypt');
					$encrypt = $array_e->item(0)->nodeValue;


					$format = "<xml><ToUserName><![CDATA[toUser]]></ToUserName><Encrypt><![CDATA[%s]]></Encrypt></xml>";
					$from_xml = sprintf($format, $encrypt);
					$this->logResult('/form.log', $from_xml);
					// 第三方收到公众号平台发送的消息
					$msg = '';
					$errCode = $pc->decryptMsg($msg_sign, $timeStamp, $nonce, $from_xml, $msg);
					if ($errCode == 0) {
					    //print("解密后: " . $msg . "\n");
					    $xml = new \DOMDocument();
					    $xml->loadXML($msg);
					    $array_e = $xml->getElementsByTagName('ComponentVerifyTicket');
					    $component_verify_ticket = $array_e->item(0)->nodeValue;
              if($component_verify_ticket){
					      file_put_contents(LOGPATH.'/ticket.log', $component_verify_ticket);
               }
					    $this->logResult('/msgmsg.log','解密后的component_verify_ticket是：'.$component_verify_ticket);

					    echo 'success';

					} else {
					   $this->logResult('/error.log','解密后失败：'.$errCode);
					    print($errCode . "\n");
					}


		    }

		   public function logResult($path,$data){
				    file_put_contents(LOGPATH.$path, '['.date('Y-m-d : h:i:sa',time()).']'.$data."\r\n",FILE_APPEND);
				}


	      public function auth(){
            $shop['shop_id'] = session('shopUser.id');
            $quan = D('wx_token')->where($shop)->field('authorizer_access_token')->find();
            if($quan['authorizer_access_token']){
             $auth=1;
            }else{
              $auth=-1;
              $config = C('WXKAI_CONFIG');
              $component_appid = $config['appId'];
              $pre_auth_code = get_pre_auth_code();
              $redirect_uri = 'http://redbag.lingcheng888.com/index.php/shop/weixin/auth_return_url';//回调路径
              $auth_type = 1;//1公众号 2小程序 3两个+
              $url = "https://mp.weixin.qq.com/cgi-bin/componentloginpage?component_appid=$component_appid&pre_auth_code=$pre_auth_code&redirect_uri=$redirect_uri&auth_type=$auth_type";
              $this->assign('jump_url',$url);
            }
            $this->assign('auth',$auth);
            $this->display();
            
	      }
         //回调URI，
          public function auth_return_url(){
           //$a = get_component_access_token();
           //print_r($a);exit;
            $code = $_GET['auth_code'];
            //获取authorizer_access_token和authorizer_refresh_token 并存储起来
             $authorizer_token = set_authorizer_token($code);
            //把授权微信公众号信息存储起来
            $data['authorizer_appid'] = $result['authorizer_appid'];
            $have = D('shop_authinfo')->where($data)->count();
            if($have==0){
              wechat_info();
            }
           $this->display();
          }



//消息与事件接收URL
 public function callback_url(){
      //$a = $_SERVER['DOCUMENT_ROOT'];
      //print_r($a);exit;
      
          define('LOGPATH','');
          Vendor('wx_kai.wxBizMsgCrypt');
          //以下三个变量，自己去开放平台上管理中心根据实际情况填写。
          $config = C('WXKAI_CONFIG');
          $encodingAesKey = $config['encodingAesKey']; 
          $token = $config['token'];
          $appId = $config['appId'];
          $timeStamp  = empty($_GET['timestamp'])     ? ""    : trim($_GET['timestamp']) ;
          $nonce      = empty($_GET['nonce'])     ? ""    : trim($_GET['nonce']) ;
          $msg_sign   = empty($_GET['msg_signature']) ? ""    : trim($_GET['msg_signature']) ;
          $encryptMsg = file_get_contents('php://input');
          //file_put_contents(LOGPATH.'/yuanwen.log', $encryptMsg);
          $pc = new \WXBizMsgCrypt($token, $encodingAesKey, $appId);

          $xml_tree = new \DOMDocument();
          $xml_tree->loadXML($encryptMsg);
          $array_e = $xml_tree->getElementsByTagName('Encrypt');
          $encrypt = $array_e->item(0)->nodeValue;

          $format = "<xml><ToUserName><![CDATA[toUser]]></ToUserName><Encrypt><![CDATA[%s]]></Encrypt></xml>";
          $from_xml = sprintf($format, $encrypt);
          $this->logResult('form.log', $from_xml);
          // 第三方收到公众号平台发送的消息
          $msg = '';
          $errCode = $pc->decryptMsg($msg_sign, $timeStamp, $nonce, $from_xml, $msg);
          if ($errCode == 0) {
              if($msg){
              libxml_disable_entity_loader(true);
              $postObj = simplexml_load_string($msg, 'SimpleXMLElement', LIBXML_NOCDATA); 
              
              $fromUsername = $postObj->FromUserName;
              $toUsername = $postObj->ToUserName;
              $keyword = trim($postObj->Content);
              $time = time();
              $event = $postObj->Event;
              $EventKey = $postObj->EventKey; 
              file_put_contents ( 'post_data.txt' ,$fromUsername.'--'.$toUsername.'--'.$keyword.'--'.$event.'--'.$EventKey);
              echo 'SUCCESS';
              /*扫描带参数的二维码*/
             if ($event == "subscribe"&&$EventKey) {// 情景：二维码扫描并且未关注公众号
                  $this->doUserReg($postObj);
              } 
              echo 'SUCCESS';
           }
              

          } else {
             $this->logResult('error.log','解密后失败：'.$errCode);
              print($errCode . "\n");
          }


        }
     
	

	      /*扫描二维码事件*/
        private function doUserReg(&$postObj){
			            $qrscene = '';
			           // 获取$qrscene，也就是代理id
			            // 情景：二维码扫描并且未关注公众号
			            $qrscene = preg_replace("/qrscene_/is", "", $postObj->EventKey);
			            if ($qrscene > 0) {
	                        $textTpl = "<xml>
	                                <ToUserName><![CDATA[%s]]></ToUserName>
	                                <FromUserName><![CDATA[%s]]></FromUserName>
	                                <CreateTime>%s</CreateTime>
	                                <MsgType><![CDATA[%s]]></MsgType>
	                                <Content><![CDATA[%s]]></Content>
	                                <FuncFlag>0</FuncFlag>
	                                </xml>";
			           // $openid = (string) $postObj -> FromUserName;//发送方帐号(对于某一个公众号)（一个OpenID）
                /*  $yuanshiid = (string)$postObj -> ToUserName;
                  file_put_contents ('wzceshi/yuanshiid.txt' ,$yuanshiid);
                  $info['user_name'] = $yuanshiid;//公众号原始id
                  $authinfo = D('shop_authinfo')->where($info)->field('shop_id')->find();
                  file_put_contents ('wzceshi/authinfo.txt' ,json_encode($authinfo));
                  $hop['shop_id'] = $authinfo['shop_id'];
                  $tok = get_authorizer_access_token($hop['shop_id']);
                  file_put_contents ('wzceshi/tok.txt' ,$tok);
                  $url2 = "https://api.weixin.qq.com/sns/userinfo?access_token=$tok&openid=$openid&lang=zh_CN";
                  $mem_json_data = https_request($url2);
                  file_put_contents ('wzceshi/mem_json_data.txt' ,$mem_json_data);*/
			            // 情景Id有效 判断是否已经注册
                  $dat['code_id'] = $qrscene;
                  $have = D('guanzhu_code_member')->where($dat)->find();
                  $memos['id'] = $have['member_id'];
			            $res = M('member')->where($memos)->find();
                  $openid = $res['wx_openid'];
                  //file_put_contents('member.text',json_encode($res));
			            if(!$res||!empty($res)){
			            	$code = $qrscene;//活动id
			            	$nnn['id'] = $code;
			            	$sta = D('code')->where($nnn)->field('status,activity_id')->find();
			            	if($sta['status']>1){exit;}//二维码已使用
			            	$act['activity_id'] = $sta['activity_id'];
			            	$act['member_id'] = $res['id'];
			            	$have = D('get_record')->where($act)->count();
			            	if($have>0){ exit;}//已领取过奖励
                            $this->get_money($code,$openid);
			                
			            }
			        }
          }

   //领取奖励
	    public function get_money($code,$openid){
            
             $data['id'] = $code;
             $code = D('code')->where($data)->find();
              if($code['status']>1){
                return show(0,'您已领取奖励不能重复领取');
             }
             if($code['activity_prize_id']==0){
               return show(1,'谢谢参与');
             }
             $pri['id'] = $code['activity_prize_id'];
             $prize = D('activity_prize')->where($pri)->find();
             // file_put_contents('prize.text',json_encode($prize));
             switch ($prize['prize_type']) {
             	case '1': //现金红包,$type=1 直接领取
                 $res = $this->rebagpay($pri['id'],$code['id'],$type=1,$openid);
                 $result = json_decode($res,true);
                 return show($result['status'],$result['result']);
             		break;
             	case '2': //随机红包
             		$res = $this->rebagpay($pri['id'],$code['id'],$type=1,$openid);
                $result = json_decode($res,true);
                return show($result['status'],$result['result']);
             		break;
             	case '3'://兑奖券
             	     $tck['member_id'] = session('memberUser.id');
             	     $tck['ticket_type'] = 1;//兑换券
             	     $tck['ticket_id'] = $prize['prize'];
                   $tck['activity_id'] = $prize['activity_id'];
                   $tck['time'] = time();
             	     $ok = D('member_ticket')->add($tck);
             	     if($ok){
                             $save['member_id'] = session('memberUser.id');
    			             $save['prize_id'] = $code['activity_prize_id'];
    			             $save['code_id'] = $code['id'];
    			             $save['activity_id'] = $prize['activity_id'];
    			             $save['prize_type'] = 3;
    			             $save['prize'] = $prize['prize'];
    			             $save['time'] = time();
    			             $ok2 = D('get_record')->add($save);
                         if($ok2){
                          $stt['status'] = 2;
                         	$ok3 = D('code')->where($data)->save($stt);
                          $heh['hexiao_code'] = set_hexiao_code($ok);
                          $heh['hexiao_code_sn'] = set_code_sn(4,1);
                          D('member_ticket')->where(array('id'=>$ok))->save($heh);
                          //生成核销码
                         }
             	     }
                       //发送通知
                       $ticket['id'] = $prize['prize'];
                       $tick = D('ticket')->where($ticket)->field('name')->find();
                       $act['id'] = $prize['activity_id'];
                       $actname = D('activity')->where($ticket)->field('act_name')->find();
                       $activity = $actname['act_name'];
                       $time = date('Y-m-d H:i:s',time());
                       $openid = $memb['wx_openid'];
                       $money = '兑换券：'.$tick['name'];
                       send_ticket($openid,$money,$activity,$time);
             		  return show(1,'领取成功',$ok2);
             		break;

             	default://优惠券
             		   $tck['member_id'] = session('memberUser.id');
             	     $tck['ticket_type'] = 2;//优惠券
             	     $tck['ticket_id'] = $prize['prize'];
                   $tck['activity_id'] = $prize['activity_id'];
                   $tck['time'] = time();
             	     $ok = D('member_ticket')->add($tck);
             	     if($ok){
                       $save['member_id'] = session('memberUser.id');
    			             $save['prize_id'] = $code['activity_prize_id'];
    			             $save['code_id'] = $code['id'];
    			             $save['activity_id'] = $prize['activity_id'];
    			             $save['prize_type'] = 4;
    			             $save['prize'] = $prize['prize'];
    			             $save['time'] = time();
    			             $ok2 = D('get_record')->add($save);
                         if($ok2){
                          $ssa['status'] = 2;
                         	$ok3 = D('code')->where($data)->save($ssa);
                          $heh['hexiao_code'] = set_hexiao_code($ok);
                          $heh['hexiao_code_sn'] = set_code_sn(4,1);
                          D('member_ticket')->where(array('id'=>$ok))->save($heh);
                         }
             	     }
                        //发送通知
                       $ticket['id'] = $prize['prize'];
                       $tick = D('ticket')->where($ticket)->field('name')->find();
                       $act['id'] = $prize['activity_id'];
                       $actname = D('activity')->where($ticket)->field('act_name')->find();
                       $activity = $actname['act_name'];
                       $time = date('Y-m-d H:i:s',time());
                       $openid = $memb['wx_openid'];
                       $money = '优惠券：'.$tick['name'];
                       send_ticket($openid,$money,$activity,$time);
                    return show(1,'领取成功',$ok2);
             		break;
                }

                if($ok2){
    	               return show(1,'领取成功',$ok2);
    	         	 }else{
    	         	   return show(0,'领取失败');
    	         	 } 

            


           }

       public function rebagpay($prize,$code,$type,$openid){
          header("Content-type:text/html;charset=utf-8");
          //业务逻辑
           file_put_contents ('openid_rebagpay.txt' ,$openid);
             $data_p['id'] = $prize;
             $prize_data = D('activity_prize')->where($data_p)->find();
            // file_put_contents('share_2.text', $prize_data);
             //print_r($prize_data);exit;
             if($prize_data['prize_type']==1){//现金红包
               $money = $prize_data['prize'];
             }
             if($prize_data['prize_type']==2){
               $sui['prize_id'] = $prize;
               $sui['status'] = 0;
               $suiji = D('suijibag')->where($sui)->find();
               $money = $suiji['money'];
             }
            // print_r($money);exit;
             //金额
             $active['id'] = $prize_data['activity_id'];
             $act_n = D('activity')->where($active)->field('act_name,shop_id')->find();
             $shop_name = shop_name($act_n['shop_id']);
             $act_name = $act_n['act_name'];
             $memo['id'] = session('memberUser.id');
             $open = D('member')->where($memo)->field('id,wx_openid')->find();

            Vendor('Weixinpay.Redbagwxpay');
            //$money = 1; //最低1元，单位分
            $sender = "领程科技";
            $indents = rand(1000,9999).$memo['id'].time();
            //$money2 = $money;
            //$openid = $openid;
            $shop_name2 = $shop_name;
            $activity_name = $act_name;
            $data = array();
            $data['wxappid'] = 'wx58b98e1625d1af4b';  //appid
            $data['mch_id'] = '1518635501';  //商户id
            $data['mch_billno'] = $indents;  //商户订单号
            $data['client_ip'] = $_SERVER['REMOTE_ADDR']; //Ip地址
            $data['re_openid'] = $openid;  //接收红包openid
            $data['total_amount'] = floatval($money)*100;   //付款金额，单位分
            $data['total_num'] = 1;  //红包发放总人数
            $data['send_name'] = $shop_name2; //红包发送者名称
            $data['wishing'] = '恭喜发财';  //红包祝福语
            $data['act_name'] = $activity_name;   //活动name
            $data['remark'] = '恭喜发财';  //备注信息 必填
            $data['scene_id'] = 'PRODUCT_2'; //场景
//file_put_contents('share_3.text', $data);
            //dump($data);exit;
            $url = "https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack";

            $wxpay = new \wxPay();
            /*$res = $wxpay->toXml($data);
            print_r($res);exit;*/
            $res = $wxpay->pay($url, $data);
            $return_arr = $wxpay->xmlToArray($res);
            file_put_contents('redbag_result.text', $return_arr);
            ///print_r($return_arr);exit;
            if($return_arr['result_code']=='SUCCESS'){
                 $save['member_id'] = session('memberUser.id');
                 $save['prize_id'] = $prize;
                 $save['code_id'] = $code;
                 $save['activity_id'] = $prize_data['activity_id'];
                 $save['prize_type'] = $prize_data['prize_type'];
                 $save['prize'] = $money;
                 $save['indents'] = $indents;
                 if($type==2){
                  $save['share_status'] = 1;//已分享
                 }
                 $save['time'] = time();
                 $ok3 = D('get_record')->add($save);
               if($ok3){
                 if($prize_data['prize_type']==2){//随机红包
                   //改变随机金额 的状态
                  $sj['id'] = $suiji['id'];
                  $ok2 = D('suijibag')->where($sj)->save(array('status'=>1));
                   if(!$ok2){
                     $return['status'] = 0;
                     $return['result'] = '随机金额的状态保存出错';
                     echo json_encode($return);exit;
                   }
                 }
                 $data_co['id'] = $code;
                 $ssa['status'] = 2;
                 $ok3 = D('code')->where($data_co)->save($ssa);
                 //发送通知
                 $time = date('Y-m-d H:i:s',time());
                 $content = '参加 <'.$shop_name2.'> 的“'.$activity_name.'”活动，获得活动奖励！';
                 send_redbag($openid,$money,$time,$content,$indents);

                 $return['status'] = 1;
                 $return['result'] = 'success';
                 echo json_encode($return);exit;
               }else{
                 $return['status'] = 0;
                 $return['result'] = '纪录保存出错';
                 echo json_encode($return);exit;
               }
          }

          if($return_arr['result_code']=='FAIL'){
             $return['status'] = -1;
             $return['result'] = $return_arr['return_msg'];
             echo json_encode($return);exit;
            
          }

     }







}