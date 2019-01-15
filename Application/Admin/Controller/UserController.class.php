<?php 
namespace Admin\Controller;
use Think\Controller;
class UserController extends CommenController {

	 public function bian(){
      
      $this->display();
	 }
      public function change(){
        if(IS_POST){
         $data['id'] = session('User.id');
         $dta['password'] = I('pwd');
         $new['password'] = get_md5(I('new'));
         $ddd = D('admin')->where($data)->field('password')->find();
         if(get_md5($dta['password'])!==$ddd['password']){
          return show(0,'旧密码不正确');
         }
         $ok = D('admin')->where($data)->save($new);
         if($ok){
           return show(1,'更改成功');
         }else{
           return show(1,'更改失败');
         }
        }
        
     }
     /********************** 快递公司 *****  **** **** ***************************/
     public function trans(){
      $list = D('trans')->select();
      $this->assign('list',$list);
      $this->display();
     }
    public function add_trans(){
      
      if(IS_POST){
       $add=D('trans');
       $data['name'] = I('name');
       $data['number'] = I('number');
       if(!$data['name']){
             return show(0,'请输入快递名称');
          }
       $ok = $add->add($data);
       if($ok){
         return show(1,'添加成功');
       }else{
         return show(0,'添加失败');
       }

      }
      
      $this->display();
    }

    public function edit_trans(){
      if(IS_GET){
        $id['id'] = $_GET['id'];
        $edi = D('trans');
        $editdata = $edi->where($id)->find();
        $this->assign('data',$editdata);
      }
        
        $this->display();
    }

         public function save(){
           $edi = D('trans');
          if(IS_POST){
            $data['id'] = I('id');
            $data['name'] = I('name');
            $data['number'] = I('number');
             if($edi->save($data)){
                  return show(1,'恭喜您，修改成功');
             }else{
                  return show(0,'您未进行修改，如不需修改，请直接返回列表页面');
             }
     
         }
       }
    public function del(){
        $del = D('trans');
        $class_id['id'] = I('id');
         //print_r($class_id);exit;
        if($del->where($class_id)->delete()){
             return show(1,'删除成功');
        }else{
             return show(0,'删除失败');
        }
    }





	}