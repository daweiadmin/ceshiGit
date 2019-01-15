<?php 
namespace Common\Model;
use Think\Model;
//分类树
class IndentModel extends Model{
  public function ceshi(){
   $time = '测试2';
   return $time;

  }
	public function fenrun($int_id){
		$int['id'] = $int_id;

		$int_val = M('Indent')->where($int)->find();             //订单信息  
    session('indent_arr',$int_val);
    $mem = M('member')->where(array('id'=>$int_val['member_id']))->find();//会员
    if(!$mem['refe_id']||$mem['refe_id']==0){
      exit;
    }

    session('member_indent_data',$mem);
    $have_or = find_in_three($mem['refe_id']);//查看上三级 内是否存在VIP或者总代
    /*如果有 则使用find_three函数 给上三级分润*/
    if($have_or==1){ 
      $this->find_three($mem['refe_id'],$int_val['total'],'',$int_val['id']);// common/function函数
    }
    /*如果没有先用find_three函数 给上三级普通会员分润 再用find_ten给三级外 十级的vip/总代分润*/
     if($have_or==-1){ //如果没有
      //print_r('123456');exit;
      $this->find_three($mem['refe_id'],$int_val['total'],'',$int_val['id']);
      $this->find_ten($mem['refe_id'],$int_val['total'],'',$int_val['id'],'');
    }
    

  }
  
   /*查找上三级*/
    public function find_three($mem_ref_id,$money,$have=0,$ind_id,$s=0){ 
      $mai_mem = session('member_indent_data');
      $member = D('member')->where(array('id'=>$mem_ref_id))->find();
      
      $s++;

      if($member['level']==1&&$s<=3){//普通会员
        $data_fenrun['money'] = $member['money']+$money*0.05;
        $ook = D('member')->where(array('id'=>$mem_ref_id))->save($data_fenrun);
        /*提现控制 提交订单分润 订单完成后才能提现   改用新建表控制*/
       /* $tixian_limit['tixian_money'] = $member['tixian_money']+$money*0.05;
        $ok = D('member')->where(array('id'=>$mem_ref_id))->save($tixian_limit);*/
        if($ook){
         $fin_zong['userid'] = $member['id'];
         $fin_zong['roletype'] = 1;//会员
         $fin_zong['moneytype'] = 2;//提成
         $fin_zong['money'] = $money*0.05;//金额
         $fin_zong['full'] =  $data_fenrun['money'];//账户剩余金额
         $fin_zong['indent'] = session('indent_arr.indents');//订单号
         $fin_zong['time'] = time();
         $fin_zong['content'] = '下级（三级）会员['.$mai_mem['wx_name'].']消费'.$money.'元，作为上级普通会员收益'.$fin_zong['money'].'元';
         $ok2 = M('finances')->add($fin_zong);
         if($ok2){
                /*存进提现金额控制表  提现控制 提交订单分润 订单完成后才能提现*/
              $control['indent_id'] = $ind_id; 
              $control['mem_ref_id'] = $member['id'];
              $control['money'] = $money*0.05;
              $control['status'] = 0;
              $control['finance_id'] = $ok2;
              $a = M('indent_money_control')->add($control);
              if($a){
                /*发送分润消息提醒*/
                $openid = $member['wx_openid'];
                $content = '亲，您下级（三级）会员['.$mai_mem['wx_name'].']在商城消费了哦';
                $ind = $fin_zong['indent'];
                $time = date("Y-m-d H:i:s",$fin_zong['time']);;
                $fen_money = '作为上级普通会员+'.$fin_zong['money'];
                $res = fenrun_tosend($openid,$content,$money,$fen_money,$ind,$time);

                $this->find_three($member['refe_id'],$money,'',$ind_id,$s);
              }
          
         }
         
        }
       } 
       if($member['level']==2&&$s<=3){//VIP会员
        
        $money2 = $money*0.05+$money*0.03;
        $data_fenrun['money'] = $member['money']+$money2;
        $ok = D('member')->where(array('id'=>$mem_ref_id))->save($data_fenrun);
        /*提现控制 提交订单分润 订单完成后才能提现*/
       /* $tixian_limit['tixian_money'] = $member['tixian_money']+$money2;
        $ok = D('member')->where(array('id'=>$mem_ref_id))->save($tixian_limit);*/
        if($ok){
         $fin_zong['userid'] = $member['id'];
         $fin_zong['roletype'] = 1;//会员
         $fin_zong['moneytype'] = 2;//提成
         $fin_zong['money'] = $money2;//金额
         $fin_zong['full'] =  $data_fenrun['money'];//账户剩余金额
         $fin_zong['indent'] = session('indent_arr.indents');//订单号
         $fin_zong['time'] = time();
         $fin_zong['content'] = '下级（三级）会员['.$mai_mem['wx_name'].']消费'.$money.'元，作为上级vip收益'.$money2.'元';
         $ok2 = M('finances')->add($fin_zong);
         if($ok2){
          
            /*存进提现金额控制表  提现控制 提交订单分润 订单完成后才能提现*/
            $control['indent_id'] = $ind_id; 
            $control['mem_ref_id'] = $member['id'];
            $control['money'] = $money2;
            $control['status'] = 0;
            $control['finance_id'] = $ok2;
            $b = M('indent_money_control')->add($control);
            if($b){
               /*发送分润消息提醒*/
              $openid = $member['wx_openid'];
              $content = '亲，您下级（三级）会员['.$mai_mem['wx_name'].']在商城消费了哦';
              $ind = $fin_zong['indent'];
              $time = date("Y-m-d H:i:s",$fin_zong['time']);;
              $fen_money = '作为上级vip+'.$fin_zong['money'];
              $res = fenrun_tosend($openid,$content,$money,$fen_money,$ind,$time);

              $this->find_three($member['refe_id'],$money,$have=1,$ind_id,$s);
            }
         
         }
         
        }
       } 
       if($member['level']==3&&$s<=3){//总代
        if($have==1){
           $money3 = $money*0.05+$money*0.1-$money*0.03;
        }elseif($have==2){
           $money3 = $money*0.05;
        }else{
           $money3 = $money*0.05+$money*0.1;
        }
        
        $data_fenrun['money'] = $member['money']+$money3;
        $ok = D('member')->where(array('id'=>$mem_ref_id))->save($data_fenrun);
        /*提现控制 提交订单分润 订单完成后才能提现*/
        /*$tixian_limit['tixian_money'] = $member['tixian_money']+$money3;
        $ok = D('member')->where(array('id'=>$mem_ref_id))->save($tixian_limit);*/
        if($ok){
         $fin_zong['userid'] = $member['id'];
         $fin_zong['roletype'] = 1;//会员
         $fin_zong['moneytype'] = 2;//提成
         $fin_zong['money'] = $money3;//金额
         $fin_zong['full'] =  $data_fenrun['money'];//账户剩余金额
         $fin_zong['indent'] = session('indent_arr.indents');//订单号
         $fin_zong['time'] = time();
         $fin_zong['content'] = '下级（三级）会员['.$mai_mem['wx_name'].']消费'.$money.'元，作为上级总代收益'.$money3.'元';
         $ok2 = M('finances')->add($fin_zong);
          if($ok2){
            
              /*存进提现金额控制表  提现控制 提交订单分润 订单完成后才能提现*/
              $control['indent_id'] = $ind_id; 
              $control['mem_ref_id'] = $member['id'];
              $control['money'] = $money3;
              $control['status'] = 0;
              $control['finance_id'] = $ok2;
              $c = M('indent_money_control')->add($control);
              if($c){
                /*发送推送消息*/
                $openid = $member['wx_openid'];
                $content = '亲，您下级（三级）会员['.$mai_mem['wx_name'].']在商城消费了哦';
                $ind = $fin_zong['indent'];
                $time = date("Y-m-d H:i:s",$fin_zong['time']);;
                $fen_money = '作为上级总代+'.$fin_zong['money'];
                $res = fenrun_tosend($openid,$content,$money,$fen_money,$ind,$time);

                $this->find_three($member['refe_id'],$money,$have=2,$ind_id,$s);
              }
         }
         
        }
       }



     }

    public function find_ten($mem_ref_id,$money,$have=0,$ind_id,$s=0){ 
      $member = D('member')->where(array('id'=>$mem_ref_id))->find();
      $mai_mem = session('member_indent_data');
     // print_r('expression');exit;
      $s++;
      if(0<$s&&$s<=3){
       $this->find_ten($member['refe_id'],$money,'',$ind_id,$s);
      }
       if($member['level']==2&&$s>3&&$s<=13){//VIP会员
        $money2 = $money*0.03;
        $data_fenrun['money'] = $member['money']+$money2;
        $ook = D('member')->where(array('id'=>$mem_ref_id))->save($data_fenrun);
        /*提现控制 提交订单分润 订单完成后才能提现*/
        /*$tixian_limit['tixian_money'] = $member['tixian_money']+$money2;
        $ok = D('member')->where(array('id'=>$mem_ref_id))->save($tixian_limit);*/
        if($ook){
         $fin_zong['userid'] = $member['id'];
         $fin_zong['roletype'] = 1;//会员
         $fin_zong['moneytype'] = 2;//提成
         $fin_zong['money'] = $money2;//金额
         $fin_zong['full'] =  $data_fenrun['money'];//账户剩余金额
         $fin_zong['indent'] = session('indent_arr.indents');//订单号
         $fin_zong['time'] = time();
         $fin_zong['content'] = '下级（三级外十级）会员['.$mai_mem['wx_name'].']消费'.$money.'元，作为上级vip收益'.$money2.'元';
         $ok2 = M('finances')->add($fin_zong);
         if($ok2){
           
              $control['indent_id'] = $ind_id; 
              $control['mem_ref_id'] = $member['id'];
              $control['money'] = $money2;
              $control['status'] = 0;
              $control['finance_id'] = $ok2;
              $d = M('indent_money_control')->add($control);
              if($d){
                /*发送推送消息*/
                $openid = $member['wx_openid'];
                $content = '亲，您下级（三级外十级）会员['.$mai_mem['wx_name'].']在商城消费了哦';
                $ind = $fin_zong['indent'];
                $time = date("Y-m-d H:i:s",$fin_zong['time']);;
                $fen_money = '作为上级vip+'.$fin_zong['money'];
                $res = fenrun_tosend($openid,$content,$money,$fen_money,$ind,$time);

                $this->find_ten($member['refe_id'],$money,$have=1,$ind_id,$s);
              }
          /*存进提现金额控制表  提现控制 提交订单分润 订单完成后才能提现*/
          
         }
         
        }
       } 
       if($member['level']==3&&$s<=13){//总代
        if($have==1){
           $money3 = $money*0.1-$money*0.03;
        }else{
           $money3 = $money*0.1;
        }
        
        $data_fenrun['money'] = $member['money']+$money3;
        $ook = D('member')->where(array('id'=>$mem_ref_id))->save($data_fenrun);
        /*提现控制 提交订单分润 订单完成后才能提现*/
        /*$tixian_limit['tixian_money'] = $member['tixian_money']+$money3;
        $ok = D('member')->where(array('id'=>$mem_ref_id))->save($tixian_limit);*/
        if($ook){
         $fin_zong['userid'] = $member['id'];
         $fin_zong['roletype'] = 1;//会员
         $fin_zong['moneytype'] = 2;//提成
         $fin_zong['money'] = $money3;//金额
         $fin_zong['full'] =  $data_fenrun['money'];//账户剩余金额
         $fin_zong['indent'] = session('indent_arr.indents');//订单号
         $fin_zong['time'] = time();
         $fin_zong['content'] = '下级（三级外十级）会员['.$mai_mem['wx_name'].']消费'.$money.'元，作为上级总代收益'.$money3.'元';
         $ok2 = M('finances')->add($fin_zong);
         if($ok2){
          
              /*存进提现金额控制表  提现控制 提交订单分润 订单完成后才能提现*/
              $control['indent_id'] = $ind_id; 
              $control['mem_ref_id'] = $member['id'];
              $control['money'] = $money3;
              $control['status'] = 0;
              $control['finance_id'] = $ok2;
              $qw = M('indent_money_control')->add($control);
           
            if($qw){
              $openid = $member['wx_openid'];
              $content = '亲，您下级（三级外十级）会员['.$mai_mem['wx_name'].']在商城消费了哦';
              $ind = $fin_zong['indent'];
              $time = date("Y-m-d H:i:s",$fin_zong['time']);;
              $fen_money = '作为上级vip+'.$fin_zong['money'];
              $res = fenrun_tosend($openid,$content,$money,$fen_money,$ind,$time);
             }
          
         }
         //$this->find_ten($member['refe_id'],$money,$have=2);
        }
       }


     }


 }
 ?>