<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller{

    public function __construct(){dierci tijiao
        parent::__construct();
          $ref_id = $_GET['ref_id'];
         if($ref_id){
           //print_r($ref_id);exit;
           session('get_refe_id',$ref_id);
         }
        /* $have_session = session('memberUser.id');
         if(!$have_session){
         $config = C('WEIXINPAY_CONFIG');
         $appid = $config['APPID'];

         $uri = 'http://'.$_SERVER['HTTP_HOST'].U('index/index');
         //print_r($uri);exit;
         $redirect_uri = urlEncode($uri);
         $scope = "snsapi_userinfo";
         $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=$scope&state=STATE#wechat_redirect";
         Header("Location: $url");
         }else{
         $user = D('member')->where(array('id'=>$have_session))->find();
            if($user['erweima_time']<time()){//如果二维码过期
            /*生成新的推广二维码*
                  ob_end_clean();
                  //file_put_contents ( '3.txt' ,'二维码生成开始22');
                  $link_url = erweima_url($user['id']);
                 // file_put_contents ( 'erwei.txt' ,$link_url);
                  $level=3;
                  $size=4;
                  Vendor('phpqrcode.phpqrcode');
                  $errorCorrectionLevel =intval($level) ;//容错级别
                  $matrixPointSize = intval($size);//生成图片大小
                  //生成二维码图片
                  $object = new \QRcode();
                  $path = "Public/erweima/";
                  $file = $path.'erweima'.$user['id'].".png";
                  //print_r($url);exit;
                  $object->png($link_url, $file, $errorCorrectionLevel, $matrixPointSize, 2);
                  $sss['erweima'] = '/Public/erweima/erweima'.$user['id'].".png";
                  $sss['erweima_time'] = time()+2548800;//临时二维码 有效时间30天 提前12个小时更新 到
                  D('member')->where(array('id'=>$user['id']))->save($sss);
           }
         } */

    }
   public function jump_index(){
         $ref_id = $_GET['ref_id'];
         if($ref_id){
           session('get_refe_id',$ref_id);
         }
         header('Content-type:text/html;charset=utf-8');
         $have_session = session('memberUser.id');
         if($have_session){
         $config = C('WEIXINPAY_CONFIG');
         $appid = $config['APPID'];

         $uri = 'http://'.$_SERVER['HTTP_HOST'].U('index/index');
         //print_r($uri);exit;
         $redirect_uri = urlEncode($uri);
         $scope = "snsapi_userinfo";
         $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=$scope&state=STATE#wechat_redirect";
         Header("Location: $url");
         }else{
          $this->index();
         }
    }

   public function index(){
    /*微信授权登录*/
     if($_GET["code"]){
        //print_r($_GET["code"]);exit;
        $config = C('WEIXINPAY_CONFIG');
        $appid = $config['APPID'];
        $SECRET = $config['APPSECRET'];
        header("Content-Type: text/html; charset=UTF-8");
        $code = $_GET["code"];
        if(!$code){
          $this->error('没有code！');
        }
        $token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$SECRET&code=$code&grant_type=authorization_code";
        $res = $this->https_request($token_url);
        if(!$res){
          $this->error('没有收到token！');
        }
        $res2  = json_decode($res,true);

        $openid = $res2["openid"];
         //print_r($openid);exit;
        $user = D('member')->where(array('wx_openid'=>$openid))->find();
        //print_r($user);exit;
        if($user){
          /*查看二维码是否过期*/

          if($user['erweima_time']<time()){
            /*生成新的推广二维码*/
                  ob_end_clean();
                  //file_put_contents ( '3.txt' ,'二维码生成开始22');
                  $link_url = erweima_url($user['id']);
                 // file_put_contents ( 'erwei.txt' ,$link_url);
                  $level=3;
                  $size=4;
                  Vendor('phpqrcode.phpqrcode');
                  $errorCorrectionLevel =intval($level) ;//容错级别
                  $matrixPointSize = intval($size);//生成图片大小
                  //生成二维码图片
                  $object = new \QRcode();
                  $path = "Public/erweima/";
                  $file = $path.'erweima'.$user['id'].".png";
                  //print_r($url);exit;
                  $object->png($link_url, $file, $errorCorrectionLevel, $matrixPointSize, 2);
                  $sss['erweima'] = '/Public/erweima/erweima'.$user['id'].".png";
                  $sss['erweima_time'] = time()+2548800;//临时二维码 有效时间30天 提前12个小时更新 到
                  D('member')->where(array('id'=>$user['id']))->save($sss);
          }
          $sess['id'] = $user['id'];
          session('memberUser',$sess);
          $url=U('home/member2/index');
       // 前往支付
          redirect($url);
        }else{
          $access_token = $res2["access_token"];
          $url2 = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
          $mem_json_data = $this->https_request($url2);
        //print_r($mem_json_data);exit;
          if(!$mem_json_data){
            $this->error('没有收到用户信息！');
          }
          $mem_data = json_decode($mem_json_data,true);
          //print_r($mem_data);exit;
          if(!empty($mem_data)&&$mem_data['sex']){

              $mem['wx_openid'] = $mem_data['openid'];
              $mem['wx_name'] = $mem_data['nickname'];//用户名
              $mem['sex'] = $mem_data['sex'];
              $mem['wx_pic'] = $mem_data['headimgurl'];//头像
              $mem['time'] = time();//头像
              $mem['oauth'] = '网页授权注册';//来源
              $ok = D('member')->add($mem);
              if($ok){

               $mem['id'] = $ok;
               session('memberUser',$mem);
                /*生成推广二维码*/
                  ob_end_clean();
                  //file_put_contents ( '3.txt' ,'二维码生成开始22');
                  $link_url = erweima_url($ok);
                 // file_put_contents ( 'erwei.txt' ,$link_url);
                  $level=3;
                  $size=4;
                  Vendor('phpqrcode.phpqrcode');
                  $errorCorrectionLevel =intval($level) ;//容错级别
                  $matrixPointSize = intval($size);//生成图片大小
                  //生成二维码图片
                  $object = new \QRcode();
                  $path = "Public/erweima/";
                  $file = $path.'erweima'.$ok.".png";
                  //print_r($url);exit;
                  $object->png($link_url, $file, $errorCorrectionLevel, $matrixPointSize, 2);
                  $sss['erweima'] = '/Public/erweima/erweima'.$ok.".png";
                  $sss['erweima_time'] = time()+2548800;//临时二维码 有效时间30天 提前12个小时更新 到
                  D('member')->where(array('id'=>$ok))->save($sss);

              }
          }
        }

      }
    /**/
  /*大分类*/
   $class = D('class')->where(array('parentid'=>0))->select();
   $this->assign('class',$class);
   $arr = array();
   foreach ($class as $key => $value) {
     $son_class = D('class')->where(array('parentid'=>$value['id']))->select();
     $str = '';
      foreach ($son_class as $key2 => $value2) {
        $str .= $value2['id'].',';
      }
      $in = rtrim($str,',');
      $where['class_id'] = array('in',$in);
      $where['tuijian'] = 1;
      $arr[$value['id']] = D('product')->where($where)->field('id,name,price,picture')->select();
   }

    //print_r($arr);exit;

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
    $this->assign('list',$arr);
    /*首页滚动广播*/
    $guangbo = D('guangbo')->select();
    $this->assign('guangbo',$guangbo);
    /*判断是否存在 分享的 ref_id*/
    $ref_id = session('memberUser.id');
    if($ref_id){
      $member = D('member')->where(array('id'=>$ref_id))->field('id,level')->find();
      if($member['level']>0){
       $this->assign('put_r_id',$ref_id);
      }
    }
     /*banner图*/
    $banner = D('banner')->find();
    $this->assign('banner',$banner);

   	$this->display();
   }

   public function lst(){
    if(IS_POST){/*首页搜索*/
     $sear = I('search');
     $this->assign('search',$sear);
    }
    $class_id = I('id');
    $this->assign('classid',$class_id);
    if($class_id){
      $data['parentid'] = $class_id;
      $clas['class_id'] = $class_id;
    }else{
      $data['parentid'] = 0;
      $clas = '';
    }
    /*分类*/
    $son = D('class')->where($data)->select();
    $this->assign('son_class',$son);
    /*品牌*/
    $pinpai = D('pinpai')->where($clas)->select();
    $this->assign('pinpai',$pinpai);
     /*判断是否存在 分享的 ref_id*/
    $ref_id = session('memberUser.id');
    if($ref_id){
      $member = D('member')->where(array('id'=>$ref_id))->field('id,level')->find();
      if($member['level']>0){
       $this->assign('put_r_id',$ref_id);
      }
    }
    $this->display();
   }

   public function ajax_lst(){
    if(IS_POST){

     $class_id = I('class_id');//一级分类id
     $class = I('class');//二级分类
     $pinpai =  I('pinpai');//品牌
     $price = I('price'); //价格
     $key = I('key'); //关键字 搜索
     if($key){
      $where['name'] = array('like','%'.$key.'%');
     }
    if($class_id){
      //print_r(1);exit;
      $where = array();
     /*筛选分类*/
      if($class!=-1){
      $where['class_id'] = $class;
      }else{
      /*不选择分类时则按照 传参过来的一级分类取数据*/
      $ll = D('class')->where(array('parentid'=>$class_id))->field('id')->select();
     // print_r($ll);exit;
       $str = '';
      foreach ($ll as $key => $value) {
        $str .= $value['id'].',';
       }
       $in = rtrim($str,',');
       $where['class_id'] = array('in',$in);
      }
     /*筛选品牌*/
      if($pinpai!=-1){
       $where['pinpai_id'] = $pinpai;
      }
      /*筛选价格*/
      if($price!=-1&&$price!=1){
       $arr = explode('-', $price);
       //print_r($arr);exit;
       if(count($arr)>1){
         $where['price'] = array('between',array($arr[0],$arr[1]));
       }else{
         $where['price'] = array('lt',$arr[0]);
       }
      }

      $list = D('product')->where($where)->field('id,name,picture,price')->select();
    }else{//class_id不存在 则代表用户点击的是下面导航栏产品（无传参）  则取所有商品
      // print_r($_POST);exit;
      /*筛选分类*/
      if($class!=-1){
      $ll = D('class')->where(array('parentid'=>$class))->field('id')->select();
      //print_r($ll);exit;
      $str = '';
      foreach ($ll as $key => $value) {
        $str .= $value['id'].',';
      }
      $in = rtrim($str,',');
      $where['class_id'] = array('in',$in);
      }
     /*筛选品牌*/
      if($pinpai!=-1){
       $where['pinpai_id'] = $pinpai;
      }
     /*筛选价格*/
      if($price!=-1&&$price!=1){
       $arr = explode('-', $price);
       //print_r($arr);exit;
       if(count($arr)>1){
         $where['price'] = array('between',array($arr[0],$arr[1]));
       }else{
         $where['price'] = array('lt',$arr[0]);
       }
      }
     $list = D('product')->where($where)->field('id,name,picture,price')->select();

    }
     //print_r($list);exit;
      echo json_encode($list);

    }
   }


  public function pro(){
    $good_id['id'] = $_GET['goodsid'];
    $find = D('product')->where($good_id)->find();
    //print_r($find);exit();
    $this->assign('find',$find);
    $pingjia = D('pingjia')->where(array('goods_id'=>$good_id['id']))->select();
    $this->assign('pingjia',$pingjia);
     /*判断是否存在 分享的 ref_id*/
    $ref_id = session('memberUser.id');
    if($ref_id){
      $member = D('member')->where(array('id'=>$ref_id))->field('id,level')->find();
      if($member['level']>0){
       $this->assign('put_r_id',$ref_id);
      }
    }
  	$this->display();
  }

  public function shoucang(){
   if(IS_POST){
    $ss = session('memberUser.id');
     if(!$ss){
     echo -1;exit;
     }
     $data['goods_id'] = I('goods_id');
     $data['mem_id'] = session('memberUser.id');
     $data['time'] = time();
     //print_r($data);exit;
     $ok = D('cang')->add($data);
     if($ok){
        return show(1,'收藏成功');
      }else{
        return show(0,'收藏失败');
      }
   }

  }
     /********************************** 添加购物车 *****************************************/


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
  public function wx_share(){
      $config = C('WEIXINPAY_CONFIG');
      Vendor('Wx_share.jssdk');
      $jssdk = new \JSSDK($config['APPID'], $config['APPSECRET']);
      $url = I('url');
     //print_r($url);exit;
      $key = md5($url);
      $signPackage = $jssdk->getSignPackage($url);
      //$string =  implode('_', $signPackage);
      echo json_encode($signPackage);
   }



}
