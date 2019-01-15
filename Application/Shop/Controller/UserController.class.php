<?php 
namespace Shop\Controller;
use Think\Controller;
class UserController extends CommenController {

   public function index(){
     $shop['id'] = session('shopUser.id');
    // print_r($shop);exit;
     $data = D('shop')->where($shop)->find();
     $this->assign('data',$data);
    $this->display();
   }
   public function save(){
    if(IS_POST){
         $data['name'] = I('name');
         $data['link_man'] = I('link_man');
         $data['phone'] = I('phone');
         $data['email'] = I('email');
         $data['address'] = I('address');
         //$end_time = strtotime(I('end_time'));
         //$data['end_time'] = $end_time+86399;
         $data['logo'] = I('picture');
         $shop['id'] = session('shopUser.id');
        // print_r($shop);exit;
         $ok = D('shop')->where($shop)->save($data);
          if($ok){
            return show(1,'保存成功');
          }else{
            return show(0,'保存失败');
          }
    }


   }
	 public function bian(){
      
      $this->display();
	 }
      public function change(){
        if(IS_POST){
         $data['id'] = session('shopUser.id');
         $dta['password'] = I('pwd');
         $new['password'] = get_md5(I('new'));
         $ddd = D('shop')->where($data)->field('password')->find();
         if(get_md5($dta['password'])!==$ddd['password']){
          return show(0,'旧密码不正确');
         }
         $ok = D('shop')->where($data)->save($new);
         if($ok){
           return show(1,'更改成功');
         }else{
           return show(1,'更改失败');
         }
        }
        
     }
     
     public function store(){
        $data['shop_id'] = session('shopUser.id');
        $list = D('store')->where($data)->select();
        $this->assign('list',$list);

      $this->display();
     }
     
     public function add_store(){
      if(IS_POST){
        $data['name'] = I('name');
        $data['address'] = I('address');
        $data['phone'] = I('phone');
        $data['shop_id'] = session('shopUser.id');
        $data['time'] = time();
        $ok = D('store')->add($data);
        if($ok){
           return show(1,'新增成功');
         }else{
           return show(1,'新增失败');
         }
      }

      $this->display();
     }


     public function edit_store(){
       $data['id'] = I('store_id');
       if($data['id']){
        $this->assign('store_id',$data['id']);
         $fin = D('store')->where($data)->find();
         $this->assign('data',$fin);
       }

      $this->display();
     }

  public function store_save(){
     if(IS_POST){
      $data['name'] = I('name');
      $data['address'] = I('address');
      $data['phone'] = I('phone');
      $t_id['id'] = I('id');
    // print_r($t_id);exit;
      $ok = D('store')->where($t_id)->save($data);
     if($ok){
      return show(1,'修改成功');
     }else{
      return show(0,'修改失败');
     }

    }


  }

    public function del(){
        $del = D('store');
        $class_id['id'] = I('id');
         //print_r($class_id);exit;
        if($del->where($class_id)->delete()){
             return show(1,'删除成功');
        }else{
             return show(0,'删除失败');
        }
    }

    public function hexiao(){
      $shop['id'] = session('shopUser.id');
      $shops = D('shop')->where($shop)->field('hexiao_code')->find();
      $data['shop_id'] = $shop['id'];
      $list = D('member')->where($data)->select();
      $this->assign('list',$list); 

       
      $this->display();
    }
    
    public function hexiao_code(){
        $shop_id = session('shopUser.id');
        ob_end_clean();
        $link_url = 'http://redbag.lingcheng888.com/index.php/home/wechat/hexiao?shop_id='.$shop_id;
        $level=3;  
        $size=4;  
        Vendor('phpqrcode.phpqrcode');  
        $errorCorrectionLevel =intval($level) ;//容错级别  
        $matrixPointSize = intval($size);//生成图片大小  
        //生成二维码图片  
        $object = new \QRcode();  
        //print_r($url);exit;
        $object->png($link_url,false, $errorCorrectionLevel, $matrixPointSize, 2); 
    }


      public function suo_hexiao(){
          if(IS_POST){
           $data['id'] = I('id');
           $aa['hexiao_status'] = 0;
           $ok = D('member')->where($data)->save($aa);
           if($ok){
              return show(1,'锁定成功');
             }else{
              return show(0,'锁定失败');
             }
          }
         }
         public function jie_hexiao(){
          if(IS_POST){
           $data['id'] = I('id');
           $aa['hexiao_status'] = 1;
           $ok = D('member')->where($data)->save($aa);
           if($ok){
              return show(1,'解锁成功');
             }else{
              return show(0,'解锁失败');
             }
          }
         }


      public function del_hexiao(){
        $del = D('product');
        $data['id'] = I('id');
        $aa['hexiao_status'] = 1;
        $aa['shop_id'] = NULL;
        $ok = D('member')->where($data)->save($aa);
        if($ok){
             return show(1,'删除成功');
        }else{
             return show(0,'删除失败');
        }
    }



	}