<?php 
namespace Shop\Controller;
use Think\Controller;
class ReturnController extends Controller {

   //支付回调
      public function notify_url(){
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