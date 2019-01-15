<?php 
namespace Admin\Controller;
use Think\Controller;
class MemberController extends CommenController{
   public function putong(){
    $sear = I('search');
    if($sear){
      $data['wx_name']=array('like','%'.$sear.'%');
      $find = D('member')->where($data)->count();
      if($find>0){
        $where['wx_name'] = array('like','%'.$sear.'%');
      }else{
        $nums['name']=array('like','%'.$sear.'%'); //模糊查询
        $member_data = D('member_data')->where($nums)->select();
        $str = '';
        foreach ($member_data as $key => $value) {
        $str .= $value['member_id'].',';
        }
        $in = rtrim($str,',');
        $where['id'] = array('in',$in);
       // $list = $member->where($ins)->select();
      }
    }
    //print_r($where);exit;
    $where['level'] = 0;
    $count = D('member')->where($where)->count();
    $page=$_REQUEST['p'] ? $_REQUEST['p'] :1;
    $pageSize=20;  
    $offset=($page-1)*$pageSize;  
    $list=D('member')->where($where)->limit($offset,$pageSize)->order('id desc')->select();
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
  public function index(){
     $sear = I('search');
    if($sear){
      $data['wx_name']=array('like','%'.$sear.'%');
       $find = D('member')->where($data)->count();

      if($find>0){
        $where['wx_name'] = array('like','%'.$sear.'%');
      }else{
        $nums['name']=array('like','%'.$sear.'%'); //模糊查询
        $member_data = D('member_data')->where($nums)->select();
        $str = '';
        foreach ($member_data as $key => $value) {
        $str .= $value['member_id'].',';
        }
        $in = rtrim($str,',');
        $where['id'] = array('in',$in);
       // $list = $member->where($ins)->select();
      }

    }

    $where['level'] = 1;
    $count = D('member')->where($where)->count();
    $page=$_REQUEST['p'] ? $_REQUEST['p'] :1;
    $pageSize=20;  
    $offset=($page-1)*$pageSize;  
    $list=D('member')->where($where)->limit($offset,$pageSize)->order('id desc')->select();
    $datapage=new \Think\Page($count,$pageSize);  
    $datapage->setConfig('header','<br/><br/>共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页');  
    $datapage->setConfig('prev','上一页');
    $datapage->setConfig('next','下一页');
    $datapage->setConfig('theme','%UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %HEADER%');
    //print_r($list);exit;
    $pageRes=$datapage->show();
    $this->assign('page',$pageRes);
    $this->assign('list',$list);
    /*取出所有总代*/
    $zong_dai = D('member')->where(array('level'=>3))->select();
    $this->assign('zong_dai',$zong_dai);


  	$this->display();
  }
  
  public function vip_index(){
     $sear = I('search');
    if($sear){
      $data['wx_name']=array('like','%'.$sear.'%');
      $find = D('member')->where($data)->count();
      
      if($find>0){
        $where['wx_name'] = array('like','%'.$sear.'%');
      }else{
        $nums['name']=array('like','%'.$sear.'%'); //模糊查询
        $member_data = D('member_data')->where($nums)->select();
        $str = '';
        foreach ($member_data as $key => $value) {
        $str .= $value['member_id'].',';
        }
        $in = rtrim($str,',');
        $where['id'] = array('in',$in);
       // $list = $member->where($ins)->select();
      }
    }
    $where['level'] = 2;
    $count = D('member')->where($where)->count();
    $page=$_REQUEST['p'] ? $_REQUEST['p'] :1;
    $pageSize=20;  
    $offset=($page-1)*$pageSize;  
    $list=D('member')->where($where)->limit($offset,$pageSize)->order('id desc')->select();
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
  



  public function daili_index(){
  	 $sear = I('search');
    if($sear){
      $data['wx_name']=array('like','%'.$sear.'%');
      $find = D('member')->where($data)->count();
      
      if($find>0){
        $where['wx_name'] = array('like','%'.$sear.'%');
      }else{
        $nums['name']=array('like','%'.$sear.'%'); //模糊查询
        $member_data = D('member_data')->where($nums)->select();
        $str = '';
        foreach ($member_data as $key => $value) {
        $str .= $value['member_id'].',';
        }
        $in = rtrim($str,',');
        $where['id'] = array('in',$in);
       // $list = $member->where($ins)->select();
      }
    }
    $where['level'] = 3;
    $count = D('member')->where($where)->count();
    $page=$_REQUEST['p'] ? $_REQUEST['p'] :3;
    $pageSize=20;  
    $offset=($page-1)*$pageSize;  
    $list=D('member')->where($where)->limit($offset,$pageSize)->order('id desc')->select();
    $datapage=new \Think\Page($count,$pageSize);  
    $datapage->setConfig('header','<br/><br/>共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页');
    $datapage->setConfig('prev','上一页');
    $datapage->setConfig('next','下一页');
    $datapage->setConfig('theme','%UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %HEADER%');
    print_r($list);exit;
    $pageRes=$datapage->show();
    $this->assign('page',$pageRes);
    $this->assign('list',$list);


  	$this->display();
  }


   public function daili_sub(){
    $data['roletype'] = 1;
    $data['moneytype'] = 4;
    $data['status'] = 0;
    $find = D('finances')->where($data)->select();
    $this->assign('list',$find);
    $this->display();
   }

   public function ind_s(){
    $data['member_id'] = I('MEM');
    $data['status'] = array('neq',0);
    $list = D('indent')->where($data)->order('id desc')->select();
    $this->assign('list',$list);
    $this->display();
   }
    public function sub_finish(){
    if(IS_POST){
      //print_r($_POST);exit;
     $data['id'] = I('id');
     $lll = D('finances')->where($data)->find();
     $mem['id'] = $lll['userid'];
     $sta['status'] = 1;
     $ok1 = D('finances')->where($data)->save($sta);
     $lev['level'] = 2;
     $ok2 = D('member')->where($mem)->save($lev);
       if($ok2){
        
        $ber = D('member')->where($mem)->find();
        /*升级*/
        daili_zong_jia1($ber['refe_id']);
        /*判断 会员推荐人 是否需要升级  函数在common/function 下*/
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
              $ok3 = D('member')->where(array('id'=>$dai))->save($bian);
            }
          }
          if($zong){//判断
            $zong_find = D('member')->where(array('id'=>$zong))->find();
            $num_zhi_daili = daili_sum($ber['id']);
            $num_zhi_vip = vip_sum($ber['id']);
            if($zong_find['daili_zong']==100 && $zong_find['vip_zong']==200 && $num_zhi_daili==10 && $num_zhi_vip==20){
              $bian2['level'] = 4;//升级副总
              $ok4 = D('member')->where(array('id'=>$zong))->save($bian2);
            }
          }
          if($fuzong){//判断
            $fuzong_find = D('member')->where(array('id'=>$fuzong))->find();
            $num_zhi_daili = daili_sum($ber['id']);
            $num_zhi_vip = vip_sum($ber['id']);
            if($fuzong_find['daili_zong']==200 && $fuzong_find['vip_zong']==400 && $num_zhi_daili==15 && $num_zhi_vip==30){
              $bian3['level'] = 5;//升级ceo
              $ok5 = D('member')->where(array('id'=>$fuzong))->save($bian3);
            }
          }/*升级结束*/

       }
      if($ok1&&$ok2){
         return show(1,'操作成功，会员等级已提升');
       }else{
         return show(0,'操作失败');
       }
    }
   }

  public function kucun(){
    
    if(IS_POST){
     $data_id = I('id');
     $data_num = I('num');
     $mem_data = D('member_product')->where(array('member_id'=>$data_id))->find();
     if($mem_data){
       $save['goods_num'] = $data_num;
       $ok = D('member_product')->where(array('member_id'=>$data_id))->save($save);
     }else{
       $data['member_id'] = $data_id;
       $data['goods_num'] = $data_num;
       $ok = D('member_product')->add($data);
     }
     if($ok){
       return show(1,'调整成功');
     }else{
       return show(0,'调整失败');
     }
     
    }

  	
  }
     public function search(){
      $member = D('member');
      $data = $_REQUEST['search'];
      if($data){
        $nums['username']=array('like','%'.$data.'%'); //模糊查询
        $list = $member->where($nums)->select();
        $this->assign('list',$list);

     }

      $this->display();
    }
 
 public function suo(){
  if(IS_POST){
   $data['id'] = I('id');
   $aa['status'] = -1;
   $ok = D('member')->where($data)->save($aa);
   if($ok){
      return show(1,'锁定成功');
     }else{
      return show(0,'锁定失败');
     }
  }
 }
 public function jie(){
  if(IS_POST){
   $data['id'] = I('id');
   $aa['status'] = 0;
   $ok = D('member')->where($data)->save($aa);
   if($ok){
      return show(1,'解锁成功');
     }else{
      return show(0,'解锁失败');
     }
  }
 }
  public function get_member_value(){
    if(IS_POST){
     $id = I('id');
     $ss = get_member_level($id);
     echo json_encode($ss);
    }


  }

 
  public function edit_level_save(){
  	if($_POST){
  		//print_r($_POST);exit;
     $data['id'] = I('id');
     $datas['level'] = I('level');
     if($datas['level']==2){
      $datas['refe_id'] = I('refe_id');
     }
     $ok = D('member')->where(array('id'=>$data['id']))->save($datas);
     if($ok){
     	return show(1,'修改成功');
     }else{
     	return show(0,'修改失败');
     }
  	}
  }

      //-----------------------------------------删除
    public function del(){
        $del = D('member');
        $class_id['id'] = I('id');
         //print_r($class_id);exit;
        if($del->where($class_id)->delete()){
             return show(1,'删除成功');
        }else{
             return show(0,'删除失败');
        }
    }
     public function bdel(){
             $data = D('member');
             $datas = $_POST;
             $res = implode(',',$datas);
              if($datas){
                  if($data->delete($res)){
                      return show(1,'删除成功');
                  }else{ 
                      return show(1,'删除失败');
                  }
              }else{
                      return show(0,'请选择删除项');
              }
          } 




  /*取出该会员的所有vip数和代理数量*/
   function get_member_vip($id){   
    $data['refe_id'] = $id;
    $list = D('member')->where($data)->select();
    //print_r($arr);exit;
     $vip = 0;
     foreach ($list as $key => $value) {
      if($value['level']==1){//VIP
           $vip++;
      }
      get_member_vip($value['id']);  

     }
     return $vip;
   }

     /*取出该会员的所有vip数和代理数量*/
   function get_member_daili($id){   
    $data['refe_id'] = $id;
    $list = D('member')->where($data)->select();
    //print_r($list);exit;
      $daili = 0;
     foreach ($list as $key => $value) {
      if($value['level']==2){//代理
          $daili++;
          get_member_daili($value['id']);
      }
        
     }
     return $daili;
   }


/*++++++++++++++++++++++++++++++++++++  财务明细 +++++++++++++++++++++++++++*/

  public function ticheng(){
    $key = I('search');
    if($key){
      if(is_numeric($key)){
        $where['fin.indent'] = I('search');
      }else{
        $where['data.name'] = array('like','%'.$key.'%');
      }
      
    }else{
      $where = array();
    }

    
    $count=D('finances')
    ->table('fen_finances fin,fen_member_data data')
    ->field('fin.id,fin.money,fin.time,fin.full,data.name,data.phone')
    ->where('fin.userid=data.member_id and fin.moneytype=2')
    ->where($where)
    ->order('fin.id desc')->limit($offset,$pageSize)->count();
     

     $page=$_REQUEST['p'] ? $_REQUEST['p'] :1;
     $pageSize=20;  
     $offset=($page-1)*$pageSize; 
     
    $list=D('finances')
    ->table('fen_finances fin,fen_member_data data')
    ->field('fin.id,fin.money,fin.time,fin.full,fin.content,data.name,data.phone')
    ->where('fin.userid=data.member_id and fin.moneytype=2')
    ->where($where)
    ->order('fin.id desc')->limit($offset,$pageSize)->select();
   // $list = D('finances')->where($data)->select();
    $datapage=new \Think\Page($count,$pageSize);  
    $datapage->setConfig('header','<br/><br/>共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页');
    $datapage->setConfig('prev','上一页');
    $datapage->setConfig('next','下一页');
    $datapage->setConfig('theme','%UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %HEADER%');
    //print_r($list);exit;
    $pageRes=$datapage->show();
    $this->assign('page',$pageRes);
    $this->assign('list',$list);
    //print_r($list);exit;
    $this->display();
  }
  
  public function ticheng_list(){
    if($_GET){
     $key = $_REQUEST['search'];
     $where['moneytype'] = 2;
     if($key){
      if(is_numeric($key)){
        $where['indent'] = $key;
      }else{
        $nums['name']=array('like','%'.$key.'%');
        $mem_data = D('member_data')->where($nums)->select();
         $str = '';
        foreach ($mem_data as $key => $value) {
        $str .= $value['member_id'].',';
        }
        $in = rtrim($str,',');
        if(empty($mem_data)){
         $weixin['wx_name'] = array('like','%'.$key.'%');
         $mem_data2 = D('member')->where($weixin)->select();
         $str = '';
         foreach ($mem_data2 as $key2 => $value2) {
         $str .= $value2['id'].',';
         }
         $in = rtrim($str,',');
        }
        if(empty($in)){
         $in = -1;
        }
      
       
       $where['member_id'] = array('in',$in);
      }
      
     }
     //print_r($where);exit;
     $list = D('finances')->where($where)->select();
 /*   $count=D('finances')
    ->table('fen_finances fin,fen_member_data data')
    ->field('fin.id,fin.money,fin.time,fin.full,data.name,data.phone')
    ->where('fin.userid=data.member_id and fin.moneytype=2')
    ->where($where)
    ->order('fin.id desc')->limit($offset,$pageSize)->count();
     
     $page=$_REQUEST['p'] ? $_REQUEST['p'] :1;
     $pageSize=10;  
     $offset=($page-1)*$pageSize; 
     
    $list=D('finances')
    ->table('fen_finances fin,fen_member_data data')
    ->field('fin.id,fin.money,fin.time,fin.full,fin.content,data.name,data.phone')
    ->where('fin.userid=data.member_id and fin.moneytype=2')
    ->where($where)
    ->order('fin.id desc')->limit($offset,$pageSize)->select();
    
    $datapage=new \Think\Page($count,$pageSize);  
    $datapage->setConfig('header','<br/><br/>共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页');
    $datapage->setConfig('prev','上一页');
    $datapage->setConfig('next','下一页');
    $datapage->setConfig('theme','%UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %HEADER%');
    //print_r($list);exit;
    $pageRes=$datapage->show();*/
    $this->assign('page',$pageRes);
    $this->assign('list',$list);
    }


    $this->display();
  }

/**************************订单管理***************************/
/*=========待发货订单========*/
 public function indent(){
  /***************快递公司***********************/
  $trans = D('trans')->select();
  $this->assign('trans',$trans);
  /*************************************/
   $sear = $_REQUEST['search'];
    if($sear){
      $data['indents']=$sear;//array('like','%'.$sear.'%'); 
    }
  $data['status'] = 1;//代发货
  $count = D('indent')->where($data)->count();
  $page=$_REQUEST['p'] ? $_REQUEST['p'] :1;
  $pageSize=10;  
  $offset=($page-1)*$pageSize;  
  $list=D('indent')->where($data)->limit($offset,$pageSize)->order('id desc')->select();
  $datapage=new \Think\Page($count,$pageSize);  
  $datapage->setConfig('header','<br/><br/>共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页');
  $datapage->setConfig('prev','上一页');
  $datapage->setConfig('next','下一页');
  $datapage->setConfig('theme','%UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %HEADER%');
  //print_r($list);exit;
  $pageRes=$datapage->show();
  $this->assign('page',$pageRes);
  $this->assign('list',$list);
  if(IS_POST){
    $sear = I('search');

  }
  $this->display();
 }
/*=========已发货 待收货 订单========*/

  public function indent_2(){
    $sear = $_REQUEST['search'];
    if($sear){
      $data['indents']=$sear;//array('like','%'.$sear.'%'); 
    }
  $data['status'] = 2;//代发货
  $count = D('indent')->where($data)->count();
  $page=$_REQUEST['p'] ? $_REQUEST['p'] :1;
  $pageSize=10;  
  $offset=($page-1)*$pageSize;  
  $list=D('indent')->where($data)->limit($offset,$pageSize)->order('id desc')->select();
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

/*=========已收货 待评价 订单========*/

public function indent_3(){
  $sear = $_REQUEST['search'];
    if($sear){
      $data['indents']=$sear;//array('like','%'.$sear.'%'); 
    }
  $data['status'] = 3;//已收货

  $count = D('indent')->where($data)->count();
  $page=$_REQUEST['p'] ? $_REQUEST['p'] :1;
  $pageSize=10;  
  $offset=($page-1)*$pageSize;  
  $list=D('indent')->where($data)->limit($offset,$pageSize)->order('id desc')->select();
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

/*=========已收货 已评价 完成订单========*/

public function indent_4(){
   $sear = $_REQUEST['search'];
    if($sear){
      $data['indents']=$sear;//array('like','%'.$sear.'%'); 
    }
  $data['status'] = 4;//已评价

  $count = D('indent')->where($data)->count();
  $page=$_REQUEST['p'] ? $_REQUEST['p'] :1;
  $pageSize=10;  
  $offset=($page-1)*$pageSize;  
  $list=D('indent')->where($data)->limit($offset,$pageSize)->order('id desc')->select();
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




 public function indent_list(){
  $cache = I('CACHE');
  $data['id'] = array('in',$cache);
  $list = D('cache')->where($data)->select();
  $this->assign('list',$list);
  $this->display();
 }
/* 确认发货*/
  public function fahuo(){
   if(IS_POST){
      $data['id'] = I('id');
      $type['trans_id'] = I('trans');
      $type['trans_number'] = I('trans_number');
     // $type['type'] = 1;
      $type['status'] = 2;//已发货 待收货
      $type['fahuo_time'] = time();
      $ok = D('indent')->where($data)->save($type);
      /*$trans = D('trans')->where(array('id'=>$type['trans_id']))->field('name')->find();*/
      $indent = D('indent')->where($data)->field('indents')->find();
      $shouhuo = D('address')->where(array('id'=>$indent['address_id']))->field('name,phone')->find();

      if($ok){
        /*发货通知*/
        $openid = $member['wx_openid'];
        $ind = $indent['indents'];
        $time = $type['fahuo_time'];
        //$trans_number = $type['trans_number'];
        $member = $shouhuo['name'];
        $phone = $shouhuo['phone'];
        //indent_fahuo($openid,$ind,$trans,$trans_number);
        indent_fahuo($openid,$ind,$time,$member,$phone);
        return show(1,'操作成功');
      }else{
        return show(0,'操作失败');
      }
    
    
    
   }



  }

 



}