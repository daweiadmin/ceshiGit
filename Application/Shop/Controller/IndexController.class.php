<?php 
namespace Shop\Controller;
use Think\Controller;
class IndexController extends CommenController {
   public function admin(){
     $shop['id'] = $_GET['shop_id'];
     $shopdata = D('shop')->where($shop)->find();
     session('shopUser',$shopdata); 
   }
	 public function index(){
      $shop_id['id'] = session('shopUser.id');
      $find = D('shop')->where($shop_id)->find();
     // print_r($find);exit;
      $this->assign('shop_id',$find['id']);
      $this->assign('data',$find);
      $this->display();
    }



     public function machine(){
      $token = $this->get_access_token();
     // print_r($token);exit;
      $url='https://api.weixin.qq.com/scan/merchantinfo/get?access_token='.$token;
      $res = httpRequest($url,'GET');
      $return = json_decode($res,1);
      print_r($return);exit;
     }




     public function get_access_token(){
        //判断是否过了缓存期
        $wechat = C('WEIXINPAY_CONFIG');
        /*$expire_time = $wechat['web_expires'];
        if($expire_time > time()){
            return $wechat['web_access_token'];
        }*/
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$wechat[APPID]}&secret={$wechat[APPSECRET]}";

        $return = httpRequest($url,'GET');
        $return = json_decode($return,1);
       /* $web_expires = time() + 7000; // 提前200秒过期
        M('wx_user')->where(array('id'=>$wechat['id']))->save(array('web_access_token'=>$return['access_token'],'web_expires'=>$web_expires));*/
 //print_r($return);exit;
        return $return['access_token'];
    }




       //数据统计
   public function charts(){
     //$w = date("Y-m-d H:i:s",$ww);
     if(IS_POST){
     $day_num = I('day_num');
     $json_arr = date_charts($day_num);
     $arr = json_decode($json_arr,true);
     $zong = array();
     foreach ($arr as $k => $v) {
     $shop_id = session('shopUser.id');
     $list=D('get_record')
     ->table('red_get_record re,red_activity act')
     ->field('re.time,re.prize_type,re.prize,act.id')
     ->where('re.activity_id=act.id and act.shop_id="'.$shop_id.'"'.' and re.time>"'.$v[start_time].'" and re.time<"'.$v[end_time].'"')
     ->order('re.id desc')->limit($offset,$pageSize)->select();
     //总领取数量
     $total = count($list);
     //总金额
     $money_total = 0;
     //兑换券总量
     $dui_total = 0;
     //优惠券总量
     $you_total = 0;

     foreach ($list as $key => $value) {
      if($value['prize_type']==1||$value['prize_type']==2){
        $money_total+=$value['prize'];
      }
      if($value['prize_type']==3){
        $dui_total+=$value['prize'];
      }
      if($value['prize_type']==4){
        $you_total+=$value['prize'];
      }
     }
     $date[] = date('m/d',$v[start_time]);
     $total2[] = $total;
     $money_total2[] = $money_total;
     $dui_total2[] = $dui_total;
     $you_total2[] = $you_total;
    }
    $datas['date'] = $date;
    $datas['data_total'] = $total2;
    $datas['money_total'] = $money_total2;
    $datas['dui_total'] = $dui_total2;
    $datas['you_total'] = $you_total2;

    return show(1,'',$datas);
    }
    $this->display();
   }
   

}




























 ?>