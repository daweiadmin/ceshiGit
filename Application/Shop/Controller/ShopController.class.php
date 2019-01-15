<?php 
namespace Shop\Controller;
use Think\Controller;
use Org\Util\Zipfile;
class ShopController extends CommenController {
     

   public function daili_index(){
        $data['parentid'] = session('shopUser.id');
        $data['type'] = 2;
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
        $this->assign('tree',$list);

        //未分配码段
        $data['activity_id'] = 0;
        $data['shop_id'] = session('shopUser.id');
        //print_r($data);exit;
        $code_list = D('code_num')->where($data)->order('pici desc')->select();
        $this->assign('code_list',$code_list);
    $this->display();
   }
     
     public function add_daili(){
        $data1['id'] = session('shopUser.id');
        $a = D('shop')->where($data1)->field('id,type')->find();
        $this->assign('shop',$a);
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
         $data['parentid'] = session('shopUser.id');
         $data['picture'] = I('picture');
         $data['time'] = time();
         $data['shop_id'] = session('shopUser.id');
         $data['status'] = 0;//未审核
         //print_r($data);exit;
         $ok = D('shop')->add($data);
          if($ok){
            return show(1,'新增成功，等待总平台审核');
          }else{
            return show(0,'新增失败');
          }
       }

        $this->display();
     }

     public function edit_daili(){
        $id['id'] = I('shop_id');
        $data = D('shop')->where($id)->find();
         
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
         //$data['parentid'] = I('parentid');
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
        $data['parentid'] = session('shopUser.id');
        $data['type'] = 3;
        //print_r($list);exit;
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
        $data['activity_id'] = 0;
        $data['shop_id'] = session('shopUser.id');
        //print_r($data);exit;
        $code_list = D('code_num')->where($data)->order('pici desc')->select();
        $this->assign('code_list',$code_list);
     $this->display();

     }

     public function login_change(){
        $login_id = I('login_id');
        if($login_id){
          $shop['id'] = $login_id;
          $shops = D('shop')->where($shop)->find();
          if($shops['parentid']==session('shopUser.id')){
            $shops['top_daili_id'] = session('shopUser.id');
            session('shopUser',$shops); 
            $this->success('正在跳转...',U('index/index'));
          }
        }


     }
   
      public function return_daili(){
        $login_id = I('daili_id');
        if($login_id){
          $shop['id'] = $login_id;
          $shops = D('shop')->where($shop)->find();
          if($shops['id']==session('shopUser.parentid')){
           // $shops['top_daili_id'] = session('shopUser.id');
            session('shopUser',$shops); 
            $this->success('正在跳转...',U('index/index'));
          }
        }


     }
   //充值页面
    public function recharge(){
      $per = D('admin')->where('id=2')->field('percent')->find();
       $this->assign('percent',$per['percent']);
      $this->display();
    }
   /**
     * 订单微信支付
     */
    public function wchatPay()
    { 
        if(IS_POST){

        $data['userid'] = session('shopUser.id'); 
        $data['moneytype'] = 1;//充值
        $data['money'] = I('record_money');
        $data['indents'] = time().session('shopUser.id'); 
        $data['status'] = -1;
        $data['time'] = time();//充值
        //print_r($data);exit;
        D('money_record')->add($data);
        $total_fee = I('money')*100;
        $order=array(
          'body'=>'账户充值',
          'total_fee'=>$total_fee,
          'out_trade_no'=>$data['indents'],
          'product_id'=>1
          );
        //print_r($order);exit;
       $path = weixinpay($order);

       return show(1,'',$path);
       }
    }
  

//回调路径 转到没有commoncontrpller里面
/*    public function notify_url(){
        $xml=file_get_contents('php://input', 'r'); 
        file_put_contents ('notify_url.txt' ,$xml);
        // 导入微信支付sdk
        Vendor('Weixinpay.Weixinpay');
        $wxpay=new \Weixinpay();
        $result=$wxpay->notify();
        file_put_contents ('113331.txt' ,$result);
        if ($result) {
            // 验证成功 修改数据库的订单状态等 $result['out_trade_no']为订单号
          $indents = $result['out_trade_no'];
          $record = D('money_record')->where(array('indents'=>$indents))->find();
          $shop['id'] = $record['user_id'];
          $sho = D('shop')->where($shop)->field('money')->find();
          $money['money'] = $sho['money']+$record['money'];
          $ok = D('shop')->where($shop)->save($money);
          if($ok){
            $data['status'] = 0;
            $data['full'] = $money['money'];
            D('money_record')->where(array('indents'=>$indents))->save($data);
          }
          
            
          }
        }*/

 

        



    }
 


  






























 ?>