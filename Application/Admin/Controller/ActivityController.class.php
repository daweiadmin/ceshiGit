<?php 
namespace Admin\Controller;
use Think\Controller;
class ActivityController extends CommenController {

	 public function index(){
     header("Content-type:text/html;charset=utf-8");
      $act_status = $_REQUEST['act_status'];
      $shenhe_status = $_REQUEST['shenhe_status'];
      $key = $_REQUEST['key'];
      if($act_status){
        $data['act_status']=$act_status;
      }
      if($shenhe_status){
        $data['shenhe_status']=$shenhe_status;
      }
      if($key){
         $data['act_name']=array('like','%'.$key.'%'); //模糊查询
      }
      //$data['shop_id'] = session('shopUser.id');
      //print_r($data);exit;
        $count = D('activity')->where($data)->count();
	    $page=$_REQUEST['p'] ? $_REQUEST['p'] :1;
	    $pageSize=5;  
	    $offset=($page-1)*$pageSize;  
	    $list=D('activity')->where($data)->limit($offset,$pageSize)->order('id desc')->select();
	    $datapage=new \Think\Page($count,$pageSize);  
	    $datapage->setConfig('header','<br/><br/>共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页');  
	    $datapage->setConfig('prev','上一页');
	    $datapage->setConfig('next','下一页');
	    $datapage->setConfig('theme','%UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %HEADER%');
	    //print_r($list);exit;
	    $pageRes=$datapage->show();
	    $this->assign('page',$pageRes);
	    $this->assign('list',$list);
      
      //未选择码段
      $code['activity_id'] = 0;
      $code['shop_id'] = session('shopUser.id');
      $code_list = D('code_num')->where($code)->select();
      $this->assign('code_list',$code_list);
	 	$this->display();
	 }
    
     public function activity_shenhe(){
     	$data['status'] = 0;
      $count = D('activity')->where($data)->count();
	    $page=$_REQUEST['p'] ? $_REQUEST['p'] :1;
	    $pageSize=5;  
	    $offset=($page-1)*$pageSize;  
	    $list=D('activity')->where($data)->limit($offset,$pageSize)->order('id desc')->select();
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




   ///修改状态
   public function tongguo(){
     if(IS_POST){
      $data['id'] = I('id');
      $sta['status'] = 1;
      $ok = D('activity')->where($data)->save($sta);
      if($ok){
           return show(1,'操作成功');
       }else{
         return show(0,'操作失败');
       }
     }

   }
   public function refuse(){
     if(IS_POST){
      $data['id'] = I('id');
      $sta['status'] = -1;
      $sta['refuse'] = I('refuse');
      $ok = D('activity')->where($data)->save($sta);
      if($ok){
           return show(1,'操作成功');
       }else{
         return show(0,'操作失败');
       }
     }

   }
 
  public function set_activity_code(){
    if(IS_POST){
        $activity_id = I('id');
        ob_end_clean();
        $link_url = 'http://redbag.lingcheng888.com/index.php/home/wechat/index?activity_id='.$activity_id;
        $level=3;  
        $size=4;  
        Vendor('phpqrcode.phpqrcode');  
        $errorCorrectionLevel =intval($level) ;//容错级别  
        $matrixPointSize = intval($size);//生成图片大小  
        //生成二维码图片  
        $object = new \QRcode();  
        $path = "Public/erweima/";
        $file = $path.'activity'.$activity_id.".png";
        //print_r($url);exit;
        $object->png($link_url, $file, $errorCorrectionLevel, $matrixPointSize, 2); 
        $path2 = '/Public/erweima/activity'.$activity_id.".png"; 
        
        $data['id'] = $activity_id;
        $save['activity_code'] = $path2;
        $ok = D('activity')->where($data)->save($save);
         if($ok){
           return show(1,'二维码已生成');
         }else{
           return show(0,'生成失败');
         }
        
       }
    }
    
       
       //上传图片
       public function upload(){
        if($_FILES['file']['tmp_name'] != ''){
             $upload = new \Think\Upload();// 实例化上传类
             $upload->maxSize   =     9437184 ;// 设置附件上传大小6m

             $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
             $upload->rootPath  =   './'  ; // 设置附件上传根目录
             $upload->savePath  =  '/Public/Uploads/';
             // 上传单个文件 
                $info   =   $upload->uploadOne($_FILES['file']);
                if(!$info) {// 上传错误提示错误信息
                    return show(0,$upload->getError());
                }else{// 上传成功 获取上传文件信息
                   $data = $info['savepath'].$info['savename'];
                   echo $data;exit;
                }           
            }
        }


     public function record(){
           $start_time = strtotime($_REQUEST['start_time']);
           $end_time = strtotime($_REQUEST['end_time'])+86399;
           $key = $_REQUEST['key'];
          if($start_time&&$end_time){
             //$where .= 'and money.time>"'.$start_time.'" and money.time<"'.$end_time.'"';
             $where .= " and money.time  BETWEEN $start_time AND $end_time";
           }
           if($key){
              $where.=' and shop.name like %"'.$key.'"%';
           }
         $count=D('money_record')
             ->table('red_money_record money,red_shop shop')
             ->field('money.money,money.time,shop.name')
             ->where('money.userid=shop.id and money.moneytype=1 and money.status=0 '.$where) 
             ->count();
         $page=$_REQUEST['p'] ? $_REQUEST['p'] :1;
         $pageSize=20;  
         $offset=($page-1)*$pageSize;    

         $list=D('money_record')
         ->table('red_money_record money,red_shop shop')
         ->field('money.money,money.time,shop.name')
         ->where('money.userid=shop.id and money.moneytype=1 and money.status=0'.$where) 
         ->order('money.time desc')->limit($offset,$pageSize)->select();
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






      }
































 ?>