<?php 
namespace Home\Controller;
use Think\Controller;

 class CommenController extends Controller {
    
    public function __construct(){
        parent::__construct();
        $this->_init();
       
    }
    public function _init(){
        $user=session('memberUser.id');
       // print_r($user);exit;
        if (!$user) {
            $this->index_jump();
        }
    }
    
       /*授权登录*/
        public function index_jump(){
         header('Content-type:text/html;charset=utf-8');
         $config = C('WEIXINPAY_CONFIG');
         $appid = $config['APPID'];

         $uri = 'http://'.$_SERVER['HTTP_HOST'].U('index/index');
         //print_r($uri);exit;
         $redirect_uri = urlEncode($uri);
         $scope = "snsapi_userinfo";
         $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=$scope&state=STATE#wechat_redirect";
         Header("Location: $url");       
    }

    public function index(){
       //print_r('12345');exit;
       if($_GET["code"]){
        print_r($_GET["code"]);exit;
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
        $user = D('member')->where(array('wx_openid'=>$openid))->find();
        //print_r($user);exit;
        if($user){
          $sess['id'] = $user['id'];
          session('memberUser',$sess);
        }else{
          $this->error('您还不是我们的会员哦亲，快去关注我们的公众号吧');
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









 } 






