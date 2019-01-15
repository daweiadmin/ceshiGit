<?php 
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller{

      public function __construct(){
         parent::__construct();
        /* $xml=file_get_contents('php://input', 'r'); 
        file_put_contents ('5555.txt' ,$xml);*/
         }
         public function savedata(){
           $sss['activity_id'] = 0;
           D('code')->where('id=1')->save();

         }
   

       public function index(){
       	$redis = new \Redis();
        $redis->connect('127.0.0.1',6379);
        $redis->set('test','hello world!');
        echo $redis->get("test");
       	exit;
        Vendor('Weixinpay.Weixinpay');
            $wxpay=new \Weixinpay();
            $baseUrl = urlencode('http://'.$_SERVER['HTTP_HOST']."/index.php/home/index/index".'?'.$_SERVER['QUERY_STRING']);
           // print_r($baseUrl);exit;
            $res = $wxpay->GetOpenid($baseUrl);//获取到带有openid和accesstoken 得json字符串
            //print_r($openid);exit;
            $result = json_decode($res,true);
            $openid = $result['openid'];
            $token = $result['access_token'];
            $activityid = $_GET['activityid'];
            $user = D('member')->where(array('wx_openid'=>$openid))->find();
          if($user){
            $sess['id'] = $user['id'];
            session('memberUser',$sess);

          }else{
            $url2 = "https://api.weixin.qq.com/sns/userinfo?access_token=$token&openid=$openid&lang=zh_CN";
            $mem_json_data = $this->https_request($url2);
          //print_r($mem_json_data);exit;
            if(!$mem_json_data){
              $this->error('没有收到用户信息！');
            }
            $mem_data = json_decode($mem_json_data,true);
          //  print_r($mem_data);exit;
            if(!empty($mem_data)){
                $mem['wx_openid'] = $mem_data['openid'];
                $mem['wx_name'] = $mem_data['nickname'];//用户名
                $mem['sex'] = $mem_data['sex'];
                $mem['wx_pic'] = $mem_data['headimgurl'];//头像
                $mem['time'] = time();//头像
                $ok = D('member')->add($mem);
                if($ok){
                  $sess['id'] = $ok;
                  session('memberUser',$sess);
                }
              }
           }//member  end
        $mem['id'] = session('memberUser.id');
        $member = D('member')->where($mem)->find();
        $this->assign('member',$member);

          $this->display();
       }


    


       public function ticket(){
          $data['ticket_type'] = I('type');
          $data['member_id'] = session('memberUser.id');
          //print_r($data);exit;
          $mem_t = D('member_ticket')->where($data)->select();
        
          $arr = array();
          foreach ($mem_t as $key => $value) {
            $tic['id'] = $value['ticket_id'];
            $ticket = D('ticket')->where($tic)->field('id,name,ticket_picture,shop_id,end_time')->find();
           // dump($ticket);exit;
            $sh['id'] = $ticket['shop_id'];
            $shop = D('shop')->where($sh)->field('name')->find();
            $ticket['shop'] = $shop['name'];
            $ticket['hexiao_status'] = $value['hexiao_status'];
            $ticket['m_t_id'] = $value['id'];
            $arr[] = $ticket;
          }
         // dump($arr);exit;
          $wei_arr = array();
          $guo_arr = array();
          $yi_arr = array();
          foreach ($arr as $k => $v) {
            if($v['end_time']>time()&&$v['hexiao_status']==0){
              $wei_arr[] = $v;
            }
            if($v['hexiao_status']==1){
              $yi_arr[] = $v;
            }
            if($v['end_time']<time()&&$v['hexiao_status']==0){
              $guo_arr[] = $v;
            }
          }

          $this->assign('wei_arr',$wei_arr);
          $this->assign('yi_arr',$yi_arr);
          $this->assign('guo_arr',$guo_arr);
          $this->assign('type',$data['ticket_type']);
          $this->display();
       }

       public function note(){
         $mem['member_id'] = session('memberUser.id');
         $list = D('get_record')->where($mem)->order('id desc')->limit(20)->select();
         $this->assign('list',$list);
          $this->display();
       }

       public function ticket_info(){
         $data['id'] = I('m_t_id');
         $member_ticket = D('member_ticket')->where($data)->find();
         $this->assign('member_ticket',$member_ticket);
         $tic['id'] = $member_ticket['ticket_id'];
         $ticket = D('ticket')->where($tic)->find();
         $this->assign('ticket',$ticket);
         //门店
         $store['id'] = array('in',$ticket['store_id']); 
         $stores = D('store')->where($store)->select();
         //print_r($stores);exit;
         $this->assign('stores',$stores);
         $this->display();
       }
      
         public function notify_url2(){
        // 导入微信支付sdk
        Vendor('Weixinpay.Weixinpay');
        $wxpay=new \Weixinpay();
        $result=$wxpay->notify();
        if ($result){
            // 验证成功 修改数据库的订单状态等 $result['out_trade_no']为订单号
          $indents = $result['out_trade_no'];
          $aa['indents'] = $indents;
          $record = D('money_record')->where($aa)->find();
          $shop['id'] = $record['userid'];
          $sho = D('shop')->where($shop)->field('money')->find();
          $money['money'] = $sho['money']+$record['money'];
          $ok = D('shop')->where($shop)->save($money);
          if($ok){
            $data['status'] = 0;
            $data['full'] = $money['money'];
            $ok2 = D('money_record')->where(array('indents'=>$indents))->save($data);
            file_put_contents ('5.txt' ,$ok2);
          }
          
            
          }
        }
   



}