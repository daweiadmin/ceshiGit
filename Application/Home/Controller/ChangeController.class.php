<?php 
namespace Home\Controller;
use Think\Controller;
class ChangeController extends Controller{

      public function __construct(){
         parent::__construct();
        /* $xml=file_get_contents('php://input', 'r'); 
        file_put_contents ('5555.txt' ,$xml);*/
         }
         public function savedata(){
           $sss['activity_id'] = 0;
           $data['activity_id'] = array('in','65,67');
           $ok = D('code')->where($data)->save($sss);
           print_r($ok);exit;
         }
   

   }