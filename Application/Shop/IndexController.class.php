<?php 
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller{

   public function index(){
    $count = D('product')->where(array('status'=>0))->count();
    $page=$_REQUEST['p'] ? $_REQUEST['p'] :1;
    $pageSize=10;  
    $offset=($page-1)*$pageSize;  
    $list=D('product')->where(array('status'=>0))->limit($offset,$pageSize)->select();
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
   
   public function lst(){
    $sear = $_REQUEST['search'];
    if($sear){
      $where['name']=array('like','%'.$sear.'%'); 
    }
    $where['status'] = 0;
    $count = D('product')->where($where)->count();
    $page=$_REQUEST['p'] ? $_REQUEST['p'] :1;
    $pageSize=6;  
    $offset=($page-1)*$pageSize;  
    $list=D('product')->where($where)->limit($offset,$pageSize)->order('id desc')->select();
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

  public function product(){
    $good_id['id'] = $_GET['id'];
    $find = D('product')->where($good_id)->find();
    $this->assign('find',$find);
  	$this->display();
  }

     /********************************** 添加购物车 *****************************************/
  public function cache(){
    

  	$this->display();
  }

/*   public function cache_save(){
    if(IS_POST){
     $data['good_id'] = I('good_id');
     //$data['num'] = I('num');
     $sess = session('memberUser.id');
     //print_r($sess);exit;
     if(!$sess){
      echo -1;exit;//没有登录
     }
     $cahe['goods_id'] = $data['good_id'];
     $cahe['member_id'] = $sess;
     $cahe['status'] = 0;
     $cah = D('cache')->where($cahe)->find();
     if(!$cah){
     $good_data = D('product')->where(array('id'=>$data['good_id']))->find();
     $cache_data['goods_name'] = $good_data['name'];
     $cache_data['goods_id'] = $good_data['id'];
     $cache_data['member_id'] = $sess;
     $cache_data['goods_member'] = $good_data['member'];
     $cache_data['picture'] = $good_data['picture'];
     $cache_data['goods_price'] = $good_data['price'];
     $cache_data['goods_size'] = $good_data['size'];
     $cache_data['goods_num'] = 1;
     $cache_data['indents'] = $sess.time().$data['good_id'];//会员id+当前时间戳+商品id
     $cache_data['time'] = time();
     $ok = D('cache')->add($cache_data);
     }else{
      $jia['goods_num'] = $cah['goods_num']+1;
      $ok = D('cache')->where($cahe)->save($jia);
     }
     if($ok){
      	return show(1,'成功添加到购物车');
      }else{
      	return show(0,'操作失败，请稍后再试');
      }
    }

  	
  }*/
 
    public function cache_save(){
    if(IS_POST){
     $data['good_id'] = I('good_id');
     $data['num'] = I('num');
     //print_r($data);exit;
     $sess = session('memberUser.id');
     //print_r($sess);exit;
     if(!$sess){
      echo -1;exit;//没有登录
     }                                        
     $cahe['goods_id'] = $data['good_id'];
     $cahe['member_id'] = $sess;
     $cahe['status'] = 0;
     $cah = D('cache')->where($cahe)->find();
     if(!$cah){
     $good_data = D('product')->where(array('id'=>$data['good_id']))->find();
     $cache_data['goods_name'] = $good_data['name'];
     $cache_data['goods_id'] = $good_data['id'];
     $cache_data['member_id'] = $sess;
     //$cache_data['goods_member'] = $good_data['member'];
     $cache_data['picture'] = $good_data['picture'];
     $cache_data['goods_price'] = $good_data['price'];
     $cache_data['goods_size'] = $good_data['size'];
     $cache_data['goods_num'] = 1;
     $cache_data['indents'] = $sess.time().$data['good_id'];//会员id+当前时间戳+商品id
     $cache_data['time'] = time();
     $ok = D('cache')->add($cache_data);
     }else{
      $jia['goods_num'] = $cah['goods_num']+1;
      $ok = D('cache')->where($cahe)->save($jia);
      $ok = $cah['id'];
     }
     if($ok){
        return show(1,'成功添加到购物车',$ok);
      }else{
        return show(0,'操作失败，请稍后再试');
      }
    }

    
  }
  
  public function api(){
    
     $list = D('product')->field('id,name,price,picture')->select();


     $goods = array();
     foreach ($list as $key => $value) {

       $goods1['id'] = $value['id'];
       $goods1['name'] = $value['name'];
       $goods1['price'] = $value['price'];
       $goods1['picture'] = 'https://webchat.jfwide.com'.$value['picture'];
       $goods[] = $goods1;
     }

     $class = D('class')->where("parentid=0")->field('id,class_name,picture')->select();
       foreach ($class as $k => $v) {

       $cla['id'] = $v['id'];
       $cla['class_name'] = $v['class_name'];
       $cla['picture'] = 'https://webchat.jfwide.com'.$v['picture'];
       $class_list[] = $cla;
     }

   //dump($goods);exit;
     echo json_encode(array('status'=>1,'goods'=>$goods,'class_list'=>$class_list));
     //exit

  }

  public function goods_info(){

     $goods_id = intval($_REQUEST['goods_id']);
       if (!$goods_id){
            echo json_encode(array('status'=>0,'msg'=>'网络异常.'.__LINE__));
            exit();
        }
      $goods_info = D('product')->where("id=$goods_id")->find();
     $goods['picture'] = 'https://webchat.jfwide.com'.$goods_info['picture'];
      $goods['name'] = $goods_info['name'];
      $goods['picture2'] = 'https://webchat.jfwide.com'.$goods_info['picture2'];
      $goods['picture3'] = 'https://webchat.jfwide.com'.$goods_info['picture3'];
      $goods['price'] = $goods_info['price'];
      $goods['comment'] = htmlspecialchars_decode($goods_info['comment']);
      //print_r($goods_info);exit;
      
      echo json_encode(array('status'=>1,'goods'=>$goods));
   
  }

  public function api_login(){
     $code = intval($_REQUEST['code']);
    // echo json_encode(array('code'=>$code,'msg'=>'验证code.'));
     if (!$code){
          echo json_encode(array('status'=>0,'msg'=>'网络异常.'.__LINE__));
          exit();
      }
     $appid = 'wxaded9cf31d04c0f1';
     $secret = '7e2e259c19f812e00edecf8c5485efee';

    $url2 = "https://api.weixin.qq.com/sns/jscode2session?appid=$appid&secret=$secret&js_code=$code&grant_type=authorization_code";
    //echo json_encode(array('mem_json_data'=>$url2,'msg'=>'验证成功'));
     $mem_json_data = $this->https_request($url2);
     echo json_encode(array('mem_json_data'=>$mem_json_data,'msg'=>'验证成功'));


  }

    public function https_request($url, $data = null)
            {
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
                if (!empty($data)){
                    curl_setopt($curl, CURLOPT_POST, 1);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                $output = curl_exec($curl);
                curl_close($curl);
                return $output;
            }  

  
}