<?php 
namespace Admin\Controller;
use Think\Controller;
class CodeController extends CommenController {

	 public function index(){
  /* $code = D('code')->limit(10)->field('id')->select();
   $a = array_rand($code,1);
   print_r($a);exit;*/
    $prov = D('code')->order('id desc')->field('id,number')->find();

    if($prov){
      $exp = explode('0',$prov['number']);
      $lenth = strlen($prov['number']);
      $int = $lenth-4;
      $abc=substr($prov['number'],-$int);
      //print_r($exp);exit;
      $nex = '0000'.($abc+1);
      //print_r($nex);exit;
      $num = array('number'=>$nex,'num'=>$abc);
    }else{
      $num = array('number'=>'00001','num'=>0);
    }
    $this->assign('prov',$num);
    /*展示数据*/
    $count = D('code_num')->count();
    $page=$_REQUEST['p'] ? $_REQUEST['p'] :1;
    $pageSize=30;  
    $offset=($page-1)*$pageSize;  
    $list=D('code_num')->limit($offset,$pageSize)->order('id desc')->select();
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
     /*生成码段*/
    public function add(){
      if(IS_POST){
       $code_shu = I('code_shu');
       $shuliang = I('shuliang');
       $a = '0000'.($code_shu+1);
       $b = '0000'.($code_shu+$shuliang);
       $data['code_number'] = $a.'--'.$b;
       $data['pici'] = time();
       $data['time'] = time();
       //print_r($data);exit;
       //print_r($data);exit;
       $ok = D('code_num')->add($data);
       if($ok){
         for ($i=0; $i <$shuliang; $i++) { 
           $code_shu++;
           $data2['number'] = '0000'.$code_shu;
           $data2['pici'] = $data['pici'];
           $data2['code_num_id'] = $ok;
           $sn = set_code_sn(4,1);
           $data2['code_sn'] = $sn;
           $ok2 = D('code')->add($data2);
         }
         if($ok2){
            return show(1,'新增成功');
          }else{
            return show(0,'新增失败');
          }
       }
       
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
       $code_amount = D('code')->where($sel)->count();
       if($code_amount<=$num){
          return show(0,'拆分数量太多！');
       }
       $n = count($code)-1;
       $data['code_number'] = $code[$n]['number'].'--'.$code[0]['number'];
       $data['pici'] = $code_num['pici'];
       $data['time'] = time();
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
         if($ok2){
            return show(1,'拆分成功');
          }else{
            return show(0,'拆分失败');
          }
       }

     } 


    }
          
        

  









  

}




























 ?>