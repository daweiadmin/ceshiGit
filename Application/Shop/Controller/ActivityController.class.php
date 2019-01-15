<?php 
namespace Shop\Controller;
use Think\Controller;
class ActivityController extends CommenController {

	 public function index(){
   
     header("Content-type:text/html;charset=utf-8");
      $act_status = $_REQUEST['act_status'];
      $shenhe_status = $_REQUEST['shenhe_status'];
      $key = $_REQUEST['key'];
      if($act_status){
        $data['act_status']=$act_status;
      }
      if($shenhe_status){
        $data['shenhe_status']=$shenhe_status;
      }
      if($key){
         $data['act_name']=array('like','%'.$key.'%'); //模糊查询
      }
     
      $type = session('shopUser.type');
      if($type<3){
        $son['parentid'] = session('shopUser.id');
        $son_list = D('shop')->where($son)->field('id')->select();
        $str = '';
        foreach ($son_list as $key => $value) {
          $str.=$value['id'].',';
        }
        $str_id = $str.session('shopUser.id');
        $data['shop_id'] = array('in',$str_id);
      }else{
         $data['shop_id'] = session('shopUser.id');
      }
      //print_r($data);exit;
      $count = D('activity')->where($data)->count();
	    $page=$_REQUEST['p'] ? $_REQUEST['p'] :1;
	    $pageSize=20;  
	    $offset=($page-1)*$pageSize;  
	    $list=D('activity')->where($data)->limit($offset,$pageSize)->order('id desc')->select();
	    $datapage=new \Think\Page($count,$pageSize);  
	    $datapage->setConfig('header','<br/><br/>共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页');  
	    $datapage->setConfig('prev','上一页');
	    $datapage->setConfig('next','下一页');
	    $datapage->setConfig('theme','%UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %HEADER%');
	    //print_r($list);exit;
	    $pageRes=$datapage->show();
	    $this->assign('page',$pageRes);
	    $this->assign('list',$list);
      
      //未选择码段
      $code['activity_id'] = 0;
      $code['shop_id'] = session('shopUser.id');
      $code_list = D('code_num')->where($code)->select();
      $this->assign('code_list',$code_list);
      $this->assign('shop_type',session('shopUser.type'));
	 	$this->display();
	 }
   public function set_activity_code(){
    if(IS_POST){
        $activity_id = I('id');
        ob_end_clean();
        $link_url = 'http://redbag.lingcheng888.com/index.php/home/wechat/index?activity_id='.$activity_id;
        $level=3;  
        $size=4;  
        Vendor('phpqrcode.phpqrcode');  
        $errorCorrectionLevel =intval($level) ;//容错级别  
        $matrixPointSize = intval($size);//生成图片大小  
        //生成二维码图片  
        $object = new \QRcode();  
        $path = "Public/erweima/";
        $file = $path.'activity'.$activity_id.".png";
        //print_r($url);exit;
        $object->png($link_url, $file, $errorCorrectionLevel, $matrixPointSize, 2); 
        $path2 = '/Public/erweima/activity'.$activity_id.".png"; 
        
        $data['id'] = $activity_id;
        $save['activity_code'] = $path2;
        $ok = D('activity')->where($data)->save($save);
         if($ok){
           return show(1,'二维码已生成');
         }else{
           return show(0,'生成失败');
         }
        
       }
    }
  ///******************************************添加页面
	  public function add(){
	  	$typeid = I('activityId');
	  	if($typeid){
	  		  $this->assign('typeid',$typeid);
          $data['activity_id'] = 0;
	  	   	$data['shop_id'] = session('shopUser.id');
	        $code_list = D('code_num')->where($data)->order('pici desc')->select();
	        $this->assign('code_list',$code_list); 
	        if(IS_POST){
	          $data2['activityId'] = I('activityId');
	          $data2['code_num_id'] = I('code_num_id');
	          $in = implode(',',$data2['code_num_id']);
	         // print_r($in);exit;
	          $where['id'] = array('in',$in);
	          $code_xuan = D('code_num')->where($where)->select();
	         // print_r($code_xuan);exit;
	          $this->assign('code_xuan',$code_xuan); 
	        }
	  	}else{
	  		$this->error('您还未选择活动方式');
	  	}
      $shop['shop_id'] = session('shopUser.id');
      $quan = D('wx_token')->where($shop)->field('authorizer_access_token')->find();
      if($quan['authorizer_access_token']){
       $auth=1;
      }else{
        $auth=-1;
        $config = C('WXKAI_CONFIG');
        $component_appid = $config['appId'];
        $pre_auth_code = get_pre_auth_code();
        $redirect_uri = 'http://redbag.lingcheng888.com/index.php/shop/weixin/auth_return_url';//回调路径
        $auth_type = 1;//1公众号 2小程序 3两个+
        $url = "https://mp.weixin.qq.com/cgi-bin/componentloginpage?component_appid=$component_appid&pre_auth_code=$pre_auth_code&redirect_uri=$redirect_uri&auth_type=$auth_type";
        $this->assign('jump_url',$url);
      }
      $this->assign('auth',$auth);
	 	  $this->display();
	 }


 //添加活动信息到数据表
    public function add_activity(){
      if(IS_POST){
        // dump($_POST);exit;
         $data['act_name'] = I('act_name');
         $data['title'] = I('title');
         $data['picture'] = I('picture');
         $data['describe'] = I('describe');
         $data['rule'] = I('rule');
         $data['instruction'] = I('instruction');
         $data['cishu_status'] = I('cishu');//次数限制
         $data['cishu1'] = I('cishu1');
         $data['cishu2'] = I('cishu2');
         $data['cishu3'] = I('cishu3');
         $data['condition'] = I('condition');
         $data['user_data'] = I('user_data');
         $data['area_status'] = I('area_status');
         $data['type'] = I('activity_type');
         $data['time'] = time();
         $data['shop_id'] = session('shopUser.id');
        // $data['type'] = I('activity_type');
         $code_id = I('choose_code_id');
         $money_type = I('money_type');
         $money = I('money');
         $amount = I('amount');
         $input_type = I('input_type');
         $input_name = I('input_name');
         $input_status = I('input_status');
         $area_status = I('area_status');
         $area = I('area');
        
         //表单验证
         if(!$data['act_name']){
               return show(0,'请输入活动名称');
         }
        $lenth = strlen($data['act_name']);
         if($lenth>32){
            return show(0,'输入的活动名称太长，请少于10个汉字（包括标点符号）');
         }
         if(!$data['title']){
               return show(0,'请输入活动标题');
         }
         if(!$code_id){
               return show(0,'请选择码段');
         }
         if(!$money_type){
               return show(0,'请添加奖励');
         }
         if($data['condition']==2){
           $share_link = I('share_link');
           $share_title = I('share_title');
           $share_picture = I('share_picture');
           if(!$share_link){ return show(0,'请填写分享链接'); }
           if(!$share_title){ return show(0,'请填写分享标题'); }
           if(!$share_picture){ return show(0,'请选择分享图片'); }
         }
         if($data['condition']==3){
           $quan['shop_id'] = session('shopUser.id');
           $ha = D('wx_token')->where($quan)->field('authorizer_access_token')->find();
           if(!$ha['authorizer_access_token']){
             return show(0,'您的还未授权');
             
           }
         }
         $moneys = 0;
         for ($i=0; $i < count($money); $i++) { 
            if($money_type[$i]==1){
              $money1+=$money[$i]*$amount[$i];
            }
            if($money_type[$i]==2){
             $money2+=$money[$i];
            }
            if(!$money[$i]){
              return show(0,'奖励不能为空');
            }
            if($money[$i]<0.3){
              return show(0,'最小奖励金额不能小于0.3元');
            }

            $amount_total+=$amount[$i];
          }

          //奖励数量 大于 二维码数量时
           $num_id = implode(',',$code_id);
           $coo['code_num_id'] = array('in',$num_id);
           $code_count = D('code')->where($coo)->count();
           if($amount_total>$code_count){//奖励数量 大于 二维码数量时
            return show(0,'奖励数量不能大于总码量哦');
           }


           //判断账户金额 够不够
         $moneys = $money1+$money2;
         // print_r($moneys);exit;
         $sho['id'] = session('shopUser.id');
         $shop = D('shop')->where($sho)->field('money')->find();
         if($moneys>$shop['money']){
          return show(0,'您的账户余额不足，请尽快充值');
         }
         if($data['user_data']==1){
            for ($i=0; $i < count($input_name); $i++) { 
            if($input_name[$i]==''){
              return show(0,'用户信息表单名称不能为空');
            }
           }
         }

         if($data['area_status']==1){
           if(!$area){
             return show(0,'请选择活动区域');
           }
         }
 
         //保存数据
         $ok = D('activity')->add($data);

         //保存码段
         if($ok){
            $in = implode(',',$code_id);
            $code_save['id'] = array('in',$in); 
            $sss['activity_id'] = $ok;
            D('code_num')->where($code_save)->save($sss);
            //把所有二维码code都带上activity_id
            $actic['activity_id'] = $ok;
            $dada['code_num_id'] = $code_save['id'];
            D('code')->where($dada)->save($actic);
         }
          

          //保存奖励
          if($ok){
             for ($i=0; $i < count($money); $i++) { 
                $mmm['prize_type'] = $money_type[$i];
                $mmm['prize'] = $money[$i];
                $mmm['prize_amount'] = $amount[$i];
                $mmm['activity_id'] = $ok;
                $ok1 = D('activity_prize')->add($mmm);
                if($ok1){
                   if($mmm['prize_type']==2){//随机红包
                     $mom = $money[$i]/$amount[$i];
                     $max = 10;
                     $min = $mom-($mom*0.1);
                     if($min<0.3){
                       $min = 0.3;//最小0.3
                     }
                     //生成随机红包
                     Vendor('Weixinpay.redbag');
                     $wxpay = new \Reward();
                     $res = $wxpay->splitReward($money[$i],$amount[$i],$max,$min);
                     foreach ($res as $k => $v) {
                       $sv['activity_id'] = $ok;
                       $sv['prize_id'] = $ok1;
                       $sv['money'] = $v/100;
                       D('suijibag')->add($sv);
                     }
                   }
                  //红包奖励一一对应
                 $where['activity_prize_id'] = 0;
                 $where['code_num_id'] = $code_save['id'];
                 D('code')->where($where)->limit($amount[$i])->save(array('activity_prize_id'=>$ok1));
                }
              } 

               //奖励属于资金流水  存进记录里面
                if($ok1){
                  $shop_save['money'] = $shop['money']-$moneys;
                  $ok_s = D('shop')->where($sho)->save($shop_save);
                  if($ok_s){
                     $fin_zong['userid'] = session('shopUser.id');
                     $fin_zong['roletype'] = 1;//商户
                     $fin_zong['moneytype'] = 2;//分配资金
                     $fin_zong['money'] = $moneys;//金额
                     $fin_zong['full'] =  $shop_save['money'];//账户剩余金额
                     $fin_zong['time'] = time();
                     $fin_zong['content'] = '活动id:'.$ok.',活动名称：'.$data['act_name'];
                     $ok2 = M('money_record')->add($fin_zong);
                  }
                }

           }

    /*    if($data['condition']==3){
          $data_qr_activity_id = $ok;
          $token = get_authorizer_access_token();
          $add_url['guanzhu_qr_code'] = guanzhu_erweima_url($data_qr_activity_id,$token);
          $ac_save['id'] = $ok;
          D('activity')->where($ac_save)->save($add_url);
         }*/
          

           //保存分享
         if($data['condition']==2){
           $sha['share_link'] = I('share_link');
           $sha['share_title'] = I('share_title');
           $sha['share_picture'] = I('share_picture');
           $sha['activity_id'] = $ok;
           D('share_data')->add($sha);
          }
           //用户信息表单保存
           if($ok){
             for ($i=0; $i < count($input_type); $i++) { 
                $input['input_type'] = $input_type[$i];
                $input['input_name'] = $input_name[$i];
                $input['input_status'] = $input_status[$i];
                $input['activity_id'] = $ok;
                $ok4 = D('activity_input')->add($input);
              }
           }

           if($area_status==1){
            $arr = explode('-', $area);
            foreach ($arr as $key => $value) {
              $are['area_name'] = $value;
              $are['activity_id'] = $ok;
              $ok5 = D('area')->add($are);
            }

           }
           
           if($ok4){
               return show(1,'保存成功');
           }else{
             return show(0,'保存失败');
           }
         }


      }
    
 
  public function ce(){
    Vendor('Weixinpay.redbag');
    $wxpay = new \Reward();
    $res = $wxpay->splitReward(100,200,0.2,0.1);
    print_r($res);exit;
  }








   //************************************************修改
   public function edit_activity(){
     $activity_id['id'] = I('activity_id');
     if($activity_id){
      $find = D('activity')->where($activity_id)->find();
      //dump($find);exit;
      $this->assign('find',$find); 
      //已分配的码段列表
      $sel['activity_id'] = $find['id'];
      $code_num = D('code_num')->where($sel)->select();
      $this->assign('code_num',$code_num); 
      //未分配的码段列表
      $data['activity_id'] = 0;
      $data['shop_id'] = session('shopUser.id');
      $code_list = D('code_num')->where($data)->order('pici desc')->select();
      $this->assign('code_list',$code_list); 
      //奖励列表
      $prize['activity_id'] = $activity_id['id'];
      $prize_list = D('activity_prize')->where($prize)->select();//print_r($prize_list);exit;
      $this->assign('prize_list',$prize_list); 
      //兑换券
       $dui['type'] = 1;
       $dui['shop_id'] = session('shopUser.id'); 
       $dui_list = D('ticket')->where($dui)->select();
       $this->assign('dui_list',$dui_list); 
       //优惠券
       $you['type'] = 2;
       $you['shop_id'] = session('shopUser.id'); 
       $you_list = D('ticket')->where($you)->select();
       $this->assign('you_list',$you_list);
       //用户信息表单
       if($find['user_data']==1){
        $input['activity_id'] = $find['id'];
        $input_list = D('activity_input')->where($input)->select();
        //print_r($input_list);exit;
        $this->assign('input_list',$input_list);
       }
       //地区限制
       if($find['area_status']==1){
        $are['activity_id'] = $find['id'];
        $area_list = D('area')->where($are)->select();
        foreach ($area_list as $key => $value) {
          $area .= $value['area_name'].'-';
        }
        $area_str = rtrim($area,'-');
        $this->assign('area_list',$area_str);
       }

       //分享
        if($find['condition']==2){
        $share['activity_id'] = $find['id'];
        $sha = D('share_data')->where($share)->find();

        $this->assign('share',$sha);
       }
       
     }else{
      $this->error('请选择修改项');
     }
//dump($find);exit;
      $shop['shop_id'] = session('shopUser.id');
      $quan = D('wx_token')->where($shop)->field('authorizer_access_token')->find();
      if($quan['authorizer_access_token']){
       $auth=1;
      }else{
        $auth=-1;
        $config = C('WXKAI_CONFIG');
        $component_appid = $config['appId'];
        $pre_auth_code = get_pre_auth_code();
        $redirect_uri = 'http://redbag.lingcheng888.com/index.php/shop/weixin/auth_return_url';//回调路径
        $auth_type = 1;//1公众号 2小程序 3两个+
        $url = "https://mp.weixin.qq.com/cgi-bin/componentloginpage?component_appid=$component_appid&pre_auth_code=$pre_auth_code&redirect_uri=$redirect_uri&auth_type=$auth_type";
        $this->assign('jump_url',$url);
      }
      $this->assign('auth',$auth);
    $this->display();
   }
  //+++++++++++取消活动的某个码段 仅限于草稿使用
   public function quxiao_num(){
    if(IS_POST){
     $data['id'] = I('code_num_id');
     $save['activity_id'] = 0;
     $ok = D('code_num')->where($data)->save($save);
     if($ok){
       return show(1,'取消成功');
     }else{
       return show(0,'取消失败');
     }
    }


   }

     //+++++++++++取消活动的某个奖励 仅限于草稿使用
   public function quxiao_pz(){
    if(IS_POST){
     $data['id'] = I('prize_id');
     $ok = D('activity_prize')->where($data)->delete();
     if($ok){
       return show(1,'取消成功');
     }else{
       return show(0,'取消失败');
     }
    }


   }

   //*******************************************************保存修改
    public function edit_save(){
           if(IS_POST){
         //dump($_POST);exit;
         $data['act_name'] = I('act_name');
         $data['title'] = I('title');
         $data['picture'] = I('picture');
         $data['describe'] = I('describe');
         $data['rule'] = I('rule');
         $data['instruction'] = I('instruction');
         $data['cishu_status'] = I('cishu');//次数限制
         $data['cishu1'] = I('cishu1');
         $data['cishu2'] = I('cishu2');
         $data['cishu3'] = I('cishu3');
         $data['condition'] = I('condition');
         $data['user_data'] = I('user_data');
         $data['area_status'] = I('area_status');
         $data['time'] = time();
         $data['shop_id'] = session('shopUser.id');
        // $data['type'] = I('activity_type');
         $code_id = I('choose_code_id');
         $money_type = I('money_type');
         $money = I('money');
         $amount = I('amount');
         $input_type = I('input_type');
         $input_name = I('input_name');
         $input_status = I('input_status');
         $area_status = I('area_status');
         $area = I('area');
         if($data['condition']==2){
           $share_link = I('share_link');
           $share_title = I('share_title');
           $share_picture = I('share_picture');
           if(!$share_link){ return show(0,'请填写分享链接'); }
           if(!$share_title){ return show(0,'请填写分享标题'); }
           if(!$share_picture){ return show(0,'请选择分享图片'); }
         }
         //表单验证
         if(!$data['act_name']){
               return show(0,'请输入活动名称');
         }
         //字符长度不能大于32个
         $lenth = strlen($data['act_name']);
         if($lenth>32){
            return show(0,'输入的活动名称太长，请少于10个汉字（包括标点符号）');
         }
         if(!$data['title']){
               return show(0,'请输入活动标题');
         }
         if(!$code_id){
               return show(0,'请选择码段');
         }
         if(!$money_type){
               return show(0,'请添加奖励');
         }



         if($data['user_data']==1){
            for ($i=0; $i < count($input_name); $i++) { 
            if($input_name[$i]==''){
              return show(0,'用户信息表单名称不能为空');
            }
           }
         }

         if($data['area_status']==1){
           if(!$area){
             return show(0,'请选择活动区域');
           }
         }
        if($data['condition']==3){
           $quan['shop_id'] = session('shopUser.id');
           $ha = D('wx_token')->where($quan)->field('authorizer_access_token')->find();
           if(!$ha['authorizer_access_token']){
             return show(0,'您的公众号还未授权给我们');
             
           }
         }
 
         $id['id'] = I('activity_id'); 
         $actt = D('activity')->where($id)->field('status')->find();
         //dump($actt);exit;
         if($actt['status']==-2){//如果是草稿 就要验证
                $moneys = 0;
                 for ($i=0; $i < count($money); $i++) { 
                    if($money_type[$i]==1){
                      $money1+=$money[$i]*$amount[$i];
                    }
                    if($money_type[$i]==2){
                     $money2+=$money[$i];
                    }
                    if(!$money[$i]){
                      return show(0,'奖励不能为空');
                    }
                    if($money[$i]<0.3){
                      return show(0,'最小奖励金额不能小于0.3元');
                    }
                    $amount_total+=$amount[$i];
                  }

                  //奖励数量 大于 二维码数量时
                   $num_id = implode(',',$code_id);
                   $coo['code_num_id'] = array('in',$num_id);
                   $code_count = D('code')->where($coo)->count();
                   if($amount_total>$code_count){//奖励数量 大于 二维码数量时
                    return show(0,'奖励数量不能大于总码量哦');
                   }


                   //判断账户金额 够不够
                 $moneys = $money1+$money2;
                 // print_r($moneys);exit;
                 $sho['id'] = session('shopUser.id');
                 $shop = D('shop')->where($sho)->field('money')->find();
                 if($moneys>$shop['money']){
                  return show(0,'您的账户余额不足，请尽快充值');
                 }
                 if($data['user_data']==1){
                    for ($i=0; $i < count($input_name); $i++) { 
                    if($input_name[$i]==''){
                      return show(0,'用户信息表单名称不能为空');
                    }
                   }
                 }
           $data['status'] = 0;
         }
         
         $ok = D('activity')->where($id)->save($data);


         if($actt['status']==-2){//如果是草稿 

            //保存奖励
          if($ok){
       
            if($ok){
              $in = implode(',',$code_id);
              $code_save['id'] = array('in',$in); 
              $sss['activity_id'] = $id['id'];
              D('code_num')->where($code_save)->save($sss);
              //把所有二维码code都带上activity_id
              $actic['activity_id'] = $id['id'];
              $dada['code_num_id'] = $code_save['id'];
              D('code')->where($dada)->save($actic);
           }

            $sas['activity_id'] = $id['id'];
            D('activity_prize')->where($sas)->delete();
             for ($i=0; $i < count($money); $i++) { 
                $mmm['prize_type'] = $money_type[$i];
                $mmm['prize'] = $money[$i];
                $mmm['prize_amount'] = $amount[$i];
                $mmm['activity_id'] = $id['id'];
                $ok1 = D('activity_prize')->add($mmm);
                if($ok1){
                   if($mmm['prize_type']==2){//随机红包
                     $mom = $money[$i]/$amount[$i];
                     $max = $mom*0.1+$mom;
                     $min = $mom-($mom*0.1);
                     if($min<0.3){
                       $min = 0.3;//最小0.3
                     }
                     //生成随机红包
                     Vendor('Weixinpay.redbag');
                     $wxpay = new \Reward();
                     $res = $wxpay->splitReward($money[$i],$amount[$i],$max,$min);
                     foreach ($res as $k => $v) {
                       $sv['activity_id'] = $id['id'];
                       $sv['prize_id'] = $ok1;
                       $sv['money'] = $v/100;
                       D('suijibag')->add($sv);
                     }
                   }
                  //红包奖励一一对应
                 $where['activity_prize_id'] = 0;
                 $where['code_num_id'] = $code_save['id'];
                 D('code')->where($where)->limit($amount[$i])->save(array('activity_prize_id'=>$ok1));
                }
              } 

               //奖励属于资金流水  存进记录里面
                if($ok1){
                  $shop_save['money'] = $shop['money']-$moneys;
                  $ok_s = D('shop')->where($sho)->save($shop_save);
                  if($ok_s){
                     $fin_zong['userid'] = session('shopUser.id');
                     $fin_zong['roletype'] = 1;//商户
                     $fin_zong['moneytype'] = 2;//分配资金
                     $fin_zong['money'] = $moneys;//金额
                     $fin_zong['full'] =  $shop_save['money'];//账户剩余金额
                     $fin_zong['time'] = time();
                     $fin_zong['content'] = '活动id:'.$ok.',活动名称：'.$data['act_name'];
                     $ok2 = M('money_record')->add($fin_zong);
                  }
                }

           }
         }//草稿

         //更新分享
          if($data['condition']==2){
           $whe['activity_id'] = I('activity_id');
           D('share_data')->where($whe)->delete();
           $sha['share_link'] = I('share_link');
           $sha['share_title'] = I('share_title');
           $sha['share_picture'] = I('share_picture');
           $sha['activity_id'] = $id['id'];
           D('share_data')->add($sha);
          }
           //用户信息表单保存
           if($ok){
             $del['activity_id'] = $id['id'];
             D('activity_input')->where($del)->delete();
             for ($i=0; $i < count($input_type); $i++) { 
                $input['input_type'] = $input_type[$i];
                $input['input_name'] = $input_name[$i];
                $input['input_status'] = $input_status[$i];
                $input['activity_id'] = $id['id'];
                $ok4 = D('activity_input')->add($input);
              }
           }


           if($area_status==1){
            D('area')->where($del)->delete();
            $arr = explode('-', $area);
            foreach ($arr as $key => $value) {
              $are['area_name'] = $value;
              $are['activity_id'] = $id['id'];
              $ok5 = D('area')->add($are);
            }

           }

           if($ok4){
               return show(1,'保存成功');
           }else{
             return show(0,'保存失败');
           }
         }


    }

  //保存草稿
   //添加活动信息到数据表
    public function add_caogao(){
      if(IS_POST){
        // dump($_POST);exit;
         $data['act_name'] = I('act_name');
         $data['title'] = I('title');
         $data['picture'] = I('picture');
         $data['describe'] = I('describe');
         $data['rule'] = I('rule');
         $data['instruction'] = I('instruction');
         $data['cishu_status'] = I('cishu');//次数限制
         $data['cishu1'] = I('cishu1');
         $data['cishu2'] = I('cishu2');
         $data['cishu3'] = I('cishu3');
         $data['condition'] = I('condition');
         $data['user_data'] = I('user_data');
         $data['area_status'] = I('area_status');
         $data['type'] = I('activity_type');
         $data['time'] = time();
         $data['shop_id'] = session('shopUser.id');
        // $data['type'] = I('activity_type');type
         $code_id = I('choose_code_id');
         $money_type = I('money_type');
         $money = I('money');
         $amount = I('amount');
         $input_type = I('input_type');
         $input_name = I('input_name');
         $input_status = I('input_status');
         $area_status = I('area_status');
         $area = I('area');
        
         //表单验证
         $id['id'] = I('activity_id'); 
         $data['status'] = -2;
         //保存数据
         $ok = D('activity')->add($data);



         //保存码段
         if($ok){
            $in = implode(',',$code_id);
            $code_save['id'] = array('in',$in); 
            $sss['activity_id'] = $ok;
            D('code_num')->where($code_save)->save($sss);
            //把所有二维码code都带上activity_id
            /*$actic['activity_id'] = $ok;
            $dada['code_num_id'] = $code_save['id'];
            D('code')->where($dada)->save($actic);*/
         }
          

          //保存奖励
          if($ok){
             for ($i=0; $i < count($money); $i++) { 
                $mmm['prize_type'] = $money_type[$i];
                $mmm['prize'] = $money[$i];
                $mmm['prize_amount'] = $amount[$i];
                $mmm['activity_id'] = $ok;
                $ok1 = D('activity_prize')->add($mmm);
             
              } 

           }

    /*    if($data['condition']==3){
          $data_qr_activity_id = $ok;
          $token = get_authorizer_access_token();
          $add_url['guanzhu_qr_code'] = guanzhu_erweima_url($data_qr_activity_id,$token);
          $ac_save['id'] = $ok;
          D('activity')->where($ac_save)->save($add_url);
         }*/
          

           //保存分享
         if($data['condition']==2){
           $sha['share_link'] = I('share_link');
           $sha['share_title'] = I('share_title');
           $sha['share_picture'] = I('share_picture');
           $sha['activity_id'] = $ok;
           D('share_data')->add($sha);
          }
           //用户信息表单保存
           if($ok){
             for ($i=0; $i < count($input_type); $i++) { 
                $input['input_type'] = $input_type[$i];
                $input['input_name'] = $input_name[$i];
                $input['input_status'] = $input_status[$i];
                $input['activity_id'] = $ok;
                $ok4 = D('activity_input')->add($input);
              }
           }

           if($area_status==1){
            $arr = explode('-', $area);
            foreach ($arr as $key => $value) {
              $are['area_name'] = $value;
              $are['activity_id'] = $ok;
              $ok5 = D('area')->add($are);
            }

           }
           
           if($ok4){
               return show(1,'草稿保存成功');
           }else{
             return show(0,'草稿保存失败');
           }
         }


      }
    




   ///修改状态
   public function act_status(){
     if(IS_POST){
      $data['id'] = I('id');
      $sta['act_status'] = I('status');
      $ok = D('activity')->where($data)->save($sta);
      if($ok){
           return show(1,'修改成功');
       }else{
         return show(0,'修改失败');
       }
     }


   }
  
 

   //**************************************************码段分配
	 public function return_code(){
       if(IS_POST){
          $code_num = I('code_num_id');
          if(!$code_num){
             return show(0,'您还未选择码段');
          }
          $in = implode(',',$code_num);
	         // print_r($in);exit;
          $where['id'] = array('in',$in);
          $code_xuan = D('code_num')->where($where)->select();
          foreach ($code_xuan as $key => $value) {
          	$data['code_num_id'] = $value['id'];
          	$code_data['num'] = D('code')->where($data)->count();
          	$code_data['maduan'] = $value['code_number'];
          	$code_data['id'] = $value['id'];
          	$data_list[] = $code_data;
          	$total += $code_data['num'];
          }
          //print_r($data_list);exit;
          return show(1,'',$data_list,$total);
       }

	 }


	     /*拆分码段*/

    public function chaifen(){
     if(IS_POST){
       $dataid['id'] = I('id');
       $code_num = D('code_num')->where($dataid)->find();
       $num = I('chai_num');
        if(!$num||$num<1){
          return show(0,'请输入合适的拆分数量');
       }
       $sel['code_num_id'] = I('id');
       $code = D('code')->where($sel)->order('id desc')->limit($num)->select();
       $n = count($code)-1;
       $data['code_number'] = $code[$n]['number'].'--'.$code[0]['number'];
       $data['pici'] = $code_num['pici'];
       $data['time'] = time();
       $data['shop_id'] = $code_num['shop_id'];
       $ok = D('code_num')->add($data);
       if($ok){
         foreach ($code as $key => $value) {
           $sav['code_num_id'] = $ok;
           $tiao['id'] = $value['id'];
           //print_r($ok);exit;
           $ok2 = D('code')->where($tiao)->save($sav);
         }
         $sel2['code_num_id'] = I('id');
         $yuan_code = D('code')->where($sel2)->order('id desc')->select();
         $b = count($yuan_code)-1;
         $data2['code_number'] = $yuan_code[$b]['number'].'--'.$yuan_code[0]['number'];
         D('code_num')->where($dataid)->save($data2);
         $new_data['id'] = $ok;
         $new = D('code_num')->where($new_data)->find();
         $coun['code_num_id'] = $ok;
         $new['count'] = D('code')->where($coun)->count();
         
         $yuan['code_num_id'] = $dataid['id'];
         $new['yuan_count'] = D('code')->where($yuan)->count();
         if($ok2){
            return show(1,'',$new);
          }else{
            return show(0,'拆分失败');
          }
       }

     } 


    }

  

  

    


     public function choose_quan(){
       if(IS_POST){
          $data['type'] = I('type');//1兑换券 2优惠券
          $data['shop_id'] = session('shopUser.id');
          $data['status'] == 0;
          $list = D('ticket')->where($data)->field('id,name')->select();
          return show(1,'',$list);

       }

     }
       
       //上传图片
       public function upload(){
        //print_r($_FILES);exit;
         header("content-type:text/html;charset=gb2312");
        if($_FILES['file']['tmp_name'] != ''){
          //print_r($_FILES['file']['tmp_name']);exit;
             $upload = new \Think\Upload();// 实例化上传类
             $upload->maxSize   =     9437184 ;// 设置附件上传大小6m

             $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
             $upload->rootPath  =   './'  ; // 设置附件上传根目录
             $upload->savePath  =  '/Public/Uploads/';
             // 上传单个文件 
                $info   =   $upload->uploadOne($_FILES['file']);
                if(!$info) {// 上传错误提示错误信息
                    return show(0,$upload->getError());
                }else{// 上传成功 获取上传文件信息
                   $data = $info['savepath'].$info['savename'];
                   echo $data;exit;
                }           
            }
      }

 public function ajaximg(){
    // 实例化上传类
    $upload = new \Think\Upload();
    // 设置附件上传大小
    $upload -> maxSize = 3145728;
    // 设置附件上传类型
    $upload -> exts = array('jpg', 'gif', 'png', 'jpeg');
    // 设置附件上传根目录
    $upload -> rootPath = './Public/Uploads/';
    // 上传单个文件
    $info = $upload -> uploadOne($_FILES['userpic']);
    if (!$info) {// 上传错误提示错误信息

      return array('r' => 'e', 't' => $upload -> getError());
    } else {// 上传成功 获取上传文件信息
      // $userpic = 'http://' . $_SERVER['HTTP_HOST'] . '/Public/Uploads/' . $info['savepath'] . $info['savename'];
      $userpic = '/Public/Uploads/' . $info['savepath'] . $info['savename'];
      //$this -> ajaxReturn(array('r' => '8', 't' => $userpic));
      return $userpic;
    }
    
}
  //单图上传
  public function ajax_img(){
    $img_url = ajaximg();           
    $this -> ajaxReturn(array('r' => '8', 't' => $img_url));                            
  }




  public function add_code_prize(){
     $activity_id['id'] = I('activity_id');
     if($activity_id){
      $find = D('activity')->where($activity_id)->find();
      $this->assign('find',$find); 
      //已分配的码段列表
      $sel['activity_id'] = $find['id'];
      $code_num = D('code_num')->where($sel)->select();
      $this->assign('code_num',$code_num); 
      //未分配的码段列表
      $data['activity_id'] = 0;
      $data['shop_id'] = session('shopUser.id');
      $code_list = D('code_num')->where($data)->order('pici desc')->select();
      $this->assign('code_list',$code_list); 
      //奖励列表
      $prize['activity_id'] = $activity_id['id'];
      $prize_list = D('activity_prize')->where($prize)->select();
      $this->assign('prize_list',$prize_list); 
      //兑换券
       $dui['type'] = 1;
       $dui['shop_id'] = session('shopUser.id'); 
       $dui_list = D('ticket')->where($dui)->select();
       $this->assign('dui_list',$dui_list); 
       //优惠券
       $you['type'] = 2;
       $you['shop_id'] = session('shopUser.id'); 
       $you_list = D('ticket')->where($you)->select();
       $this->assign('you_list',$you_list);
       
     }else{
      $this->error('请选择修改项');
     }

    $this->display();
   }
   
   public function code_prize_save(){
     if(IS_POST){
      //print_r($_POST);exit;
         $code_id = I('choose_code_id');
         $money_type = I('money_type');
         $money = I('money');
         $amount = I('amount');
         $activity_post_id = I('activity_post_id');
        
         for ($i=0; $i < count($money); $i++) { 
            if($money_type[$i]==1){
              $money1+=$money[$i]*$amount[$i];
            }
            if($money_type[$i]==2){
             $money2+=$money[$i];
            }
            if(!$money[$i]){
              return show(0,'奖励不能为空');
            }
              if($money[$i]<0.3){
              return show(0,'最小奖励金额不能小于0.3元');
            }
            $amount_total+=$amount[$i];
          }
  
          //奖励数量 大于 二维码数量时
           $num_id = implode(',',$code_id);
           $coo['code_num_id'] = array('in',$num_id);
           $code_count = D('code')->where($coo)->count();
           // print_r($code_count);exit;
           if($amount_total>$code_count){//奖励数量 大于 二维码数量时
            return show(0,'奖励数量不能大于总码量哦');
           }

           //判断账户金额 够不够
          $moneys = $money1+$money2;
          $sho['id'] = session('shopUser.id');
          $shop = D('shop')->where($sho)->field('money')->find();
          if($moneys>$shop['money']){
           return show(0,'您的账户余额不足，请尽快充值');
          }
          //保存码段
            $in = implode(',',$code_id);
            $code_save['id'] = array('in',$in); 
            $sss['activity_id'] = $activity_post_id;
            $code_ok = D('code_num')->where($code_save)->save($sss);
            if($code_ok){
             $actic['activity_id'] = $activity_post_id;
             $dada['code_num_id'] = $code_save['id'];
             D('code')->where($dada)->save($actic);
             }
      //保存奖励

            for ($i=0; $i < count($money); $i++) { 
                $mmm['prize_type'] = $money_type[$i];
                $mmm['prize'] = $money[$i];
                $mmm['prize_amount'] = $amount[$i];
                $mmm['activity_id'] = $activity_post_id;
                $ok1 = D('activity_prize')->add($mmm);
                if($ok1){
                    if($mmm['prize_type']==2){//随机红包
                     $mom = $money[$i]/$amount[$i];
                     $max = $mom*0.1+$mom;
                     $min = $mom-($mom*0.1);
                     if($min<0.3){
                       $min = 0.3;//最小0.3
                     }
                     //生成随机红包
                     Vendor('Weixinpay.redbag');
                     $wxpay = new \Reward();
                     $res = $wxpay->splitReward($money[$i],$amount[$i],$max,$min);
                     foreach ($res as $k => $v) {
                       $sv['activity_id'] = $ok;
                       $sv['prize_id'] = $ok1;
                       $sv['money'] = $v/100;
                       D('suijibag')->add($sv);
                     }
                   }
                  //红包奖励一一对应
                 $where['activity_prize_id'] = 0;
                 $where['code_num_id'] = $code_save['id'];
                 D('code')->where($where)->limit($amount[$i])->save(array('activity_prize_id'=>$ok1));
                }
              } 

                $acti['id'] = $activity_post_id;
                $active = D('activity')->where($acti)->field('act_name')->find();
                //奖励属于资金流水  存进记录里面
                if($ok1){
                  $shop_save['money'] = $shop['money']-$moneys;
                  $ok_s = D('shop')->where($sho)->save($shop_save);
                  if($ok_s){
                     $fin_zong['userid'] = session('shopUser.id');
                     $fin_zong['roletype'] = 1;//商户
                     $fin_zong['moneytype'] = 2;//分配资金
                     $fin_zong['money'] = $moneys;//金额
                     $fin_zong['full'] =  $shop_save['money'];//账户剩余金额
                     $fin_zong['time'] = time();
                     $fin_zong['content'] = '活动id:'.$activity_post_id.',活动名称：'.$active['act_name'];
                     $ok2 = M('money_record')->add($fin_zong);
                  }
                }

         // 把所有得奖励拆分成一个个 存进数据库
        /*  for ($i=0; $i < count($money); $i++) { 
              for ($j=0; $j < count($amount[$i]); $j++) { 
                  $mmm['prize_type'] = $money_type[$i];
                  $mmm['prize'] = $money[$i];
                  $mmm['activity_id'] = $activity_post_id;
                  $ok2 = D('activity_prize')->add($mmm);
               }
              }

             //二维码和奖励一一对应  奖励
               $wher['activity_id'] = $activity_post_id;
               $prize_list = D('activity_prize')->where($wher)->select();
              // print_r($prize_list);exit;
               $code_s['code_num_id'] = $code_save['id'];
               $code_list = D('code')->where($code_s)->select();
               for ($i=0; $i < count($prize_list); $i++) { 
                 $save_prize['activity_prize_id'] = $prize_list[$i]['id'];
                 $code_d['id'] = $code_list[$i]['id'];
                 D('code')->where($code_d)->save($save_prize);
               }*/

                if($ok2){
                  return show(1,'追加成功');
                }else{
                  return show(0,'追加失败');
                }

            }

         } 



        public function record(){
          prize_value(12);
             $act_id = I('activity_id');
             $count=D('get_record')
             ->table('red_activity act,red_get_record ge,red_member mem,red_code co')
             ->field('act.act_name,co.number,mem.wx_name,mem.sex,mem.wx_pic,ge.prize_type,ge.id,ge.time')
             ->where('act.id=ge.activity_id and ge.member_id=mem.id and ge.code_id=co.id and act.id="'.$act_id.'"')
             ->count(); 

            $page=$_REQUEST['p'] ? $_REQUEST['p'] :1;
            $pageSize=20;  
            $offset=($page-1)*$pageSize;  
            $datapage=new \Think\Page($count,$pageSize);  
            $datapage->setConfig('header','<br/><br/>共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页');  
            $datapage->setConfig('prev','上一页');
            $datapage->setConfig('next','下一页');
            $datapage->setConfig('theme','%UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %HEADER%');
            //print_r($list);exit;
             $list=D('get_record')
             ->table('red_activity act,red_get_record ge,red_member mem,red_code co')
             ->field('act.act_name,co.number,mem.wx_name,mem.sex,mem.wx_pic,ge.prize_type,ge.id,ge.time')
             ->where('act.id=ge.activity_id and ge.member_id=mem.id and ge.code_id=co.id and act.id="'.$act_id.'"')
             ->order('ge.time desc')->limit($offset,$pageSize)->select();
             $this->assign('page',$pageRes);
             $this->assign('list',$list);
 //print_r($list);exit;

          $this->display();
        }




        public function userdata(){
           header("Content-type:text/html;charset=utf-8");
            $act['activity_id'] = I('activity_id');
            $this->assign('activity_id',$act['activity_id']);
            $count = D('userdata')->where($act)->group('member_id')->count();
            $page=$_REQUEST['p'] ? $_REQUEST['p'] :1;
            $pageSize=20;  
            $offset=($page-1)*$pageSize;  
            $datapage=new \Think\Page($count,$pageSize);  
            $datapage->setConfig('header','<br/><br/>共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页');  
            $datapage->setConfig('prev','上一页');
            $datapage->setConfig('next','下一页');
            $datapage->setConfig('theme','%UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %HEADER%');
            $list = D('userdata')->where($act)->group('member_id')->select();
            $this->assign('page',$pageRes);
            $this->assign('list',$list);
          $this->display();
        }

      public function excel(){
         $act['activity_id'] = I('activity_id');
         $list = D('userdata')->where($act)->group('member_id')->select();
        $name = activity_name($act['activity_id']).'-用户信息.xls';
        header("Content-type:application/vnd.ms-excel");//输出excel头
        header("Content-Disposition:filename=$name");
        echo @iconv('utf-8', 'gbk', '活动名称')."\t";
        echo @iconv('utf-8', 'gbk', '用户')."\t";
        echo @iconv('utf-8', 'gbk', '收集信息')."\t";
        echo @iconv('utf-8', 'gbk', '提交时间')."\t\n";//  \t\n表示换行
        foreach($list as $key=>$v){
            // $exchange_time = $v['exchange_time']>0 ? date('Y-m-d H:i:s',$v['exchange_time']) : '--';
           // $time = $v['addtime']>0 ? date('Y-m-d H:i:s',$v['addtime']) : '--';
            echo @iconv('utf-8', 'gbk', activity_name($v['activity_id']))."\t";
            echo @iconv('utf-8', 'gbk', member_wxname($v['member_id']))."\t";
            echo @iconv('utf-8', 'gbk', userdata_string($v['member_id']))."\t";
            echo $v['time']>0 ? @date('Y-m-d H:i:s',$v['time'])."\t\n" : '--'."\t\n";
        }

    }



}





















 ?>