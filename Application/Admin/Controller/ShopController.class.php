<?php 
namespace Admin\Controller;
use Think\Controller;
class ShopController extends CommenController {

	 public function daili_index(){
        /*商户list*/
        $shop = D('shop');
        $b = $shop->shoptree();
        $count=count($b);
        $Page=new \Think\Page($count,20);
        $Page->setConfig('header','<br/><br/>共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('theme','%UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %HEADER%');
        $show       = $Page->show();
        $list=array_slice($b,$Page->firstRow,$Page->listRows);
        $this->assign('tree',$list);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出

        //未分配码段
        $data['shop_id'] = 0;
        $code_list = D('code_num')->where($data)->order('pici desc')->select();
        $this->assign('code_list',$code_list);
	 	$this->display();
	 }
     
     public function add_daili(){
        $shop = D('shop');
        $b = $shop->shoptree();
        $this->assign('tree',$b);
       if(IS_POST){
         $data['type'] = I('type');
         $data['username'] = I('username');
         $have = D('shop')->where("username='$data[username]'")->field('id')->find();
         if($have){
           return show(0,'用户名已存在，请更换一个用户名');
         }
         $data['password'] = get_md5(I('password'));
         $data['name'] = I('name');
         $data['link_man'] = I('link_man');
         $data['phone'] = I('phone');
         $data['email'] = I('email');
         $data['address'] = I('address');
         $end_time = strtotime(I('end_time'));
         $data['end_time'] = $end_time+86399;
         $data['parentid'] = I('parentid');
         $data['picture'] = I('picture');
         $data['time'] = time();
         $data['status'] = 1;//已审核
         $ok = D('shop')->add($data);
          if($ok){
            return show(1,'新增成功');
          }else{
            return show(0,'新增失败');
          }
       }

        $this->display();
     }

     public function edit_daili(){
        $id['id'] = I('shop_id');
        $data = D('shop')->where($id)->find();
         $this->assign('data',$data);
         $this->assign('data',$data);
         $dai_list = D('Shop')->shoptree();
         $this->assign('tree',$dai_list);
        if(IS_POST){
         $data['type'] = I('type');
         $data['username'] = I('username');
         $data['name'] = I('name');
         $data['link_man'] = I('link_man');
         $data['phone'] = I('phone');
         $data['email'] = I('email');
         $data['address'] = I('address');
         $end_time = strtotime(I('end_time'));
         $data['end_time'] = $end_time+86399;
         $data['parentid'] = I('parentid');
         $data['logo'] = I('picture');
         $shop['id'] = I('shop_id');
        // print_r($shop);exit;
         $ok = D('shop')->where($shop)->save($data);
          if($ok){
            return show(1,'编辑成功');
          }else{
            return show(0,'编辑失败');
          }
       }
        $this->display();
     }
     
     public function check_index(){
        $data['type'] = array('neq',1);
        $data['status'] = 0;
        $count = D('shop')->where($data)->count();
        $page=$_REQUEST['p'] ? $_REQUEST['p'] :1;
        $pageSize=20;  
        $offset=($page-1)*$pageSize;  
        $list=D('shop')->where($data)->limit($offset,$pageSize)->order('id desc')->select();
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
     //商户代理审核通过
     public function check_success(){
       if(IS_POST){
         $data['id'] = I('id');
         $ok = D('shop')->where($data)->save(array('status'=>1));
         if($ok){
              return show(1,'操作成功');
             }else{
              return show(0,'操作失败');
             }
          }
       }
      
      public function refuse(){
         if(IS_POST){
         $data['id'] = I('shop_id');
         $save['status'] = -2;
         $save['content'] = I('content');
         $ok = D('shop')->where($data)->save($save);
         if($ok){
              return show(1,'操作成功,已通知其上级代理');
             }else{
              return show(0,'操作失败');
             }
          }
      }

      public function suo(){
          if(IS_POST){
           $data['id'] = I('id');
           $aa['status'] = -1;
           $ok = D('shop')->where($data)->save($aa);
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
           $ok = D('shop')->where($data)->save($aa);
           if($ok){
              return show(1,'解锁成功');
             }else{
              return show(0,'解锁失败');
             }
          }
         }
         
         public function change(){
          if(IS_POST){
           $data['id'] = I('id');
           $aa['password'] = get_md5('12345');
           $ok = D('shop')->where($data)->save($aa);
           if($ok){
              return show(1,'密码重置成功,原始密码为12345');
             }else{
              return show(0,'密码重置失败，该账号密码已为原始密码，请不要重复操作');
             }
          }

         }
          
        
        public function fenpei(){
          if(IS_POST){
             $code_num_id = I('code_num_id');
             $shop = I('click_shop_id');
             foreach ($code_num_id as $key => $value) {
               $res['id'] = $value;
               $save['shop_id'] = $shop;
               $ok = D('code_num')->where($res)->save($save);
             }
             if($ok){
              return show(1,'分配成功');
             }else{
              return show(0,'分配失败');
             }

          }

        }

     public function store(){
        $data['type'] = 3;
        $count = D('shop')->where($data)->count();
        $page=$_REQUEST['p'] ? $_REQUEST['p'] :1;
        $pageSize=20;  
        $offset=($page-1)*$pageSize;  
        $list=D('shop')->where($data)->limit($offset,$pageSize)->order('id desc')->select();
        $datapage=new \Think\Page($count,$pageSize);  
        $datapage->setConfig('header','<br/><br/>共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页');  
        $datapage->setConfig('prev','上一页');
        $datapage->setConfig('next','下一页');
        $datapage->setConfig('theme','%UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %HEADER%');
        //print_r($list);exit;
        $pageRes=$datapage->show();
        $this->assign('page',$pageRes);
        $this->assign('list',$list);
         //未分配码段
        $data['shop_id'] = 0;
        $code_list = D('code_num')->where($data)->order('pici desc')->select();
        $this->assign('code_list',$code_list);
     $this->display();

     }








  

}




























 ?>