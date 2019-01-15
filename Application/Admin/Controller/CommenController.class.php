<?php 
namespace Admin\Controller;
use Think\Controller;

 class CommenController extends Controller {
    
    public function __construct(){
        parent::__construct();
        $this->_init();
       
    }
    public function _init(){
        $user=session('adminUser');
        if (!$user && !is_array($user)) {
            $this->redirect('login/index');
        }
    }
   /* public function _House(){
        $module=array('House','Client','Rent','Index');
        $con_name=CONTROLLER_NAME;
        if (!in_array($con_name,$module)) {
            $this->error('没有权限');
        }else{
            return true;
        }
    }*/
 /*   public function _market(){
        $module=array('Market','Account');
        $con_name=CONTROLLER_NAME;
        if (!in_array($con_name,$module)) {
            $this->error('没有权限');
        }else{
            return true;
        }
    }
    public function _finance(){
        $module=array('Finance','Member','Account','Area');
        $con_name=CONTROLLER_NAME;
        if (!in_array($con_name,$module)) {
            $this->error('没有权限');
        }else{
            return true;
        }
    }*/








 } 






