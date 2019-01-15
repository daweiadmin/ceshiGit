<?php 
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommenController {

    public function index(){
      $shop['type'] = 1;
      $sheng_count = D('shop')->where($shop)->field('id')->count();
      $shop['type'] = 2;
      $shi_count = D('shop')->where($shop)->field('id')->count();
      $shop['type'] = 3;
      $store_count = D('shop')->where($shop)->field('id')->count();
      $this->assign('sheng_count',$sheng_count);
      $this->assign('shi_count',$shi_count);
      $this->assign('store_count',$store_count);
         $zhi['moneytype'] = 1;
         $list = D('money_record')->where($zhi)->field('money')->select();
         $money_total = 0;
         foreach ($list as $key => $value) {
            $money_total += $value['money'];
         }
      $this->assign('money_total',$money_total);
      $per = D('admin')->field('percent')->find();
      $this->assign('per',$per['percent']);
     $this->display();
    }

   public function charts(){
     //$w = date("Y-m-d H:i:s",$ww);
     if(IS_POST){
     $day_num = I('day_num');
     $json_arr = date_charts($day_num);
    // print_r($json_arr);exit;
     $arr = json_decode($json_arr,true);
     $zong = array();
    // dump($arr);exit;
     foreach ($arr as $k => $v) {
         //$zhi['time']>$v['start_time'];
         $zhi['time']=array('between',array($v['start_time'],$v['end_time']));
         $zhi['moneytype'] = 1;
         //print_r($zhi);exit;
         $list = D('money_record')->where($zhi)->field('money')->select();
         $money_total = 0;
         foreach ($list as $key => $value) {
            $money_total += $value['money'];
         }
         //print_r($money_total);exit;
         $shop['time'] = array('between',array($v['start_time'],$v['end_time']));
         $shop['type'] = 1;
         $sheng_count = D('shop')->where($shop)->field('id')->count();
         $shop['type'] = 2;
         $shi_count = D('shop')->where($shop)->field('id')->count();
         $shop['type'] = 3;
         $store_count = D('shop')->where($shop)->field('id')->count();

         $date[] = date('m/d',$v[start_time]);
         $money_total2[] = $money_total;
         $sheng_count2[] = $sheng_count;
         $shi_count2[] = $shi_count;
         $store_count2[] = $store_count;
    }
    $datas['date'] = $date;
    $datas['money_total'] = $money_total2;
    $datas['sheng_count'] = $sheng_count2;
    $datas['shi_count'] = $shi_count2;
    $datas['store_count'] = $store_count2;
   // dump($datas);exit;
    return show(1,'',$datas);
    }
    $this->display();
   }

        public function curl_get_https($url){
            $curl = curl_init(); // 启动一个CURL会话
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
            $tmpInfo = curl_exec($curl);     //返回api的json对象
            //关闭URL请求
            curl_close($curl);
            return $tmpInfo;    //返回json对象
        }

   public function chongzhi(){
   if(IS_POST){
     $data['percent'] = I('zhi');
     //print_r($data);exit;
     $id['id'] = 2;
     $ok = D('admin')->where($id)->save($data);
      if($ok){
        return show(1,'设置成功');
     }else{
        return show(0,'设置失败');
     }
   }



   }









}




























 ?>