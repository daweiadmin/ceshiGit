<?php 
namespace Shop\Controller;
use Think\Controller;
class TicketController extends CommenController {
  public function index(){
      $key = $_REQUEST['key'];
      if($key){
        $data['name'] = array('like','%'.$key.'%'); 
      }
      $data['shop_id'] = session('shopUser.id');
      $data['type'] = 1;
      $count = D('ticket')->where($data)->count();
	    $page=$_REQUEST['p'] ? $_REQUEST['p'] :1;
	    $pageSize=20;  
	    $offset=($page-1)*$pageSize;  
	    $list=D('ticket')->where($data)->limit($offset,$pageSize)->order('id desc')->select();
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

 public function add(){
    $sto['shop_id'] = session('shopUser.id');
    $store = D('store')->where($sto)->select(); 
    $this->assign('store',$store);
    if(IS_POST){
     $data['name'] = I('name');
     $data['content'] = I('content');
     $data['start_time'] = strtotime(I('start_date'));
     $data['end_time'] = strtotime(I('end_date'))+86399;
     $data['ticket_picture'] = I('ticket_picture');
     $data['link_picture'] = I('link_picture');
     $data['link'] = I('link');
     $store = I('store');
     $data['store_id'] = implode(',',$store);
     $data['status'] = 0;
     $data['type'] = 1;
     $data['shop_id'] = session('shopUser.id');
     $data['time'] = time();
    // print_r($data);exit;
     if(!$data['name']){
       return show(0,'请输入奖券名称');
     }
     if(!$data['content']){
       return show(0,'请输入奖券内容');
     }
     if(!$data['start_time']||!$data['end_time']){
       return show(0,'请设置奖券有效期');
     }
     $ok = D('ticket')->add($data);
     if($ok){
     	 return show(1,'保存成功');
     }else{
     	 return show(0,'保存失败');
     }

    }
  	$this->display();
  }


  public function dui_edit(){
     $data['id'] = I('dui_ticket_id');
     if($data['id']){
       	$this->assign('ticket_id',$data['id']);
        $aa = D('ticket')->where($data)->find();
        $aa['start_time'] = date('Y-m-d',$aa['start_time']);
        $aa['end_time'] = date('Y-m-d',$aa['end_time']);

        $this->assign('data',$aa);
        //取出已选门店
        if($aa['store_id']){
        $sto['id'] = array('in',$aa['store_id']);
        $store = D('store')->where($sto)->select();
       // print_r($store);exit;
       //取出所有门店
        $bbb['shop_id'] = session('shopUser.id');
        $store_list = D('store')->where($bbb)->select();
        foreach ($store_list as $key => $value) {
          if($value['id']==$store[$key]['id']){
            $store_list[$key]['check'] = 1;
          }
        }
       //dump($store_list);exit;
        $this->assign('store_list',$store_list);
        }
     }else{
     	$this->error('请选择您要修改的奖券');
     }

  	$this->display();
  }
  public function dui_save(){
     if(IS_POST){
     $data['name'] = I('name');
     $data['content'] = I('content');
     $data['start_time'] = strtotime(I('start_date'));
     $data['end_time'] = strtotime(I('end_date'))+86399;
     $data['ticket_picture'] = I('ticket_picture');
     $data['link_picture'] = I('link_picture');
     $store = I('store');
     $data['store_id'] = implode(',',$store);
     $data['link'] = I('link');
     $t_id['id'] = I('ticket_id');
     //print_r($data);exit;
     $ok = D('ticket')->where($t_id)->save($data);
     if($ok){
     	return show(1,'修改成功');
     }else{
     	return show(0,'修改失败');
     }

    }


  }

  public function you_index(){
      $key = $_REQUEST['key'];
      if($key){
        $data['name'] = array('like','%'.$key.'%'); 
      }
      $data['shop_id'] = session('shopUser.id');
      $data['type'] = 2;
      $count = D('ticket')->where($data)->count();
	    $page=$_REQUEST['p'] ? $_REQUEST['p'] :1;
	    $pageSize=20;  
	    $offset=($page-1)*$pageSize;  
	    $list=D('ticket')->where($data)->limit($offset,$pageSize)->order('id desc')->select();
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
   public function you_add(){
    if(IS_POST){
     $data['name'] = I('name');
     $data['you_type'] = I('you_type');
     $data['content'] = I('content');
     $data['start_time'] = strtotime(I('start_date'));
     $data['end_time'] = strtotime(I('end_date'))+86399;
     $data['ticket_picture'] = I('ticket_picture');
     $data['link_picture'] = I('link_picture');
     $data['link'] = I('link');
     $data['status'] = 0;
     $data['type'] = 2;//优惠券
     $data['shop_id'] = session('shopUser.id');
     $data['time'] = time();
     //print_r($data);exit;
     $ok = D('ticket')->add($data);
     if($ok){
     	return show(1,'保存成功');
     }else{
     	return show(0,'保存失败');
     }

    }


  	$this->display();
  } 

   public function you_edit(){
     $data['id'] = I('you_ticket_id');
     if($data['id']){
     	$this->assign('ticket_id',$data['id']);
        $aa = D('ticket')->where($data)->find();
        $aa['start_time'] = date('Y-m-d',$aa['start_time']);
        $aa['end_time'] = date('Y-m-d',$aa['end_time']);
       // print_r($aa['id']);exit;
        $this->assign('data',$aa);

        if($aa['store_id']){
        $sto['id'] = array('in',$aa['store_id']);
        $store = D('store')->where($sto)->select();
       //取出所有门店
        $bbb['shop_id'] = session('shopUser.id');
        $store_list = D('store')->where($bbb)->select();
        foreach ($store_list as $key => $value) {
          if($value['id']==$store[$key]['id']){
            $store_list[$key]['check'] = 1;
          }
        }
       }
       //dump($store_list);exit;
        $this->assign('store_list',$store_list);
     }else{
     	$this->error('请选择您要修改的奖券');
     }

  	$this->display();
  }
   public function you_save(){
     if(IS_POST){
     $data['name'] = I('name');
     $data['content'] = I('content');
     $data['you_type'] = I('you_type');
     $data['start_time'] = strtotime(I('start_date'));
     $data['end_time'] = strtotime(I('end_date'))+86399;
     $data['ticket_picture'] = I('ticket_picture');
     $data['link_picture'] = I('link_picture');
     $store = I('store');
     $data['store_id'] = implode(',',$store);
     $data['link'] = I('link');
     $t_id['id'] = I('ticket_id');
    // print_r($t_id);exit;
     $ok = D('ticket')->where($t_id)->save($data);
     if($ok){
     	return show(1,'修改成功');
     }else{
     	return show(0,'修改失败');
     }

    }


  }

  public function del(){
        $del = D('ticket');
        $class_id['id'] = I('id');
         //print_r($class_id);exit;
        if($del->where($class_id)->delete()){
             return show(1,'删除成功');
        }else{
             return show(0,'删除失败');
        }
    }

    public function ticket_hexiao(){
             
           $start_time = $_REQUEST['start_time'];
           $end_time = $_REQUEST['end_time'];
           $ticket_type = $_REQUEST['ticket_type'];
           $ticket_status = $_REQUEST['ticket_status'];
           $search_type = $_REQUEST['search_type'];
           $key = $_REQUEST['key'];
           $where = '';
           if($start_time&&$end_time){
            $where .= 'and re.time>"'.$start_time.'" and re.time<"'.$end_time.'"';
           }
           if($ticket_type){
             $where.=' and m_t.ticket_type="'.$ticket_type.'"';
           }
           if($ticket_status){
             $where.=' and m_t.hexiao_status="'.$ticket_status.'"';
           }
           if($search_type==1){
             $where.=' and m_t.hexiao_code_sn="'.$key.'"';
           }
           if($search_type==2){
             $where.=' and act.act_name like %"'.$key.'"%';
           }
               
             $shop_id = session('shopUser.id');
             $where .= ' and tik.shop_id="'.$shop_id.'"';
             $count=D('ticket')
             ->table('red_ticket tik,red_member_ticket m_t,red_member mem,red_activity act')
             ->field('tik.name,tik.content,tik.ticket_picture,tik.start_time,tik.end_time,tik.content,m_t.activity_id,m_t.hexiao_code_sn,m_t.status,m_t.time,m_t.hexiao_time,mem.wx_name,mem.sex')
             ->where('tik.id=m_t.ticket_id and m_t.member_id=mem.id and act.id=m_t.activity_id '.$where)->count(); 
         
            $page=$_REQUEST['p'] ? $_REQUEST['p'] :1;
            $pageSize=20;  
            $offset=($page-1)*$pageSize;  
            $datapage=new \Think\Page($count,$pageSize);  
            $datapage->setConfig('header','<br/><br/>共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页');  
            $datapage->setConfig('prev','上一页');
            $datapage->setConfig('next','下一页');
            $datapage->setConfig('theme','%UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %HEADER%');
            //print_r($list);exit;
            $pageRes=$datapage->show();
             $list=D('ticket')
             ->table('red_ticket tik,red_member_ticket m_t,red_member mem,red_activity act')
             ->field('tik.name,tik.content,tik.ticket_picture,tik.start_time,tik.end_time,tik.content,m_t.id,m_t.activity_id,m_t.hexiao_code_sn,m_t.hexiao_status,m_t.status,m_t.time,m_t.hexiao_time,mem.wx_name,mem.sex,act.act_name')
             ->where('tik.id=m_t.ticket_id and m_t.member_id=mem.id and m_t.activity_id=act.id'.$where) 
             ->order('m_t.time desc')->limit($offset,$pageSize)->select();
             $this->assign('page',$pageRes);
             $this->assign('list',$list);

             $this->display();  
      }

      public function hexiao_save(){
        if(IS_POST){
         $m_t = I('m_t_id');
         $id['id'] = $m_t;
         $data['hexiao_status'] = 1;
         $data['hexiao_time'] = time();
         $ok = D('member_ticket')->where($id)->save($data);
          if($ok){
            return show(1,'核销成功');
           }else{
            return show(0,'核销失败');
           }
        }
      }


}