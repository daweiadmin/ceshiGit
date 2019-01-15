<?php 
namespace Admin\Controller;
use Think\Controller;
class TixianController extends CommenController {

  public function index(){
    $count=D('finances')
    ->table('fen_finances fin,fen_member_data data')
    ->field('fin.id,fin.money,fin.status,fin.time,data.name,data.phone,data.weixin,data.alipay,data.bankcard,data.bank_address,data.bank_man')
    ->where('fin.userid=data.member_id and fin.moneytype=1 and fin.status=0')
    ->order('fin.id desc')->limit($offset,$pageSize)->count();
     $data['moneytype'] = 1;
     $data['status'] = 0;
     $count = D('finances')->where($data)->count();
     $page=$_REQUEST['p'] ? $_REQUEST['p'] :1;
     $pageSize=10;  
     $offset=($page-1)*$pageSize; 
     
    $list=D('finances')
    ->table('fen_finances fin,fen_member_data data')
    ->field('fin.id,fin.money,fin.status,fin.time,data.name,data.phone,data.weixin,data.alipay,data.bankcard,data.bank_address,data.bank_man')
    ->where('fin.userid=data.member_id and fin.moneytype=1 and fin.status=0')
    ->order('fin.id desc')->limit($offset,$pageSize)->select();
    
    $datapage=new \Think\Page($count,$pageSize);  
    $datapage->setConfig('header','<br/><br/>共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页');
    $datapage->setConfig('prev','上一页');
    $datapage->setConfig('next','下一页');
    $datapage->setConfig('theme','%UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %HEADER%');
    //print_r($list);exit;
    $pageRes=$datapage->show();
    $this->assign('page',$pageRes);
    $this->assign('list',$list);

    $this->display();
  }
 

   public function tixian_finish(){
    if(IS_POST){
     $data['id'] = I('id');
     $fin = D('finances')->where($data)->find();
     $mem['id'] = $fin['userid'];
     $member = D('member')->where($mem)->find();
     if($member['money']<$fin['money']){
      return show(0,'会员提现金额不足');
     }
     $jia['money'] = $member['money'] - $fin['money']; //扣除会员账户钱数
     $ok = D('member')->where($mem)->save($jia);
     if($ok){
         $data2['full'] = $jia['money'];
         $data2['status'] = 1;
         $data2['end_time'] = time();//完成时间
         $ook = D('finances')->where($data)->save($data2);
         if($ook){
           $openid = $member['wx_openid']; 
           $wx_name = $member['wx_name']; 
           $jifen = $fin['money'];
           $time = date("Y-m-d h:i:sa", $data2['end_time']);
           money_duihuan_send($openid,$wx_name,$jifen,$time);
           return show(1,'操作成功');
          }else{
            return show(0,'操作失败');
          }
     }
    }
   }

  public function refuse(){
    if(IS_POST){
     $data['id'] = I('id');
     //$data['content'] = I('refuse');
     $ref['status'] = -1;
     $ref['content'] = I('refuse');
     //print_r($ref);exit;
     $ok = D('finances')->where($data)->save($ref);
     if($ok){
       return show(1,'操作成功');
      }else{
        return show(0,'操作失败');
      }
    }
  }

   public function finish(){
        $count=D('finances')
        ->table('fen_finances fin,fen_member_data data')
        ->field('fin.money,fin.status,fin.time,fin.end_time,data.name,data.phone,data.weixin,data.alipay,data.bankcard,data.bank_man,data.bank_address')
        ->where('fin.userid=data.member_id and fin.moneytype=1 and fin.status=1')
        ->order('fin.id desc')->limit($offset,$pageSize)->count();
         $data['moneytype'] = 1;
         $data['status'] = 0;
         $count = D('finances')->where($data)->count();
         $page=$_REQUEST['p'] ? $_REQUEST['p'] :1;
         $pageSize=10;  
         $offset=($page-1)*$pageSize; 
         
        $list=D('finances')
        ->table('fen_finances fin,fen_member_data data')
        ->field('fin.money,fin.status,fin.time,fin.end_time,data.name,data.phone,data.weixin,data.alipay,data.bankcard,data.bank_man,data.bank_address')
        ->where('fin.userid=data.member_id and fin.moneytype=1 and fin.status=1')
        ->order('fin.id desc')->limit($offset,$pageSize)->select();
        
        $datapage=new \Think\Page($count,$pageSize);  
        $datapage->setConfig('header','<br/><br/>共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页');
        $datapage->setConfig('prev','上一页');
        $datapage->setConfig('next','下一页');
        $datapage->setConfig('theme','%UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %HEADER%');
        //print_r($list);exit;
        $pageRes=$datapage->show();
        $this->assign('page',$pageRes);
        $this->assign('list',$list);

     $this->display();
   }





    public function excel(){
    $list=D('finances')
        ->table('fen_finances fin,fen_member_data data')
        ->field('fin.money,fin.status,fin.time,fin.end_time,data.name,data.phone,data.weixin,data.alipay,data.bankcard,data.bank_man')
        ->where('fin.userid=data.member_id and fin.moneytype=1 and fin.status=0')
        ->order('fin.id desc')->limit($offset,$pageSize)->select();

        header("Content-type:application/vnd.ms-excel");//输出excel头
        header("Content-Disposition:filename=会员提现信息.xls");
        echo @iconv('utf-8', 'gbk', '联系电话')."\t";
        echo @iconv('utf-8', 'gbk', '会员姓名')."\t";
        echo @iconv('utf-8', 'gbk', '微信号')."\t";
        echo @iconv('utf-8', 'gbk', '支付宝号')."\t";
        echo @iconv('utf-8', 'gbk', '银行卡号')."\t";
        echo @iconv('utf-8', 'gbk', '开户行')."\t";
        echo @iconv('utf-8', 'gbk', '开户人姓名')."\t";
        echo @iconv('utf-8', 'gbk', '提现金额')."\t";
        echo @iconv('utf-8', 'gbk', '申请时间')."\t\n";//  \t\n表示换行
        foreach($list as $key=>$v){
            // $exchange_time = $v['exchange_time']>0 ? date('Y-m-d H:i:s',$v['exchange_time']) : '--';
           // $time = $v['addtime']>0 ? date('Y-m-d H:i:s',$v['addtime']) : '--';
            echo @iconv('utf-8', 'gbk', $v['phone'])."\t";
            echo @iconv('utf-8', 'gbk', $v['name'])."\t";
            echo @iconv('utf-8', 'gbk', $v['weixin'])."\t";
            echo @iconv('utf-8', 'gbk', $v['alipay'])."\t";
            echo @iconv('utf-8', 'gbk', $v['bankcard'])."\t";
            echo @iconv('utf-8', 'gbk', $v['bank_address'])."\t";
            echo @iconv('utf-8', 'gbk', $v['bank_man'])."\t";
            echo @iconv('utf-8', 'gbk', $v['money'])."\t";
            echo $v['time']>0 ? @date('Y-m-d H:i:s',$v['time'])."\t\n" : '--'."\t\n";
        }

    }

	

  }