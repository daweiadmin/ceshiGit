<?php 

/**
 * 获取指定月份的第一天开始和最后一天结束的时间戳
 *
 * @param int $y 年份 $m 月份
 * @return array(本月开始时间，本月结束时间)
 */
function month_data($y="",$m=""){
 if($y=="") $y=date("Y");
 if($m=="") $m=date("m");
 $m=sprintf("%02d",intval($m));
 $y=str_pad(intval($y),4,"0",STR_PAD_RIGHT);
 
 $m>12||$m<1?$m=1:$m=$m;
 $firstday=strtotime($y.$m."01000000");
 $firstdaystr=date("Y-m-01",$firstday);
 $lastday = strtotime(date('Y-m-d 23:59:59', strtotime("$firstdaystr +1 month -1 day")));
 return array("firstday"=>$firstday,"lastday"=>$lastday);
}


 /**/
 /**
 * 使用curl获取远程数据
 * @param  string $url url连接
 * @return string      获取到的数据
 */
function curl_get_contents($url){
    $ch=curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);                //设置访问的url地址
    // curl_setopt($ch,CURLOPT_HEADER,1);               //是否显示头部信息
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);               //设置超时
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);   //用户访问代理 User-Agent
    curl_setopt($ch, CURLOPT_REFERER,$_SERVER['HTTP_HOST']);        //设置 referer
    curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);          //跟踪301
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        //返回结果
    $r=curl_exec($ch);
    curl_close($ch);
    return $r;
}


 /*查看三级内有无VIP或者总代*/
/*  function find_in_three($ref_id){
    $find = D('member')->where(array('id'=>$ref_id))->find();
    $i = 0;
    $i++;
    if($i<=3){
     if($find['level']==2||$find['level']==3){
       return 1;
      }else{
        find_in_three($find['refe_id']);
      }

    }else{
      return -1;
    }
   
 }*/


function fin_status($id){
  $data['finance_id'] = $id;
  $name = D('indent_mo')->where($data)->field('area_name')->find();
  return $name['area_name'];
}


function area_name($id){
  $data['id'] = $id;
  $name = D('area')->where($data)->field('area_name')->find();
  return $name['area_name'];
}
 function menu_name($id){
  $data['id'] = $id;
  $name = D('menu')->where($data)->field('name')->find();
  return $name['name'];
}
 function class_name($id){
  $data['id'] = $id;
  $name = D('class')->where($data)->field('class_name')->find();
  return $name['class_name'];
}
/* 会员用户名（手机号）*/
 function User_name($id){
  $data['id'] = $id;
  $name = D('member')->where($data)->field('wx_name')->find();
  if($name){
   return $name['wx_name'];
  }else{
   return '无';
  }
  
 }
 /* 会员用户名（手机号）*/
 function User_pic($id){
  $data['id'] = $id;
  $name = D('member')->where($data)->field('wx_pic')->find();
  if($name){
   return $name['wx_pic'];
  }
  
 }
 /* 会员等级*/
 function User_level($id){
  $data['id'] = $id;
  $name = D('member')->where($data)->field('level')->find();
  
	  switch ($name['level'])
	{
	case 0:
	  return "普通粉丝";
	  break;
	case 1:
	  return "普通会员";
	  break;
	case 2:
	  return "VIP";
	  break;
    case 3:
	  return "总代";
	  break;
	
	 }
  }
  /* VIP会员直接分销（VIP）人数*/
 function mem_sum($id){
      $data['refe_id'] = $id;
      $data['level'] = 0;
    $name = D('member')->where($data)->count();
    return $name;
  }

  function vip_sum($id){
      $data['refe_id'] = $id;
      $data['level'] = 1;
	  $name = D('member')->where($data)->count();
	  return $name;
  }
  /* VIP会员直招代理人数*/
  function daili_sum($id){
      $data['refe_id'] = $id;
      $data['level'] = 2;
	  $name = D('member')->where($data)->count();
	  return $name;
  }

 function get_one_vip_level($id){ 
     $data['refe_id'] = $id;
   // print_r($data);exit;
     $list = D('member')->where($data)->select();
     static $vip = 0;
     foreach ($list as $key => $value) {
      if($value['level']==1){//VIP
           $vip++;
      }
      if($value['level']==5){
        //return $vip;
        get_one_vip_level($value['id']);  
      }
      unset($list[$k]);
      
     }
 
     return $vip;

 }
/*一级一级查 vip_zong更新加一*/
 function vip_zong_jia1($id){
  $mem['id'] = $id;
  $member = D('member')->where($mem)->find();
  if($member['refe_id']!==0||$member['refe_id']!==''){
    $ref_mem = D('member')->where(array('id'=>$member['refe_id']))->field('id,vip_zong,refe_id,level')->find();
    //print_r($ref_mem);exit;
    if($ref_mem['level']!=0){
      $jia['vip_zong'] = $ref_mem['vip_zong']+1;
      $ok = D('member')->where(array('id'=>$member['refe_id']))->save($jia);
      if($ref_mem['refe_id']==0){
       return $ref_mem['id'];
      }else{
        vip_zong_jia1($ref_mem['id']);
      }
    }else{
      vip_zong_jia1($ref_mem['id']);
    }
  }
  return 0;
 }

  function get_one_daili_level($id){ 
    $data['refe_id'] = $id;
   // print_r($data);exit;
    $list = D('member')->where($data)->select();
     static $daili = 0;
     foreach ($list as $key => $value) {
      if($value['level']==2){//代理
          $daili++;
      }
      unset($list[$k]);
      get_one_daili_level($value['id']);  

     }
     unset($daili);
     return $daili;

 }
 /*取出该会员名下的所有vip数和代理数量*/
   function get_member_level($id){   
      $data['refe_id'] = $id;
   // print_r($data);exit;
      $list = D('member')->where($data)->select();
    //print_r($arr);exit;
      $vip = 0;
      $daili = 0;
     foreach ($list as $key => $value) {
     
      if($value['level']==1){//VIP
           $vip++;
      }elseif($value['level']==2){//代理
          $daili++;
      }else{
          return '';
      }
      unset($list[$k]);
      get_member_level($value['id']);  

     }
    // print_r($arr);exit;
      $arr['vip'] = $vip;
      $arr['daili'] = $daili;
      return $arr;
   }



  
   /**********************  寻找上级是否有代理   *************************************/
  function have_daili($mem_top_id){
    //ini_set ('memory_limit', '256M'); 
      $top['id'] = $mem_top_id;
      //print_r($top);exit;
      $data = M('member')->where($top)->find();
    if(!empty($data)){
      if($data['level']==2){
        return $data['id'];
      }elseif($data['level']<2){
        return have_daili($data['refe_id']);
      }
      elseif($data['level']>2)
      {
        return '';
      }
     }else{
       return '';
     }
      
   }


  /**********************  寻找上级是否有总监   *************************************/
  function have_zong($mem_top_id){
       $top['id'] = $mem_top_id;
      //print_r($top);exit;
      $data = M('member')->where($top)->find();
    if(!empty($data)){
      if($data['level']==3){
        return $data['id'];
      }elseif($data['level']<3){
        return have_zong($data['refe_id']);
      }
      elseif($data['level']>3)
      {
        return '';
      }
     }else{
       return '';
     }
    
      
   }
   /**********************  寻找上级是否有副总   *************************************/
  function have_fuzong($mem_top_id){
       $top['id'] = $mem_top_id;
      //print_r($top);exit;
      $data = M('member')->where($top)->find();
    if(!empty($data)){
      if($data['level']==4){
        return $data['id'];
      }elseif($data['level']<4){
        return have_fuzong($data['refe_id']);
      }
      elseif($data['level']>4)
      {
        return '';
      }
     }else{
       return '';
     }
      
   }
     /**********************  寻找上级是否有CEO   *************************************/
  function have_ceo($mem_top_id){
        $top['id'] = $mem_top_id;
      //print_r($top);exit;
      $data = M('member')->where($top)->find();
    if(!empty($data)){
      if($data['level']==5){
        return $data['id'];
      }elseif($data['level']<5){
        return have_ceo($data['refe_id']);
      }
      elseif($data['level']>5)
      {
        return '';
      }
     }else{
       return '';
     }

   }

   function fenrun_top_daili($top_taili_id,$money){
      $top['id'] = $top_taili_id;
      //print_r($top);exit;
      $data = M('member')->where($top)->find();
      if($data&&$data['level']==2){
        $money2 = $money*0.2;
        $data_fenrun['money'] = $data['money']+$money2;
        $ook = M('member')->where($top)->save($data_fenrun);
        if($ook){
         $fin_zong['userid'] = $data['id'];
         $fin_zong['roletype'] = 1;//会员
         $fin_zong['moneytype'] = 2;//提成
         $fin_zong['money'] = $money*0.2;//金额
         $fin_zong['money'] =  $data_fenrun['money'];//账户剩余金额
         $fin_zong['content'] = '下级代理，发展VIP客户，作为上级代理获得奖励'.$money2.'元';
         M('finances')->add($fin_zong);
        }
      }elseif($data['level']<1){
        return fenrun_top_daili($data['refe_id'],$money2);
      }elseif($data['level']>2){
        return '';
      }

  
   }
   

   function fahuo_daili($daili_id){
      $find['id'] = $daili_id;
      //print_r($top);exit;
      $data = M('member')->where($find)->find();
      if($data['level']==1 || $data['level']==0){
        return fahuo_daili($data['refe_id']);
      }elseif($data['level']==2){
        return $data['id'];
      }elseif($data['level']==3){
        return $data['id'];
      }elseif($data['level']==4){
        return $data['id'];
      }elseif($data['level']==5){
        return $data['id'];
      }else{
        return -1;
      }

   }
  /******************* 高阶函数调用 ********************/
  function gaojie_diaoyong($function_name, $canshu) {
      $result = call_user_func_array($function_name, $canshu);//call_user_func_array 利用高阶函数消除递归 栈溢出。参数$callback 函数名 调用类 / 函数内部的方法 
      while (is_callable($result)) {
          $result = $result();
     }
   
      return $result;
  }

   
  //var_dump(trampoline('factorial', array(100)));
  
  /*例子
  Class ClassA  
{  
function bc($b, $c) {  
     $bc = $b + $c;  
  echo $bc;  
 }  
}  
call_user_func_array(array('ClassA','bc'), array("111", "222"));  
call_user_func_array(array('类名','方法名'), array("参数1", "参数2")); */
//显示 333  

 /*会员资料*/
  
  function data_name($id){
      $data['member_id'] = $id;
      $name = D('member_data')->where($data)->field('name')->find();
      if($name){
       return $name['name'];
      }else{
      return '暂无资料';
      }
    
  }
  
  function data_sex($id){
      $data['member_id'] = $id;
      $name = D('member_data')->where($data)->field('sex')->find();
      if($name){
       return $name['sex'];
      }else{
      return '暂无资料';
      }
    
  }
    function data_age($id){
      $data['member_id'] = $id;
      $name = D('member_data')->where($data)->field('age')->find();
      if($name){
       return $name['age'];
      }else{
      return '暂无资料';
      }
    
  }
   function data_tel($id){
      $data['member_id'] = $id;
      $name = D('member_data')->where($data)->field('phone')->find();
      if($name){
       return $name['phone'];
      }else{
      return '暂无资料';
      }
    
  }
  function address_a($id){
      $data['id'] = $id;
      $name = D('address')->where($data)->field('location,address')->find();
      $re = $name['location'].'-'.$name['address'];
      if($name){
       return $re;
      }else{
      return '暂无资料';
      }
    
  }
   function address_p($id){
      $data['id'] = $id;
      $name = D('address')->where($data)->field('phone')->find();
      //$re = $name['location'].'-'.$name['address'];
      if($name){
       return $name['phone'];
      }else{
      return '暂无资料';
      }
    
  }



 ?>