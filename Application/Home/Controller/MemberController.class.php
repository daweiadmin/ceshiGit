<?php 
namespace Home\Controller;
use Think\Controller;
class MemberController extends Controller{

   public function index(){
    $mem['id'] = session('memberUser.id');
    $member = D('member')->where($mem)->find();
    $this->assign('member',$member);
   	$this->display();
   }
   /*突出荣誉奖*/
  public function jiang(){
    if(IS_POST){
      $mem['id'] = session('memberUser.id');
      $ber = D('member')->where($mem)->find();
      $num_zhi_daili = daili_sum($ber['id']);
      $num_zhi_vip = vip_sum($ber['id']);
      if($ber['vip_zong']==200 && $num_zhi_daili==10 && $num_zhi_vip==20){
        $jiang['jiang'] = 1;
        $ok = D('member')->where($mem)->save($jiang);
        if($ok){
          return show(1,'');
        }
        
      }
          
    }

  }

   /*——————————————————代理申请————————*/

   public function daili_sub(){
    

    $this->display();
   }

    public function add_daili_sub(){
     $mem_id = session('memberUser.id');
     $fin['userid'] = $mem_id;
     $fin['roletype'] = 1;//会员
     $fin['moneytype'] = 4;//申请代理
     $fin['bank_man'] = I('bank_man');//姓名
     //$fin['full'] =  $mon['money'];//账户剩余金额
     $fin['phone'] = I('phone');
     $fin['time'] = time();
     $ok2 = M('finances')->add($fin);
     if($ok2){ 
         return show(1,'申请提交成功');
       }else{
         return show(0,'订单添加失败');
       }
 
   }
   /*  推广二维码   */
  public function refe(){
    $mem['id'] = session('memberUser.id');
    $member = D('member')->where($mem)->find();
    $this->assign('member',$member['erweima']);
    $this->display();
   }
/********************************** 立即购买 *****************************************/

   public function lijigoumai(){
    $goods['id'] = I('GOOD');
    $find = D('product')->where($goods)->find();
    $this->assign('goods',$find);
    $this->display();
   }

   public function ajax_add_lijigoumai(){
    if(IS_POST){
     $data['id'] = I('goods_id');
     $data_n = I('num');
     //print_r($data);exit;
     $good_data = D('product')->where($data)->find();
     if($good_data){
       $cache_data['goods_name'] = $good_data['name'];
       $cache_data['goods_id'] = $good_data['id'];
       $cache_data['member_id'] = session('memberUser.id');
       $cache_data['goods_member'] = $good_data['member'];
       $cache_data['picture'] = $good_data['picture'];
       $cache_data['goods_price'] = $good_data['price'];
       $cache_data['goods_num'] = $data_n;
       $cache_data['status'] = 1;
       $cache_data['time'] = time();
       $ok = D('cache')->add($cache_data);
       if($ok){
        $save['cache_id'] = $ok;
        $save['member_id'] = session('memberUser.id');
        $save['total'] = $good_data['price']*$data_n;
        $save['status'] = 0; 
        $save['indents'] = session('memberUser.id').time().mt_rand(1,9);
        $save['indent_start_time'] = time();
        $ok2 = D('indent')->add($save);
        if($ok2){ 
           return show(1,'',$ok2);
         }else{
           return show(0,'订单添加失败');
         }
       }else{
         return show(0,'操作失败');
       }
     }
    }


   }
   /****************************************   收货地址    ********************8*/
   public function address(){
      $ind = I('IND');
      if(!empty($ind)){
        $this->assign('ind',$ind);
      }
     $memid['member_id'] = session('memberUser.id');
     $list = D('address')->where($memid)->select();

     //print_r($list);exit;
     $this->assign('add_list',$list);
   	$this->display();
   }
 
    public function add_address(){
       $ind = I('IND');
      if(!empty($ind)){
        $this->assign('ind',$ind);
      }
     if(IS_POST){
      $data['name'] = I('name');
      $data['phone'] = I('phone');
      $s_province = I('s_province');
      $s_city = I('s_city');
      $s_county = I('s_county');
      $data['location'] = $s_province.'-'.$s_city.'-'.$s_county;
      $data['address'] = I('address');
      $data['time'] = time();
      $data['member_id'] = session('memberUser.id');
      $ok = D('address')->add($data);
      if($ok){
      	return show(1,'添加成功');
      }else{
      	return show(0,'添加失败');
      }
     }
     $this->display();
    }
    public function address_edit(){
       $ind = I('IND');
      if(!empty($ind)){
        $this->assign('ind',$ind);
      }
     $data['id'] = I('id');
     //print_r($data);exit;
     $getone =  D('address')->where($data)->find();
     $this->assign('onedata',$getone);
     $this->display();
    }
   /*        保存地址         */
    public function address_save(){
     if(IS_POST){
      $data['name'] = I('name');
      $data['phone'] = I('phone');
      $data['location'] = I('location');
      $data['address'] = I('address');
      $dataid['id'] = I('address_id');
      $ok = D('address')->where($dataid)->save($data);
      if($ok){
        return show(1,'编辑成功');
      }else{
        return show(0,'编辑失败');
      }
     }
     $this->display();
    }

          //-----------------------------------------删除地址
    public function address_del(){
        $del = D('member');
        $class_id['id'] = I('id');
         //print_r($class_id);exit;
        if($del->where($class_id)->delete()){
             return show(1,'删除成功');
        }else{
             return show(0,'删除失败');
        }
    }
    /*        地址状态 默认         */
     public function address_status(){
        $data['id'] = I('id');
        //print_r($data);exit;
        $sta['status'] = 1;
        $sta['member_id'] = session('memberUser.id');
        $have = D('address')->where($sta)->select();

        if($have){
          $bian['status'] = 0;
          D('address')->where($sta)->save($bian);
        }
        $cha['status'] = 1;
        $ok = D('address')->where($data)->save($cha);
        if($ok){
             return show(1,'操作成功');
        }else{
             return show(0,'操作失败');
        }
    }
 /*******************************************个人资料 *******************************/
   public function member_data(){
   	  $have['member_id'] = session('memberUser.id');
   	  $find = D('member_data')->where($have)->find();
   	  //print_r($find);exit;
   	  $this->assign('data',$find);
      if(IS_POST){
      	//print_r($_POST);exit;
      $data['name'] = I('name');
      $data['sex'] = I('sex');
      $data['qq'] = I('qq');
      $data['phone'] = I('phone');
      $data['weixin'] = I('weixin');
      //$data['bankcard'] = I('bankcard');
      //$data['bank_address'] = I('bank_address');
      //$data['bank_man'] = I('bank_man');
      $data['member_id'] = session('memberUser.id');
      $data['time'] = time();
      $data['status'] = 1;

      //print_r($data);exit;
       $p['id'] = I('data_id');
      if($p['id']){
        $ok = D('member_data')->where($p)->save($data);
      }else{
      	$ok = D('member_data')->add($data);
      }
      
      if($ok){
      	return show(1,'保存成功');
      }else{
      	return show(0,'保存失败');
      }
     }
    $this->display();
   }
  
   public function jiesuan(){
    
    if(IS_POST){
     $data['id'] = I('indent_id');
     $indent_data = D('indent')->where($data)->find();
     $money = $indent_data['total'];
     $mem = $indent_data['member_id'];
     
    }



   }
  /*        提现界面         */
    public function tixian(){
    $mem['id'] = session('memberUser.id');
    $fin = D('member')->where($mem)->find();
    $this->assign('data',$fin);
    $this->display();
   }
   /*        提现申请         */
   public function ti_money(){
   	if(IS_POST){
   	 $mem['id'] = session('memberUser.id');	
     //print_r($mem);exit;
   	 $member = D('member')->where($mem)->find();

   	 if($member['level']==1){
      if($_POST['money']>=$member['tixian_money']){
        return show(0,'您的可提现金额不足');
      }
   	 }
      if($_POST['money']>=$member['money']){
       return show(0,'账户金额不足');
      }
      $data['userid'] = session('memberUser.id');
      $data['roletype'] = 1;
      $data['moneytype'] = 1;
      $data['status'] = 0;
      $data['money'] = I('money');
      $data['moldtype'] = I('type');//提现方式
      $data['time'] = time();//提现申请时间
      $data['bank'] = I('bank');
      $data['bankcard'] = I('bank_card');
      $data['bank_man'] = I('bank_man');
      $data['card'] = I('card');
      $data['phone'] = I('phone');
     //print_r($data);exit;
    // $data['content'] = '申请提现'.$data['money'].'元，提现完成后账户剩余'.($member['money']-$data['money']);
       $ok = D('finances')->add($data);
       if($ok){
         return show(1,'提现申请成功');
        }else{
         return show(0,'提现申请失败');
        }
     
   	}
   }
  /*    提现明细    */
  public function tixian_finish(){
    $data['userid'] = session('memberUser.id');  
    $data['roletype'] = 1;
    $data['moneytype'] = 1;
    $data['status'] = 1;
    $count = D('finances')->where($data)->count();
    $page=$_REQUEST['p'] ? $_REQUEST['p'] :1;
    $pageSize=15;  
    $offset=($page-1)*$pageSize;  
    $list=D('finances')->where($data)->limit($offset,$pageSize)->select();
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



/*————————————————————————————————————————购物车——————*/
  public function cache(){
  $data['member_id'] = session('memberUser.id');
  $data['status'] = 0;
  $list = D('cache')->where($data)->select();
  $this->assign('list',$list);
  $total = '';
  foreach ($list as $key => $value) {
    $total += $value['goods_num']*$value['goods_price'];
   }
  $this->assign('total',$total);
  $this->display();
  }

  /*删除购物车*/
  public function del(){
    if(IS_POST){
     $id['id'] = I('id');
     $del = D('cache')->where($id)->delete();
     if($del){
       return show(1,'删除成功');
     }else{
       return show(0,'删除失败');
     }
    }
  }


  /*        订单页面         */
  public function indent(){
    header('Content-type:text/html;charset=utf-8');
   $data['id'] = $_GET['IND'];
   
   $int = D('indent')->where($data)->find();
   $this->assign('ind',$int);
   $arr['id'] = array('in',$int['cache_id']);
   //print_r($int);exit;
   $list = D('cache')->where($arr)->select();
   //var_dump($list);exit;
   $mem['member_id'] = session('memberUser.id');
   $mem['status'] = 1;
   $addre = D('address')->where($mem)->find();
   if($addre){
     $this->assign('address',$addre);
   }else{
     $addre2 = D('address')->where(array('member_id'=>$mem['member_id']))->limit(1)->order('id desc')->find();
     $this->assign('address',$addre2);
   }
   $this->assign('list',$list);
   $this->display();
  }

/*        添加订单         */
  public function add_indent(){
   if(IS_POST){
    $data = I('cache_id');
  // print_r($data);exit;
    if(empty($data)){
     return show(-1,'请选择您要结算的商品');
    }
    $total = '';
    for ($i=0; $i < count($data); $i++) { 
      $cah['id'] = $data[$i];
      $sta['status'] = 1;
      D('cache')->where($cah)->save($sta);
      $price = D('cache')->where($cah)->find();
      $total+=$price['goods_num']*$price['goods_price'];
    }

   // print_r($total);exit;
    $save['cache_id'] = implode($data, ',');
    $save['member_id'] = session('memberUser.id');
    $save['total'] = $total;
    $save['status'] = 0;
    $save['indents'] = session('memberUser.id').time().mt_rand(1,9);//订单号= 会员id+当前时间戳+随机数
    $save['indent_start_time'] = time();
    $ok = D('indent')->add($save);
    if($ok){
      return show(1,'',$ok);
    }
   }


  }
  /*     支付界面    */

  public function order_pay(){
    if(IS_POST){
     $ind_id['id'] = I('indent_id');
     $add['address_id'] = I('address_id');
     $a = D('indent')->where($ind_id)->save($add);
     if($a){
      $find = D('indent')->where($ind_id)->find();
      $this->assign('data',$find);
     }else{
      $this->error('订单提交失败');
     }
     
    }
    if($_GET){
     $ind_id['id'] = I('indent_id');
     $find = D('indent')->where($ind_id)->find();
     $this->assign('data',$find);
    }
    
    $this->display();
  }
  


 /*ajax_cache_num加减商品数量*/
  public function ajax_cache_num(){
    if(IS_POST){
     $data['id'] = I('id');
     $data['num'] = I('num');
     $data['type'] = I('type');
    // print_r($data);exit;
     $cach = D('cache')->where(array('id'=>$data['id']))->find();
     //print_r($cach);exit;
     if($data['type']==-1){//减去1数量
      $jian['goods_num'] = $cach['goods_num']-1;
      $ok = D('cache')->where(array('id'=>$data['id']))->save($jian);
      
     }
     if($data['type']==1){//加上1数量
      $jian['goods_num'] = $cach['goods_num']+1;
      $ok = D('cache')->where(array('id'=>$data['id']))->save($jian);
      
     }
     $ccc['member_id'] = session('memberUser.id');
     $ccc['status'] = 0;
     $cachs = D('cache')->where($ccc)->select();
     $total = '';
     foreach ($cachs as $key => $value) {
      $total += $value['goods_num']*$value['goods_price'];
     }
     $arr['num'] = $jian['goods_num'];
     $arr['total'] = $total;
     echo json_encode($arr);

    }
  }
  
  public function ticheng(){
    $data['userid'] = session('memberUser.id');  
    $data['roletype'] = 1;
    $data['moneytype'] = 2;
    $count = D('finances')->where($data)->count();
    $page=$_REQUEST['p'] ? $_REQUEST['p'] :1;
    $pageSize=2;  
    $offset=($page-1)*$pageSize;  
    $list=D('finances')->where($data)->limit($offset,$pageSize)->select();
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
  

  /***************************订单管理**************************************/

 public function order(){
 
  $mem['member_id'] = session('memberUser.id');
  $mem['status'] = I('STATUS');
  //print_r($mem);exit;
  $this->assign('sta',$mem['status']);
  $list = D('indent')->where($mem)->select();
  //var_dump($list);exit;
  $arr = array();
  $cah = array();
  //var_dump($list);exit;
  foreach ($list as $key => $value) {
    $arr['id'] = $value['id'];
    $arr['indents'] = $value['indents'];
    $arr['total'] = $value['total'];
    $arr['status'] = $value['status'];
    $arr['indent_start_time'] = $value['indent_start_time'];
      $cahs = explode(',', $value['cache_id']);
    $arr['count'] = count(explode(',', $value['cache_id']));
    $arr['goods'] = D('cache')->where(array('id'=>$cahs[0]))->find();
    $cah[] = $arr;
  }
  //var_dump($cah);exit;
  $count=count($cah);
  $Page=new \Think\Page($count,5);

  $Page->setConfig('prev','上一页');
  $Page->setConfig('next','下一页');
  $show       = $Page->show();
  $list=array_slice($cah,$Page->firstRow,$Page->listRows);
  $this->assign('list',$list);// 赋值数据集
  $this->assign('page',$show);// 赋值分页输出

  $this->display();
 }
 /*确认订单*/
  public function order_get(){
    if(IS_POST){
       $id['id'] = I('id');
       $sta['status'] = 3;
       $sta['finishtime'] = time();
       $find = D('indent')->where($id)->save($sta);
       if($find){
             return show(1,'收货成功');
            //$this->success('操作成功',U('member/order?STATUS=2'));
        }else{
           return show(0,'收货失败');
            //$this->success('操作失败');
        }
      }
  
    }
  



 /*取消订单*/
 public function order_del(){
     if(IS_POST){

        $id['id'] = I('id');
        $find = D('indent')->where($id)->find();
          $cache['id'] = array('in',$find['cache_id']);
          $del1 = D('cache')->where($cache)->delete();
          $del2 = D('indent')->where($id)->delete();
        if($del1 && $del2){
             return show(1,'取消成功');
            //$this->success('订单取消成功',U('member/order?STATUS=0'));
        }else{
          return show(0,'取消失败');
            //$this->success('订单取消失败');
        }

     }
      
    }
 /*订单详情*/
 public function order_info(){
  $indent_id['id'] = I('IND');
  $ind_data = D('indent')->where($indent_id)->find();
  $arr['address'] = D('address')->where(array('id'=>$ind_data['address_id']))->find();
   $cc['id'] = array('in',$ind_data['cache_id']);
  $arr['goods'] = D('cache')->where($cc)->select();
  $arr['indent'] = $ind_data;
  $this->assign('list',$arr);

  $this->display();
 }

 /*推荐的好友*/
  public function friend(){
    $type = I('TYPE');
    if($type=='V'){
     $data['refe_id'] = session('memberUser.id');
     $data['level'] = 1;
      $count = D('member')->where($data)->count();
      $page=$_REQUEST['p'] ? $_REQUEST['p'] :1;
      $pageSize=15;  
      $offset=($page-1)*$pageSize;  
      $list=D('member')->where($data)->limit($offset,$pageSize)->select();
      $datapage=new \Think\Page($count,$pageSize);  
      $datapage->setConfig('header','<br/><br/>共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页');
      $datapage->setConfig('prev','上一页');
      $datapage->setConfig('next','下一页');
      $datapage->setConfig('theme','%UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %HEADER%');
      //print_r($list);exit;
      $pageRes=$datapage->show();
      $this->assign('page',$pageRes);
      $this->assign('list',$list);
    }
     if($type=='D'){
      $data['refe_id'] = session('memberUser.id');
      $data['level'] = 2;
      $count = D('member')->where($data)->count();
      $page=$_REQUEST['p'] ? $_REQUEST['p'] :1;
      $pageSize=10;  
      $offset=($page-1)*$pageSize;  
      $list=D('member')->where($data)->limit($offset,$pageSize)->select();
      $datapage=new \Think\Page($count,$pageSize);  
      $datapage->setConfig('header','<br/><br/>共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页');
      $datapage->setConfig('prev','上一页');
      $datapage->setConfig('next','下一页');
      $datapage->setConfig('theme','%UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %HEADER%');
      //print_r($list);exit;
      $pageRes=$datapage->show();
      $this->assign('page',$pageRes);
      $this->assign('list',$list);
    }

     if($type=='P'){
      $data['refe_id'] = session('memberUser.id');
      $data['level'] = 0;
      $count = D('member')->where($data)->count();
      $page=$_REQUEST['p'] ? $_REQUEST['p'] :1;
      $pageSize=10;  
      $offset=($page-1)*$pageSize;  
      $list=D('member')->where($data)->limit($offset,$pageSize)->select();
      $datapage=new \Think\Page($count,$pageSize);  
      $datapage->setConfig('header','<br/><br/>共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页');
      $datapage->setConfig('prev','上一页');
      $datapage->setConfig('next','下一页');
      $datapage->setConfig('theme','%UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %HEADER%');
      //print_r($list);exit;
      $pageRes=$datapage->show();
      $this->assign('page',$pageRes);
      $this->assign('list',$list);
    }

    $this->display();
  }
  
  public function fahuo(){
    $data['daili_id'] = session('memberUser.id');
    $data['status'] = 2;
     $list = D('indent')->where($data)->select();
    //var_dump($list);exit;
    $arr = array();
    $cah = array();
    //var_dump($list);exit;
    foreach ($list as $key => $value) {
      $arr['id'] = $value['id'];
      $arr['indents'] = $value['indents'];
      $arr['total'] = $value['total'];
      $arr['status'] = $value['status'];
      $arr['indent_start_time'] = $value['indent_start_time'];
        $cahs = explode(',', $value['cache_id']);
      $arr['count'] = count(explode(',', $value['cache_id']));
      $arr['goods'] = D('cache')->where(array('id'=>$cahs[0]))->find();
      $cah[] = $arr;
    }
      $count=count($cah);
      $Page=new \Think\Page($count,5);

      $Page->setConfig('prev','上一页');
      $Page->setConfig('next','下一页');
      $show       = $Page->show();
      $list=array_slice($cah,$Page->firstRow,$Page->listRows);
      $this->assign('list',$list);// 赋值数据集
      $this->assign('page',$show);// 赋值分页输出
      $this->display();
    }

   /*@@@@@@@@@@@@@@@@@@@@@@@@*******
   *
   *
   *    @最 终 结 算
   *
   ******************/
   public function ceshi(){
   $a = vip_zong_jia1(5);
   print_r($a);exit;
    //D('Indent')->fenrun(6);
     

   }
   public function pay(){
     if(IS_POST){
      //ini_set ('memory_limit', '256M');  
      $int_id = I('indent_id');
      $data = D('indent')->where(array('id'=>$int_id))->find();
     
      $mem['id'] = session('memberUser.id');
      $ber = D('member')->where($mem)->find();

      $fahuo_daili = fahuo_daili($ber['refe_id']);
      
      if($fahuo_daili==-1){
        $this->error('对不起，会员上级找不到发货代理，不能结算');
      }else{
        $pay_time['daili_id'] = $fahuo_daili;
      }
      
      $pay_time['time'] = time();
      $pay_time['status'] = 1;
      $p = D('indent')->where(array('id'=>$int_id))->save($pay_time);
      
     if($ber['level']==0){
         if($data['total']>=2980 && $p){
          /*分润*/
          $jiesuan = D('indent')->fenrun($int_id);
          $lev['level'] = 1;
          $ok = D('member')->where($mem)->save($lev);
          if($ok){
            vip_zong_jia1($ber['refe_id']);//把上级所有的vip及vip以上会员的vip_zong加1
          }
          /*升级*/
          $dai = have_daili($ber['refe_id']);
          $zong = have_zong($ber['refe_id']);
          $fuzong = have_fuzong($ber['refe_id']);
         // $ceo = have_ceo($ber['refe_id']);
          if($dai){//代理
            $dai_find = D('member')->where(array('id'=>$dai))->find();
            $num_zhi_daili = daili_sum($ber['id']);
            $num_zhi_vip = vip_sum($ber['id']);
            if($dai_find['daili_zong']==30 && $dai_find['vip_zong']==60 && $num_zhi_daili==5 && $num_zhi_vip==10){
              $bian['level'] = 3;//升级总监
              $ok2 = D('member')->where(array('id'=>$dai))->save($bian);
            }
          }
          if($zong){//判断个数
            $zong_find = D('member')->where(array('id'=>$zong))->find();
            $num_zhi_daili = daili_sum($ber['id']);
            $num_zhi_vip = vip_sum($ber['id']);
            if($zong_find['daili_zong']==100 && $zong_find['vip_zong']==200 && $num_zhi_daili==10 && $num_zhi_vip==20){
              $bian2['level'] = 4;//升级副总
              $ok3 = D('member')->where(array('id'=>$zong))->save($bian2);
            }
          }
          if($fuzong){//判断个数
            $fuzong_find = D('member')->where(array('id'=>$fuzong))->find();
            $num_zhi_daili = daili_sum($ber['id']);
            $num_zhi_vip = vip_sum($ber['id']);
            if($fuzong_find['daili_zong']==200 && $fuzong_find['vip_zong']==400 && $num_zhi_daili==15 && $num_zhi_vip==30){
              $bian3['level'] = 5;//升级ceo
              $ok4 = D('member')->where(array('id'=>$fuzong))->save($bian3);
            }
          }/*升级结束*/

           if($ok){
             //return show(1,'结算成功');
            $this->success('结算成功',U('member/pay_finish?IND='.$int_id));
           }else{
             //return show(0,'结算失败');
            $this->error('结算失败');
           }
         }else{//金额大于2980
           if($p){
             //return show(1,'结算成功');
            $this->success('结算成功',U('member/pay_finish?IND='.$int_id));
           }else{
             //return show(0,'结算失败');
            $this->error('结算失败');
           }
         }
      }else{
          if($p){
            $this->success('结算成功',U('member/pay_finish?IND='.$int_id));
           }else{
             //return show(0,'结算失败');
            $this->error('结算失败');
           }
      }


     }
   }
  
  public function pay_finish(){
    $fin['id'] = I('IND');
    $finish = D('indent')->where($fin)->find();
    $this->assign('ind',$finish);
    $this->display();
  }


}