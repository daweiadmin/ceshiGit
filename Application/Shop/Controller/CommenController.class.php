<?php 
namespace Shop\Controller;
use Think\Controller;

 class CommenController extends Controller {
    
    public function __construct(){
        parent::__construct();
        $shop['id'] = $_GET['admin_shop_id'];
        if($shop['id']){
          $shopdata = D('shop')->where($shop)->find();
          session('shopUser',$shopdata);
        }
         
        $this->_init();
       
    }
    public function _init(){
        $user=session('shopUser');
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






