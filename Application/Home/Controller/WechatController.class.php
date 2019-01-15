<?php 
namespace Home\Controller;
use Think\Controller;
class WechatController extends Controller{


   
   Public function index(){

            Vendor('Weixinpay.Weixinpay');
            $wxpay=new \Weixinpay();
            $baseUrl = urlencode('http://'.$_SERVER['HTTP_HOST']."/index.php/home/wechat/index".'?'.$_SERVER['QUERY_STRING']);
           // print_r($baseUrl);exit;
            $res = $wxpay->GetOpenid($baseUrl);//获取到带有openid和accesstoken 得json字符串
            //print_r($openid);exit;
            $result = json_decode($res,true);
            $openid = $result['openid'];
            $token = $result['access_token'];
            $activityid = $_GET['activityid'];
            $user = D('member')->where(array('wx_openid'=>$openid))->find();
          if($user){
            $sess['id'] = $user['id'];
            session('memberUser',$sess);

          }else{
            $url2 = "https://api.weixin.qq.com/sns/userinfo?access_token=$token&openid=$openid&lang=zh_CN";
            $mem_json_data = $this->https_request($url2);
          //print_r($mem_json_data);exit;
            if(!$mem_json_data){
              $this->error('没有收到用户信息！');
            }
            $mem_data = json_decode($mem_json_data,true);
           // file_put_contents ('mem_json_data.txt' ,$mem_json_data);
          //  print_r($mem_data);exit;
            if(!empty($mem_data)){
                $mem['wx_openid'] = $mem_data['openid'];
                $mem['wx_name'] = emoji_encode($mem_data['nickname']);//用户名
                $mem['sex'] = $mem_data['sex'];
                $mem['wx_pic'] = $mem_data['headimgurl'];//头像
                $mem['time'] = time();//头像
                $ok = D('member')->add($mem);
                if($ok){
                  $sess['id'] = $ok;
                  session('memberUser',$sess);
                }
              }
           }//member  end

           $sns['code_sn'] = I('sn');
           if(!$sns['code_sn']){
              $activity['activity_id'] = I('activity_id');
              if(!$activity['activity_id']){
                echo "<script>alert('链接错误');</script>";exit;
              }

              $activity['status'] = 0;
              $aa = D('code')->where($activity)->field('code_sn')->select();
              if(!$aa){
                 echo "<script>alert('奖励被领完了');</script>";exit;
              }
              $key = array_rand($aa,1);//取所有二维码种任意键值数据
              $sns['code_sn'] = $aa[$key]['code_sn'];
              $_GET['sn'] = $aa[$key]['code_sn'];
           }
           $code = D('code')->where($sns)->find();
           //判断二维码是否有效
           if($code['status']>0){
             echo "<script>alert('此二维码已被使用！');</script>";
             $url = 'http://'.$_SERVER['HTTP_HOST']."/index.php/home/wechat/tishi".'?error_code=此二维码已被使用！';
             Header("Location: $url");
             exit;
           }
           $code_num['id'] = $code['code_num_id'];
           $actcode = D('code_num')->where($code_num)->field('activity_id')->find();
           $act['id'] = $actcode['activity_id'];

           $acty = D('activity')->where($act)->find();
           if($acty['status']==0){
              echo "<script>alert('活动未审核！');</script>";
             $url = 'http://'.$_SERVER['HTTP_HOST']."/index.php/home/wechat/tishi".'?error_code=活动未审核！';
             Header("Location: $url");
             exit;
           }
           //dump($acty);exit;
           if($acty['act_status']!=='1'){
            echo "<script>alert('活动未开始！');</script>";
            $url = 'http://'.$_SERVER['HTTP_HOST']."/index.php/home/wechat/tishi".'?error_code=活动未开始！';
             Header("Location: $url");
             exit;
           }
           //判断是否开启区域限制

           //判断活动是否开启领取次数限制
           if($acty['cishu_status']==1){
             $m_c['member_id'] = session('memberUser.id'); 
             $m_c['activity_id'] = $acty['id'];
             $m_c_count = D('m_c')->where($m_c)->count();
              
               $have['member_id'] = session('memberUser.id');
               $have['activity_id'] = $acty['id'];
               $hh = D('get_record')->where($have)->count();
             //每人共参与次数
             if($acty['cishu1']){
                if($hh>=$acty['cishu1']||$m_c_count>=$acty['cishu1']){
                  echo "<script>alert('参与次数已达上限');</script>";
                 $url = 'http://'.$_SERVER['HTTP_HOST']."/index.php/home/wechat/tishi".'?error_code=参与次数已达上限';
                 Header("Location: $url");
                 exit;
                }
             }
               $day_start = mktime(0,0,0,date('m'),date('d'),date('Y'));
               $day_end = mktime(23,59,59,date('m'),date('d'),date('Y'));
               $have['time'] > $day_start;
               $have['time'] < $day_end;
               $hh = D('get_record')->where($have)->count();
             //每人每天参与次数
             if($acty['cishu2']){
               if($hh>=$acty['cishu2']||$m_c_count>=$acty['cishu2']){
                echo "<script>alert('参与次数已达上限');</script>";
                 $url = 'http://'.$_SERVER['HTTP_HOST']."/index.php/home/wechat/tishi".'?error_code=参与次数已达上限';
                 Header("Location: $url");
                 exit;
                }
             }
             //每天抽奖总次数
             if($acty['cishu3']){
              if($hh>=$acty['cishu3']||$m_c_count>=$acty['cishu3']){
                echo "<script>alert('参与次数已达上限');</script>";
                 $url = 'http://'.$_SERVER['HTTP_HOST']."/index.php/home/wechat/tishi".'?error_code=参与次数已达上限';
                 Header("Location: $url");
                 exit;
                }
             }
           }

           //增加到扫码记录
             $add_m_c['member_id'] = session('memberUser.id'); 
             $add_m_c['activity_id'] = $acty['id'];
             D('m_c')->add($add_m_c);
           
           if($acty['area_status']==1){
             $this->redirect('wechat/location', array('sn'=>$_GET['sn']));
              
            }
             //改变二维码状态 变成已扫码 未领取
            $ccc['status'] = 1;
            D('code')->where($sns)->save($ccc);
           //判断是否开启 收集用户信息功能
           if($acty['user_data']==1){
            $sn = $_GET['sn'];
            $url = 'http://'.$_SERVER['HTTP_HOST']."/index.php/home/wechat/user_data".'?sn='.$sn;

            //print_r($url);exit;
                Header("Location: $url");exit;
           }else{
               //判断活动方式
               if($acty['type']==1){ //直接领取
                $sn = $_GET['sn'];
                $url = 'http://'.$_SERVER['HTTP_HOST']."/index.php/home/wechat/get_now".'?sn='.$sn;
            //print_r($url);exit;
                Header("Location: $url");exit;
               }
               if($acty['type']==2){ //九宫格
                $sn = $_GET['sn'];
                $url = 'http://'.$_SERVER['HTTP_HOST']."/index.php/home/wechat/jiugong".'?sn='.$sn;
                Header("Location: $url");exit;
               }
               if($acty['type']==3){ //大转盘
                $sn = $_GET['sn'];
                $url = 'http://'.$_SERVER['HTTP_HOST']."/index.php/home/wechat/zhuanpan".'?sn='.$sn;
                Header("Location: $url");exit;
               }
               if($acty['type']==4){ //瓜瓜了
                $sn = $_GET['sn'];
                $url = 'http://'.$_SERVER['HTTP_HOST']."/index.php/home/wechat/guagua".'?sn='.$sn;
                Header("Location: $url");exit;
               }
                if($acty['type']==5){ //砸金蛋
                 $sn = $_GET['sn'];
                 $this->redirect('wechat/jindan', array('sn' => $sn));exit;
                // $url = 'http://'.$_SERVER['HTTP_HOST']."/index.php/home/wechat/jindan".'?sn='.$sn;
                 //Header("Location: $url");
               }

           }

        
      }

     

      //地理位置
      public function location(){
         $config = C('WEIXINPAY_CONFIG');
          Vendor('Wx_share.jssdk');
          $appid = $config['APPID'];
          $appsecret = $config['APPSECRET'];
          $jssdk = new \JSSDK($appid,$appsecret);
          $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
          $signPackage = $jssdk ->GetSignPackage($url);
          $this->assign('signPackage',$signPackage);
          //
          $sn['code_sn'] = I('sn');
          $code = D('code')->where($sn)->field('activity_id')->find();
          //商户资料
          
          $data['id'] = $code['activity_id'];
          $active = D('activity')->where($data)->field('shop_id,type,area_status,user_data')->find();
          $shop['id'] = $active['shop_id'];
          $shopdata = D('shop')->where($shop)->field('name,logo')->find();
          $this->assign('shopdata',$shopdata);
          $this->assign('activity_id',$code['activity_id']); 
          $this->assign('sn',$sn['code_sn']);
            /* switch ($active['type']) {
                case '1':
                  $type='get_now';
                  break;
                case '2':
                  $type='jiugong';
                  break;
                case '3':
                  $type='zhuanpan';
                  break;
                case '4':
                  $type='guagua';
                  break;
                case '5':
                  $type='jindan';
                  break;
              }*/
       $type = $active['type'];
       $user_data = $active['user_data'];
       $this->assign('type',$type);
       $this->assign('user_data',$user_data);
       $this->display();
      }

      public function location_success(){
         /*  $y = '38.001423';
           $x = '114.48019';
           $ak = 'VTRvaoF3l1LXS22MFGcPaAeeG1htsBPg';
           $ad = getAddress($x,$y,$ak);
           $data = json_decode($ad,true); 
           $coun['country'] = $data['result']['addressComponent']['country'];
           $coun['province'] = $data['result']['addressComponent']['province'];
           $coun['city'] = $data['result']['addressComponent']['city'];
           $coun['district'] = $data['result']['addressComponent']['district'];*/
          //dump($coun);exit;
          if(IS_GET){
           $x = I('x_longitude');
           $y = I('y_latitude');
           $type = I('type');
           $user_data = I('user_data');
           $sn = I('sn');
          // print_r($sn.$type.$area_status);
           $activity_id = I('activity_id');
           $aaa['activity_id'] = $activity_id;
           //print_r($aaa);
           $area = D('area')->where($aaa)->select();
           //百度地图Ak
           $ak = 'VTRvaoF3l1LXS22MFGcPaAeeG1htsBPg';
           $ad = getAddress($x,$y,$ak);
           $data = json_decode($ad,true); 
           $coun['country'] = $data['result']['addressComponent']['country'];
           $coun['province'] = $data['result']['addressComponent']['province'];
           $city = $data['result']['addressComponent']['city'];
           $coun['district'] = $data['result']['addressComponent']['district'];
           $coun['city'] = str_replace("市","",$city);; 
           //print_r($coun);exit;
           $ok = 0;
           foreach ($area as $key => $value) {
              if($value['area_name']==$coun['province']){
                $ok = 1;
              }
              if($value['area_name']==$coun['city']){
                $ok = 1;
              }
              if($value['area_name']==$coun['district']){
                $ok = 1;
              }
           }
           $a['ok']=$ok;
           //print_r($area);
           //print_r($a);exit;

            if($ok){
               //改变二维码状态 变成已扫码 未领取
                $ccc['status'] = 1;
                $sns['code_sn'] = $sn;
                D('code')->where($sns)->save($ccc);
              if($user_data==1){
                $this->redirect('wechat/user_data', array('sn'=>$sn));
              }else{
               switch ($type) {
                case '1':
                  $type='get_now';
                  $this->redirect('wechat/get_now', array('sn'=>$sn));
                  break;
                case '2':
                  $type='jiugong';
                  $this->redirect('wechat/jiugong', array('sn'=>$sn));
                  break;
                case '3':
                  $type='zhuanpan';
                  $this->redirect('wechat/zhuanpan', array('sn'=>$sn));
                  break;
                case '4':
                  $type='guagua';
                  $this->redirect('wechat/guagua', array('sn'=>$sn));
                  break;
                case '5':
                  $type='jindan';
                  $this->redirect('wechat/jindan', array('sn'=>$sn));
                  break;
               }
             }
 
            }else{

                $url = 'http://'.$_SERVER['HTTP_HOST']."/index.php/home/wechat/tishi".'?error_code=地理位置不满足活动要求';
                Header("Location: $url");exit;
                //$this->redirect('wechat/tishi', array('error_code' =>'地理位置不满足活动要求'));
                exit;
            }

          }
       $this->display();
      }

   //获取用户信息页面
      public function user_data(){
          $cc['code_sn'] = $_GET['sn'];
          $code = D('code')->where($cc)->find();
          $code_num['id'] = $code['code_num_id'];
          $actcode = D('code_num')->where($code_num)->field('activity_id')->find();
         // print_r($actcode);exit;
          $data['activity_id'] = $actcode['activity_id'];
          $list = D('activity_input')->where($data)->select();
          $this->assign('list',$list);
          $this->assign('activity_id',$actcode['activity_id']);
          //商店名称
           $data2['id'] = $actcode['activity_id'];
           $rec = D('activity')->where($data2)->field('shop_id')->find();
           $aaa['id'] = $rec['shop_id'];
           $name = D('shop')->where($aaa)->field('name,logo')->find();
            $this->assign('shopdata',$name);
          //取出活动方式
              $acti['id'] = $actcode['activity_id'];
              $aa = D('activity')->where($acti)->field('type')->find();
              //print_r($aa);exit;
              switch ($aa['type']) {
                case '1':
                  $type='get_now';
                  break;
                case '2':
                  $type='jiugong';
                  break;
                case '3':
                  $type='zhuanpan';
                  break;
                case '4':
                  $type='guagua';
                  break;
                case '5':
                  $type='jindan';
                  break;
              }
             // print_r($type);exit;
          $this->assign('activity_type',$type);
              $this->assign('sn',$cc['code_sn']);
          $this->display();
       }

      

       //————————————————————————————————————————————保存会员信息
          public function add_userdata(){
           if(IS_POST){
           // dump($_POST);exit;
             $name = I('name');
             $input_name = I('input_name');
             $input_status = I('input_status');
             $input_type = I('input_type');
             for ($i=0; $i < count($name); $i++) { 
               if($input_status[$i]==1){//必填项
                 if(!$name[$i]){
                   return show(0,'请输入'.$input_name[$i]);
                 }
               }
               $save['activity_id'] = I('activity_id');
               $save['data_name'] = $input_name[$i];
               $save['data_value'] = $name[$i];
               $save['member_id'] = session('memberUser.id');
               $save['time'] = time();
               $ok = D('userdata')->add($save);
             }
             if($ok){
               return show(1,'保存成功');
           }else{
             return show(0,'保存失败');
           }

           }

          }


      //直接领取红包页面
        public function get_now(){
          $c['code_sn'] = I('sn');
          //print_r($c);exit;
           $this->assign('sn',$c['code_sn']);
          $code = D('code')->where($c)->find();
//print_r($code.'_code');
          $content['id'] = $code['activity_id'];
          $activity = D('activity')->where($content)->find();
         // print_r($activity['picture']);exit;
          $this->assign('activity',$activity);
          //奖励
          
          $pri['id'] = $code['activity_prize_id'];
          //print_r($pri);
          if($pri['id']!==0){
              $prize = D('activity_prize')->where($pri)->find();
              //print_r($activity);exit;
              $type = $prize['prize_type'];
              switch ($type) {
                case '1':  //现金红包
                  $money = $prize['prize'];
                  break;
                case '2':  //随机红包
                  $bao['prize_id'] = $prize['id'];
                  $bao['status'] = 0;
                  $sui = D('suijibag')->where($bao)->field('money')->find();
                  $money = $sui['money'];
                  break;
                case '3':  //兑换券
                    $dui['id'] = $prize['prize'];
                    $dui_ticket = D('ticket')->where($dui)->find();
                    $money = $dui_ticket;
                  break;
                default:
                  $you['id'] = $prize['prize'];
                  $you_ticket = D('ticket')->where($you)->find();
                  $money = $you_ticket;
                  break;
              }

          }else{
            $money = '谢谢参与';
            $type = 0;
          }
          //print_r($type.'_type');
          $this->assign('money',$money);
          $this->assign('type',$type);
          $this->display();
       }
          
       //九宫格
        public function jiugong(){
           $c['code_sn'] = I('sn');
          
           $this->assign('sn',$c['code_sn']);
           $code = D('code')->where($c)->find();
           if($code['status']>1){
                echo "<script>alert('此二维码已失效！');</script>";exit;
              }
           $code_num['id'] = $code['code_num_id'];
           $actcode = D('code_num')->where($code_num)->field('activity_id')->find();
           $content['id'] = $actcode['activity_id'];
              $activity = D('activity')->where($content)->find();
             // print_r($activity['picture']);exit;
              $this->assign('activity',$activity);
              //九宫格所有的奖励展示
              $priz['activity_id'] = $activity['id'];
              $prize_list = D('activity_prize')->where($priz)->select();
              $box1 = $prize_list[0];
              $this->assign('box1',$box1);
              $box2 = $prize_list[1];
              $this->assign('box2',$box2);
              $box3 = $prize_list[2];
              $this->assign('box3',$box3);
              $box4 = $prize_list[3];
              $this->assign('box4',$box4);
              $box5 = $prize_list[4];
              $this->assign('box5',$box5);
              $box6 = $prize_list[5];
              $this->assign('box6',$box6);
              $box7 = $prize_list[6];
              $this->assign('box7',$box7);
              //dump($prize_list);exit;
              //奖励
              $pri['id'] = $code['activity_prize_id'];

        if($pri['id']!==0){
              $prize = D('activity_prize')->where($pri)->find();
              $type = $prize['prize_type'];
              //应得奖励  使九宫格转到该奖励 那一格
              $de_prize = '';
              foreach ($prize_list as $key => $value) {
                if($value['id'] == $prize['id']){
                  $de_prize = $key+1;
                }
              }
              if(!$de_prize){//7代表谢谢参与
               $de_prize = 8;
              }
              
              
             // print_r($type);exit;
              switch ($type) {
                case '1':  //现金红包
                  $money = $prize['prize'];
                  break;
                case '2':  //随机红包
                  $bao['prize_id'] = $prize['id'];
                  $bao['status'] = 0;
                  $sui = D('suijibag')->where($bao)->find();
                  $money = $sui['money'];
                  break;
                case '3':  //兑换券
                    $dui['id'] = $prize['prize'];
                    $dui_ticket = D('ticket')->where($dui)->find();
                    $money = $dui_ticket;
                  break;
                default:
                  $you['id'] = $prize['prize'];
                    $you_ticket = D('ticket')->where($you)->find();
                  $money = $you_ticket;
                  break;
              }
              //print_r($money);exit;
              $this->assign('prize_id',$prize['id']);

          }else{
            $money = '谢谢参与';
            $type = 0;
            $de_prize = 8;
          }
          $xxx = json_encode($money);
          file_put_contents ('de_prize.txt' ,$de_prize);
          file_put_contents ('xxx.txt' ,$xxx);
              $this->assign('de_prize',$de_prize);
              $this->assign('money',$money);
              $this->assign('type',$type);
          $this->display();
       }
       //大转盘
        public function zhuanpan(){
            $c['code_sn'] = I('sn');
          
           $this->assign('sn',$c['code_sn']);
           $code = D('code')->where($c)->find();
           if($code['status']>1){
                echo "<script>alert('此二维码已失效！');</script>";exit;
              }
           $code_num['id'] = $code['code_num_id'];
           $actcode = D('code_num')->where($code_num)->field('activity_id')->find();
           $content['id'] = $actcode['activity_id'];
              $activity = D('activity')->where($content)->find();
             // print_r($activity['picture']);exit;
              $this->assign('activity',$activity);
              //九宫格所有的奖励展示
              $priz['activity_id'] = $activity['id'];
              $prize_list = D('activity_prize')->where($priz)->select();
              $box1 = $prize_list[0];
              $this->assign('box1',$box1);
              $box2 = $prize_list[1];
              $this->assign('box2',$box2);
              $box3 = $prize_list[2];
              $this->assign('box3',$box3);
              $box4 = $prize_list[3];
              $this->assign('box4',$box4);
              $box5 = $prize_list[4];
              $this->assign('box5',$box5);
            /*  $box6 = $prize_list[5];
              $this->assign('box6',$box6);
              $box7 = $prize_list[6];
              $this->assign('box7',$box7);*/
              //dump($prize_list);exit;
              //奖励
              $pri['id'] = $code['activity_prize_id'];

         if($pri['id']!==0){

              $prize = D('activity_prize')->where($pri)->find();
              $type = $prize['prize_type'];
              //应得奖励  使九宫格转到该奖励 那一格
              $de_prize = '';
              foreach ($prize_list as $key => $value) {
                if($value['id'] == $prize['id']){
                  $de_prize = $key+1;
                }
              }
              
              if(!$de_prize){//7代表谢谢参与
               $de_prize = 6;
              }
             // print_r($type);exit;
              switch ($type) {
                case '1':  //现金红包
                  $money = $prize['prize'];
                  break;
                case '2':  //随机红包
                  $bao['prize_id'] = $prize['id'];
                  $bao['status'] = 0;
                  $sui = D('suijibag')->where($bao)->find();
                  $money = $sui['money'];
                  break;
                case '3':  //兑换券
                    $dui['id'] = $prize['prize'];
                    $dui_ticket = D('ticket')->where($dui)->find();
                    $money = $dui_ticket;
                  break;
                default:
                  $you['id'] = $prize['prize'];
                    $you_ticket = D('ticket')->where($you)->find();
                  $money = $you_ticket;
                  break;
              }
              //print_r($money);exit;
              $this->assign('prize_id',$prize['id']);
           }else{
            $money = '谢谢参与';
            $type = 0;
            $de_prize = 6;
          }

              $this->assign('de_prize',$de_prize);
              $this->assign('money',$money);
              $this->assign('type',$type);
          $this->display();
       }
       //刮刮乐
        public function guagua(){
              $c['code_sn'] = I('sn');
         // print_r($c);exit;
              $this->assign('sn',$c['code_sn']);
              $code = D('code')->where($c)->find();
              if($code['status']>1){
                echo "<script>alert('此二维码已失效！');</script>";exit;
              }
              $content['id'] = $code['activity_id'];
              $activity = D('activity')->where($content)->find();
             // print_r($activity['picture']);exit;
              $this->assign('activity',$activity);
              //九宫格所有的奖励展示
              $priz['activity_id'] = $activity['id'];
              $prize_list = D('activity_prize')->where($priz)->select();
              $this->assign('prize_list',$prize_list);


              //奖励
              $pri['id'] = $code['activity_prize_id'];

          if($pri['id']!==0){

              $prize = D('activity_prize')->where($pri)->find();
              //print_r($activity);exit;
              $type = $prize['prize_type'];
             // print_r($type);exit;
              switch ($type) {
                case '1':  //现金红包
                  $money = $prize['prize'];
                  break;
                case '2':  //随机红包
                  $bao['prize_id'] = $prize['id'];
                  $bao['status'] = 0;
                  $sui = D('suijibag')->where($bao)->field('money')->find();
                  $money = $sui['money'];
                  break;
                case '3':  //兑换券
                    $dui['id'] = $prize['prize'];
                    $dui_ticket = D('ticket')->where($dui)->find();
                  $money = $dui_ticket;
                  break;
                default:
                  $you['id'] = $prize['prize'];
                    $you_ticket = D('ticket')->where($you)->find();
                  $money = $you_ticket;
                  break;
              }
           
           }else{
            $money = '谢谢参与';
            $type = 0;
          }
 
              //print_r($money);exit;
              $this->assign('prize_id',$prize['id']);
              $this->assign('money',$money);
              $this->assign('type',$type);
          $this->display();
       }
       //砸金蛋
        public function jindan(){
               $c['code_sn'] = I('sn');
         // print_r($c);exit;
              $this->assign('sn',$c['code_sn']);
              $code = D('code')->where($c)->find();
              if($code['status']>1){
                echo "<script>alert('此二维码已失效！');</script>";exit;
              }
              $content['id'] = $code['activity_id'];
              $activity = D('activity')->where($content)->find();
             // print_r($activity['picture']);exit;
              $this->assign('activity',$activity);
              //九宫格所有的奖励展示
              $priz['activity_id'] = $activity['id'];
              $prize_list = D('activity_prize')->where($priz)->select();
              $this->assign('prize_list',$prize_list);

              //奖励
              $pri['id'] = $code['activity_prize_id'];
           if($pri['id']!==0){

              $prize = D('activity_prize')->where($pri)->find();
              //print_r($activity);exit;
              $type = $prize['prize_type'];
             // print_r($type);exit;
              switch ($type) {
                case '1':  //现金红包
                  $money = $prize['prize'];
                  break;
                case '2':  //随机红包
                  $bao['prize_id'] = $prize['id'];
                  $bao['status'] = 0;
                  $sui = D('suijibag')->where($bao)->field('money')->find();
                  $money = $sui['money'];
                  break;
                case '3':  //兑换券
                    $dui['id'] = $prize['prize'];
                    $dui_ticket = D('ticket')->where($dui)->find();
                  $money = $dui_ticket;
                  break;
                default:
                  $you['id'] = $prize['prize'];
                    $you_ticket = D('ticket')->where($you)->find();
                  $money = $you_ticket;
                  break;
              }

           }else{
              $money = '谢谢参与';
              $type = 0;
            }

              //print_r($money);exit;
              $this->assign('prize_id',$prize['id']);
              $this->assign('money',$money);
              $this->assign('type',$type);
          $this->display();
       }

          //share分享出去页面
        public function share(){
          $config = C('WEIXINPAY_CONFIG');
          Vendor('Wx_share.jssdk');
          $appid = $config['APPID'];
          $appsecret = $config['APPSECRET'];
          $jssdk = new \JSSDK($appid,$appsecret);
          $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
          $signPackage = $jssdk ->GetSignPackage($url);
          $this->assign('signPackage',$signPackage);
          //取出分享内容
          $sn['code_sn'] = I('sn');
          $code = D('code')->where($sn)->field('activity_id')->find();
          $share['activity_id'] = $code['activity_id'];
          $sharedata = D('share_data')->where($share)->find();
          $this->assign('sharedata',$sharedata);
          //商户资料
          
          $data['id'] = $code['activity_id'];
          $active = D('activity')->where($data)->field('shop_id')->find();
          $shop['id'] = $active['shop_id'];
          $shopdata = D('shop')->where($shop)->field('name,logo')->find();
          $this->assign('shopdata',$shopdata);
          $this->logResult('/code_sn.log','code_sn:'.$sn['code_sn'].'会员id'.session('memberUser.id'));
          $this->assign('sn',$sn['code_sn']);
          $this->display();
       }
       
       public function share_jump(){
        $data['id'] = I('share_id');
        $url = D('share_data')->where($data)->field('share_link')->find();
        $this->assign('share_link',$url['share_link']);
        $this->display();
      }
     
   


          public function get_money(){
            if(IS_POST){
             $data['code_sn'] = I('sn');
             $code = D('code')->where($data)->find();
              if($code['status']>1){
                return show(0,'您已领取奖励不能重复领取');
             }
             if($code['activity_prize_id']==0){
               return show(1,'谢谢参与');
             }
             $pri['id'] = $code['activity_prize_id'];
             $prize = D('activity_prize')->where($pri)->find();
             switch ($prize['prize_type']) {
              case '1': //现金红包,$type=1 直接领取
                 $res = $this->rebagpay($pri['id'],$code['id'],$type=1);
                 $result = json_decode($res,true);
                 return show($result['status'],$result['result']);
                break;
              case '2': //随机红包
                $res = $this->rebagpay($pri['id'],$code['id'],$type=1);
                $result = json_decode($res,true);
                return show($result['status'],$result['result']);
                break;
              case '3'://兑奖券
                   $tck['member_id'] = session('memberUser.id');
                   $tck['ticket_type'] = 1;//兑换券
                   $tck['ticket_id'] = $prize['prize'];
                   $tck['activity_id'] = $prize['activity_id'];
                   $tck['time'] = time();
                   $ok = D('member_ticket')->add($tck);
                   if($ok){
                       $save['member_id'] = session('memberUser.id');
                       $save['prize_id'] = $code['activity_prize_id'];
                       $save['code_id'] = $code['id'];
                       $save['activity_id'] = $prize['activity_id'];
                       $save['prize_type'] = 3;
                       $save['prize'] = $prize['prize'];
                       $save['time'] = time();
                       $ok2 = D('get_record')->add($save);
                         if($ok2){
                          $stt['status'] = 2;
                          $ok3 = D('code')->where($data)->save($stt);
                          $heh['hexiao_code'] = set_hexiao_code($ok);
                          $heh['hexiao_code_sn'] = set_code_sn(4,1);
                          D('member_ticket')->where(array('id'=>$ok))->save($heh);
                          //生成核销码
                         }
                   }
                       //发送通知
                       $ticket['id'] = $prize['prize'];
                       $tick = D('ticket')->where($ticket)->field('name')->find();
                       $act['id'] = $prize['activity_id'];
                       $actname = D('activity')->where($ticket)->field('act_name')->find();
                       $activity = $actname['act_name'];
                       $time = date('Y-m-d H:i:s',time());
                       $openid = $memb['wx_openid'];
                       $money = '兑换券：'.$tick['name'];
                       send_ticket($openid,$money,$activity,$time);
                  return show(1,'领取成功',$ok2);
                break;

              default://优惠券
                   $tck['member_id'] = session('memberUser.id');
                   $tck['ticket_type'] = 2;//优惠券
                   $tck['ticket_id'] = $prize['prize'];
                   $tck['activity_id'] = $prize['activity_id'];
                   $tck['time'] = time();
                   $ok = D('member_ticket')->add($tck);
                   if($ok){
                       $save['member_id'] = session('memberUser.id');
                       $save['prize_id'] = $code['activity_prize_id'];
                       $save['code_id'] = $code['id'];
                       $save['activity_id'] = $prize['activity_id'];
                       $save['prize_type'] = 4;
                       $save['prize'] = $prize['prize'];
                       $save['time'] = time();
                       $ok2 = D('get_record')->add($save);
                         if($ok2){
                          $ssa['status'] = 2;
                          $ok3 = D('code')->where($data)->save($ssa);
                          $heh['hexiao_code'] = set_hexiao_code($ok);
                          $heh['hexiao_code_sn'] = set_code_sn(4,1);
                          D('member_ticket')->where(array('id'=>$ok))->save($heh);
                         }
                   }
                        //发送通知
                       $ticket['id'] = $prize['prize'];
                       $tick = D('ticket')->where($ticket)->field('name')->find();
                       $act['id'] = $prize['activity_id'];
                       $actname = D('activity')->where($ticket)->field('act_name')->find();
                       $activity = $actname['act_name'];
                       $time = date('Y-m-d H:i:s',time());
                       $openid = $memb['wx_openid'];
                       $money = '优惠券：'.$tick['name'];
                       send_ticket($openid,$money,$activity,$time);
                    return show(1,'领取成功',$ok2);
                break;
                }

                if($ok2){
                     return show(1,'领取成功',$ok2);
                 }else{
                   return show(0,'领取失败');
                 } 

            }


           }



           //分享领取
         public function share_success(){

            if($_GET){
              $data['code_sn'] = I('sn');
            //  $this->logResult('/sn.log','接受到的sn：'.$data[code_sn].'会员id'.session('memberUser.id'));
            
            // $this->logResult('/share_success_sn.log','share_success_sn :'.$data['code_sn'].'会员id'.session('memberUser.id'));
             $code = D('code')->where($data)->find();
              if($code['status']>1){
                return show(0,'您已领取奖励不能重复领取');
             }
             $pri['id'] = $code['activity_prize_id'];
             $prize = D('activity_prize')->where($pri)->find();
            // $this->logResult('/rerr.log','奖励结果：'.json_encode($prize).'会员id'.session('memberUser.id'));
             $member['id'] = session('memberUser.id');
             $memb = D('member')->where($member)->field('wx_openid')->find();
             //file_put_contents('share_1.text', $prize);
             switch ($prize['prize_type']) {
              case '1': //现金红包 $type=2 分享领取
                 $res = $this->rebagpay($pri['id'],$code['id'],$type=2);
              //    $this->logResult('/re.log','红包发放结果：'.$res);
                 $result = json_decode($res,true);
                 return show($result['status'],$result['result']);
                break;
              case '2': //随机红包
                $res = $this->rebagpay($pri['id'],$code['id'],$type=2);

                $result = json_decode($res,true);
                return show($result['status'],$result['result']);
                break;
              case '3'://兑奖券
                   $tck['member_id'] = session('memberUser.id');
                   $tck['ticket_type'] = 1;//兑换券
                   $tck['ticket_id'] = $prize['prize'];
                   $tck['activity_id'] = $prize['activity_id'];
                   $tck['time'] = time();
                   $ok = D('member_ticket')->add($tck);
                   if($ok){
                       $save['member_id'] = session('memberUser.id');
                       $save['prize_id'] = $code['activity_prize_id'];
                       $save['code_id'] = $code['id'];
                       $save['activity_id'] = $prize['activity_id'];
                       $save['prize_type'] = 3;
                       $save['prize'] = $prize['prize'];
                       $save['share_status'] = 1;//已分享
                       $save['time'] = time();
                       $ok2 = D('get_record')->add($save);
                         if($ok2){
                          $mbm['status'] = 2;
                          $ok3 = D('code')->where($data)->save($mbm);
                          $heh['hexiao_code'] = set_hexiao_code($ok);
                          $heh['hexiao_code_sn'] = set_code_sn(4,1);
                          D('member_ticket')->where(array('id'=>$ok))->save($heh);
                          //生成核销码
                          
                         }
                   }
                   //发送通知
                 $ticket['id'] = $prize['prize'];
                 $tick = D('ticket')->where($ticket)->field('name')->find();
                 $act['id'] = $prize['activity_id'];
                 $actname = D('activity')->where($ticket)->field('act_name')->find();
                 $activity = $actname['act_name'];
                 $time = date('Y-m-d H:i:s',time());
                 $openid = $memb['wx_openid'];
                 $money = '兑换券：'.$tick['name'];
                 send_ticket($openid,$money,$activity,$time);
               // return show(1,'分享成功',$ok2);
                 $this->success('奖励领取成功',U("wechat/tishi?error_code='奖励领取成功'"));
                break;

              default://优惠券
                   $tck['member_id'] = session('memberUser.id');
                   $tck['ticket_type'] = 2;//优惠券
                   $tck['ticket_id'] = $prize['prize'];
                   $tck['activity_id'] = $prize['activity_id'];
                   $tck['time'] = time();
                   $ok = D('member_ticket')->add($tck);
                   if($ok){
                       $save['member_id'] = session('memberUser.id');
                       $save['prize_id'] = $code['activity_prize_id'];
                       $save['code_id'] = $code['id'];
                       $save['activity_id'] = $prize['activity_id'];
                       $save['prize_type'] = 4;
                       $save['prize'] = $prize['prize'];
                       $save['share_status'] = 1;//已分享
                       $save['time'] = time();
                       $ok2 = D('get_record')->add($save);
                         if($ok2){
                          $mbm['status'] = 2;
                          $ok3 = D('code')->where($data)->save($mbm);
                          //生成核销码
                          $heh['hexiao_code'] = set_hexiao_code($ok);
                          $heh['hexiao_code_sn'] = set_code_sn(4,1);
                          D('member_ticket')->where(array('id'=>$ok))->save($heh);
                         }
                   }
                   //发送通知
                   $ticket['id'] = $prize['prize'];
                   $tick = D('ticket')->where($ticket)->field('name')->find();
                   $act['id'] = $prize['activity_id'];
                   $actname = D('activity')->where($ticket)->field('act_name')->find();
                   $activity = $actname['act_name'];
                   $time = date('Y-m-d H:i:s',time());
                   $openid = $memb['wx_openid'];
                   $money = '优惠券：'.$tick['name'];
                 send_ticket($openid,$money,$activity,$time);
                  // return show(1,'分享成功',$ok2);
                  $this->success('奖励领取成功',U('wechat/tishi?error_code=奖励领取成功'));
                break;
                }


            }

          }

   //调用红包接口
          public function rebagpay($prize,$code,$type){
          header("Content-type:text/html;charset=utf-8");
          //业务逻辑
          
             $data_p['id'] = $prize;
             //file_put_contents('prize_id.text', json_encode($data_p));
             $prize_data = D('activity_prize')->where($data_p)->find();
             //file_put_contents('prize_data.text', json_encode($prize_data));
            // file_put_contents('share_2.text', $prize_data);
             //print_r($prize_data);exit;
             if($prize_data['prize_type']==1){//现金红包
               $money = $prize_data['prize'];
             }
             if($prize_data['prize_type']==2){
               $sui['prize_id'] = $prize;
               $sui['status'] = 0;
               $suiji = D('suijibag')->where($sui)->find();
               $money = $suiji['money'];
             }
            // print_r($money);exit;
             //金额
             $active['id'] = $prize_data['activity_id'];
             $act_n = D('activity')->where($active)->field('act_name,shop_id')->find();
             $shop_name = shop_name($act_n['shop_id']);
             $act_name = $act_n['act_name'];
             
             $memo['id'] = session('memberUser.id');
             $open = D('member')->where($memo)->field('id,wx_openid')->find();

            Vendor('Weixinpay.Redbagwxpay');
            //$money = 1; //最低1元，单位分
            $sender = "领程科技";
            $indents = rand(1000,9999).$memo['id'].time();
            //$money2 = $money;
            $openid = $open['wx_openid'];
            $shop_name2 = $shop_name;
            $activity_name = $act_name;
            $data = array();
            $data['wxappid'] = 'wx58b98e1625d1af4b';  //appid
            $data['mch_id'] = '1518635501';  //商户id
            $data['mch_billno'] = $indents;  //商户订单号
            $data['client_ip'] = $_SERVER['REMOTE_ADDR']; //Ip地址
            $data['re_openid'] = $openid;  //接收红包openid
            $data['total_amount'] = floatval($money)*100;   //付款金额，单位分
            $data['total_num'] = 1;  //红包发放总人数
            $data['send_name'] = $shop_name2; //红包发送者名称
            $data['wishing'] = '恭喜发财';  //红包祝福语
            $data['act_name'] = $activity_name;   //活动name
            $data['remark'] = '恭喜发财';  //备注信息 必填
            $data['scene_id'] = 'PRODUCT_2'; //场景
//file_put_contents('act_name2.text',$data['act_name']);
//file_put_contents('share_3.text', $data);
            //dump($data);exit;
            $url = "https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack";

            $wxpay = new \wxPay();
            /*$res = $wxpay->toXml($data);
            print_r($res);exit;*/
            $res = $wxpay->pay($url, $data);
            $return_arr = $wxpay->xmlToArray($res);
           // file_put_contents('hongbao_result_code_fen_zhi.text', $return_arr);
            ///print_r($return_arr);exit;
            if($return_arr['result_code']=='SUCCESS'){
               
                 $save['member_id'] = session('memberUser.id');
                 $save['prize_id'] = $prize;
                 $save['code_id'] = $code;
                 $save['activity_id'] = $prize_data['activity_id'];
                 $save['prize_type'] = $prize_data['prize_type'];
                 $save['prize'] = $money;
                 $save['indents'] = $indents;
                 if($type==2){
                  $save['share_status'] = 1;//已分享
                 }
                 $save['time'] = time();
                 $ok3 = D('get_record')->add($save);
               if($ok3){
                 if($prize_data['prize_type']==2){//随机红包
                   //改变随机金额 的状态
                  $sj['id'] = $suiji['id'];
                  $ok2 = D('suijibag')->where($sj)->save(array('status'=>1));
                   if(!$ok2){
                     $return['status'] = 0;
                     $return['result'] = '随机金额的状态保存出错';
                     $this->error('随机金额的状态保存出错');
                     echo json_encode($return);exit;
                   }
                 }
                 $data_co['id'] = $code;
                 $ssa['status'] = 2;
                 $ok3 = D('code')->where($data_co)->save($ssa);
                 //发送通知
                 $time = date('Y-m-d H:i:s',time());
                 $content = '参加 <'.$shop_name2.'> 的“'.$activity_name.'”活动，获得活动奖励！';
                 send_redbag($openid,$money,$time,$content,$indents);

                 $return['status'] = 1;
                 $return['result'] = 'success';
                 $this->success('奖励领取成功',U('wechat/tishi?error_code=奖励领取成功'));
                // echo json_encode($return);exit;
               }else{
                 $return['status'] = 0;
                 $return['result'] = '纪录保存出错';
                 $this->error('纪录保存出错');
                 //echo json_encode($return);exit;
               }
          }else{

           $this->logResult('/redbag_error.log','会员：'.$openid.' 活动：'.$activity_name.' 红包发放结果：'.$res);
           $this->error($return_arr['return_msg']);
          }
          $this->logResult('/redbag.log','会员：'.$openid.' 活动：'.$activity_name.' 红包发放结果：'.$res);
          if($return_arr['result_code']=='FAIL'){
             $return['status'] = -1;
             $return['result'] = $return_arr['return_msg'];
             $this->error($return_arr['return_msg']);
             echo json_encode($return);exit;
            
          }

     }
   //生成日志
     public function logResult($path,$data){
            file_put_contents('redbag_log'.$path, '['.date('Y-m-d : h:i:sa',time()).']'.$data."\r\n",FILE_APPEND);
        }

       public function guanzhu(){
          $sn['code_sn'] = I('sn');
          $code = D('code')->where($sn)->field('id,activity_id')->find();
          $this->assign('sharedata',$sharedata);
          //商户资料
          $data['id'] = $code['activity_id'];
          $active = D('activity')->where($data)->field('shop_id')->find();
          $shop['id'] = $active['shop_id'];
          $shopdata = D('shop')->where($shop)->field('id,name,logo')->find();
          $this->assign('shopdata',$shopdata);
          
          $this->assign('sn',$sn['code_sn']);
          $this->assign('code_id',$code['id']);
          $dat['code_id'] = $code['id'];
          $have = D('guanzhu_code_member')->where($dat)->find();
          if($have){
            D('guanzhu_code_member')->where($dat)->delete();
          }
          //用于关注领红包
            $save['member_id'] = session('memberUser.id');
            $save['code_id'] = $code['id'];
            D('guanzhu_code_member')->add($save);
          $this->display();

       }

       public function guanzhu_code_url(){
          $code_id = $_GET['id'];
          $shop_id = $_GET['shop_id'];
          if($code_id){
            $token = get_authorizer_access_token($shop_id);
            //print_r($token);exit;
            $url = guanzhu_erweima_url($code_id,$token); 
            ob_end_clean();
            $level=3;  
            $size=4;  
            Vendor('phpqrcode.phpqrcode');  
            $errorCorrectionLevel =intval($level) ;//容错级别  
            $matrixPointSize = intval($size);//生成图片大小  
            //生成二维码图片  
            $object = new \QRcode();  
            $object->png($url,false, $errorCorrectionLevel, $matrixPointSize, 2);
          }

       }


           public function tishi(){
            $err = I('error_code');
            $this->assign('error',$err);
            $sn['code_sn'] = I('sn');
            $code = D('code')->where($sn)->field('activity_id')->find();
            $data['id'] = $code['activity_id'];
            $active = D('activity')->where($data)->field('shop_id')->find();
            $shop['id'] = $active['shop_id'];
            $shopdata = D('shop')->where($shop)->field('name,logo')->find();
            $this->assign('shopdata',$shopdata);

            $this->display();
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

       //+++++++++++++++++++++++++++++++++++++核销设置
       
    Public function hexiao(){
            Vendor('Weixinpay.Weixinpay');
            $wxpay=new \Weixinpay();
            $baseUrl = urlencode('http://'.$_SERVER['HTTP_HOST']."/index.php/home/wechat/hexiao".'?'.$_SERVER['QUERY_STRING']);
           // print_r($baseUrl);exit;
            $res = $wxpay->GetOpenid($baseUrl);//获取到带有openid和accesstoken 得json字符串
            //print_r($openid);exit;
            $result = json_decode($res,true);
            $openid = $result['openid'];
            $token = $result['access_token'];
            $activityid = $_GET['activityid'];
            $user = D('member')->where(array('wx_openid'=>$openid))->find();
          if($user){
            $shop['shop_id'] = I('shop_id');
            $shop['hexiao_time'] = time();
            $su = D('member')->where(array('wx_openid'=>$openid))->save($shop);

          }else{
            $url2 = "https://api.weixin.qq.com/sns/userinfo?access_token=$token&openid=$openid&lang=zh_CN";
            $mem_json_data = $this->https_request($url2);
          //print_r($mem_json_data);exit;
            if(!$mem_json_data){
              $this->error('没有收到用户信息！');
            }
            $mem_data = json_decode($mem_json_data,true);

           // dump($mem_data);exit;
            if(!empty($mem_data)){
                $mem['wx_openid'] = $mem_data['openid'];
                $mem['wx_name'] = $mem_data['nickname'];//用户名
                $mem['sex'] = $mem_data['sex'];
                $mem['wx_pic'] = $mem_data['headimgurl'];//头像
                $mem['time'] = time();//头像
                $mem['hexiao_time'] = time();
                $mem['shop_id'] = I('shop_id');
                $mem['address'] = $mem_data['province'].'-'.$mem_data['city'];
                $su = D('member')->add($mem);
              }
           }//member  end
           if($su){
              echo "<script>alert('设置成功');</script>";
           }
         
        
      }
       //会员核销页面
        Public function hexiao_info(){
            Vendor('Weixinpay.Weixinpay');
            $wxpay=new \Weixinpay();
            $baseUrl = urlencode('http://'.$_SERVER['HTTP_HOST']."/index.php/home/wechat/hexiao_info".'?'.$_SERVER['QUERY_STRING']);
           // print_r($baseUrl);exit;
            $res = $wxpay->GetOpenid($baseUrl);//获取到带有openid和accesstoken 得json字符串
            //print_r($openid);exit;
            $result = json_decode($res,true);
            $openid = $result['openid'];
            $token = $result['access_token'];
            $user = D('member')->where(array('wx_openid'=>$openid))->find();
          if($user){
            $m_t['id'] = $_GET['hexiao_id'];
            $mem_tic = D('member_ticket')->where($m_t)->find();
            //print_r($mem_tic);exit;
            $this->assign('member_ticket',$mem_tic);
            $tic['id'] = $mem_tic['ticket_id'];
            $ticket = D('ticket')->where($tic)->find();
            $this->assign('ticket',$ticket);
            if(!$user['shop_id']||$user['shop_id']!==$ticket['shop_id']){
               echo "<script>alert('您没有权限进行这张奖券的核销');</script>";exit;
            }
            //门店
            $store['id'] = array('in',$ticket['store_id']); 
            $stores = D('store')->where($store)->select();
            $this->assign('stores',$stores);
            $this->assign('member',$user['id']);
           /* $shop['shop_id'] = I('shop_id');
            $shop['hexiao_time'] = time();
            $su = D('member')->where(array('wx_openid'=>$openid))->save($shop);*/
           
          }else{
             echo "<script>alert('您没有权限');</script>";
           }//member  end
        $this->display();
      }

      public function hexiao_save(){
        if(IS_POST){
         $m_t = I('m_t_id');
         $member = I('member');
         $id['id'] = $m_t;
         $data['hexiao_member'] = $member;
         $data['hexiao_status'] = 1;
         $data['hexiao_time'] = time();
         $ok = D('member_ticket')->where($id)->save($data);
          if($ok){
            return show(1,'核销成功');
           }else{
            return show(0,'核销失败');
           }
        }
      }

      public function guagua2(){
        $openid = 'onwdU54ZLMpDOsT7wssGzBqdynvE';
        $money = '20元兑换券';
        $activity = '测试消息提醒';
        $time = date('Y-m-d H:i:s',time());
        $content ='测试';
        $indents = '123456';
       //send_ticket($openid,$money,$activity,$time);
       send_redbag($openid,$money,$time,$content,$indents);

        $this->display();
      }

    /*public function ceshi(){
       $this->redirect('wechat/tishi', array('error_code' =>'地理位置不满足活动要求'));
    }*/
}