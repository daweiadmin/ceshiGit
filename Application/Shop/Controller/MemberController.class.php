<?php 
namespace Shop\Controller;
use Think\Controller;
class MemberController extends CommenController {

   public function index(){
           $shop_id = session('shopUser.id');
           $count=D('member')
             ->table('red_member mem,red_get_record get,red_activity act')
             ->field('mem.id,mem.wx_name,mem.sex,mem.wx_pic')
             ->where('get.member_id=mem.id and get.activity_id=act.id and act.shop_id="'.$shop_id.'"') 
             ->count();

            $page=$_REQUEST['p'] ? $_REQUEST['p'] :1;
            $pageSize=20;  
            $offset=($page-1)*$pageSize;

           $list=D('member')
             ->table('red_member mem,red_get_record get,red_activity act')
             ->field('mem.id,mem.wx_name,mem.sex,mem.wx_pic,get.id as record_id')
             ->where('get.member_id=mem.id and get.activity_id=act.id and act.shop_id="'.$shop_id.'"') 
             ->order('get.time desc')->limit($offset,$pageSize)->select();
            

            $datapage=new \Think\Page($count,$pageSize);  
            $datapage->setConfig('header','<br/><br/>共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页');  
            $datapage->setConfig('prev','上一页');
            $datapage->setConfig('next','下一页');
            $datapage->setConfig('theme','%UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %HEADER%');
            $pageRes=$datapage->show();
             $this->assign('page',$pageRes);
             $this->assign('list',$list);
     
    $this->display();
   }

   public function mem_info(){
      $member = I('mem_id');
      if($member){
        $shop['shop_id'] = session('shopUser.id');
        $act = D('activity')->where($shop)->field('id')->select();
        $str = '';
        foreach ($act as $key => $value) {
          $str.=$value['id'].',';
        }
        $in = rtrim($str,',');
        $data['member_id'] = $member;
        $data['activity_id'] = array('in',$in);
        $count = D('get_record')->where($data)->count();
        $page=$_REQUEST['p'] ? $_REQUEST['p'] :1;
        $pageSize=20;  
        $offset=($page-1)*$pageSize;  
        $list=D('get_record')->where($data)->limit($offset,$pageSize)->order('id desc')->select();
        $datapage=new \Think\Page($count,$pageSize);  
        $datapage->setConfig('header','<br/><br/>共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页');  
        $datapage->setConfig('prev','上一页');
        $datapage->setConfig('next','下一页');
        $datapage->setConfig('theme','%UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %HEADER%');
        //print_r($list);exit;
        $pageRes=$datapage->show();
        $this->assign('page',$pageRes);
        $this->assign('list',$list);


      }else{
        $this->error('q请选择你要查看的用户');
      }

    $this->display();
   }

   //店铺资金纪录
   public function record(){
   	    $data['userid'] = session('shopUser.id');
        $data['status'] = 0;
        //print_r($data);exit;
        $count = D('money_record')->where($data)->count();
  	    $page=$_REQUEST['p'] ? $_REQUEST['p'] :1;
  	    $pageSize=20;  
  	    $offset=($page-1)*$pageSize;  
  	    $list=D('money_record')->where($data)->limit($offset,$pageSize)->order('id desc')->select();
  	    $datapage=new \Think\Page($count,$pageSize);  
  	    $datapage->setConfig('header','<br/><br/>共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页');  
  	    $datapage->setConfig('prev','上一页');
  	    $datapage->setConfig('next','下一页');
  	    $datapage->setConfig('theme','%UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %HEADER%');
  	    //print_r($list);exit;
  	    $pageRes=$datapage->show();
  	    $this->assign('page',$pageRes);
  	    $this->assign('list',$list);
        
        $shop['id'] = session('shopUser.id');
        $shops = D('shop')->where($shop)->field('money')->find();
        $this->assign('shops',$shops['money']);
   
   $this->display();
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
      if($value['prize_type']==1||$value['prize_type']==1){
        $money_total+=$value['prize'];
      }
      if($value['prize_type']==3){
        $dui_total+=$value['prize'];
      }
      if($value['prize_type']==4){
        $you_total+=$value['prize'];
      }
     }
     $ttt['total'] = $total;
     $ttt['money_total'] = $money_total;
     $ttt['dui_total'] = $dui_total;
     $ttt['you_total'] = $you_total;
     $zong[] = $ttt;
    }
    return show(1,'',$zong);
    }
   	$this->display();
   }


}