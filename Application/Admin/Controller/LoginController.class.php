<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function index(){
    	if(IS_POST){
           // print_r($_POST);exit;
    	  $factory = D('admin');
          $name = I('username');
          $code = I('code');
    	  $data['password'] = I('password');
          $Verify = new \Think\Verify();
          $yan = $Verify->check($code);
          if(!$yan){
           return show(0,'验证码错误');
          }
          $result = $factory->where('username = "'.$name.'"')->find();

    	if(!$result){
            return show(0,'用户不存在');
    	}
        if($result['status']==-1){
            return show(0,'此用户已被冻结');
        }
        //echo get_md5($data['password']).'<br>'.$result['password'];exit;
        if(get_md5($data['password']) !== $result['password']){
            return show(0,'密码不正确');
        }
        session('adminUser',$result);  //session赋值
        return show(1,'登陆成功');
    	}
      $this->display('login');
    }
    public function sign(){
    
            if(IS_POST){
             $factory = D('admin');
             $data['username'] = I('username');//用户名
             $data['password'] = get_md5(I('password'));//密码
             $data['status']=0; //正常; 
             $data['time']=time();
             $userdata['username'] = $data['username'];
             $user=$factory->where($userdata)->find();
             if ($user!="") {
                 return show(0,'用户名已存在，可以直接登录');
             }
             if($factory->add($data)){
                return show(1,'恭喜您，注册成功');
             }else{
                return show(0,'注册失败');
             }
        }
        $this->display(); 
    }
  

            // 验证码
    public function verify(){  
        ob_clean();
        $Verify = new \Think\Verify();  
        // $Verify->fontSize = 18;  
        $Verify->length   = 4;  
        // $Verify->useNoise = false;  
        $Verify->codeSet = '0123456789';  
        //$Verify->expire = 600;  
        $Verify->entry();  
    }
    // 验证验证码
    public function code(){
        if(IS_POST){
            $verifys = trim($_POST['code']); 
                $Verify = new \Think\Verify();  
                if(!$Verify->check($verifys)){  
                    echo 1;
                    exit;
            }
        }
    }

      public function logout(){
        session('User',null);
        $this->success('成功退出',U('Login/index'));
     }

     

}