<?php 
namespace Shop\Controller;
use Think\Controller;
class CodeController extends CommenController {

	 public function index(){

    $prov = D('code')->order('id desc')->field('id,number')->find();
    if($prov){
      $exp = explode('0',$prov['number']);
      $nex = '0000'.($exp[4]+1);
      $num = array('number'=>$nex,'num'=>$exp[4]);
    }else{
      $num = array('number'=>'00001','num'=>0);
    }
    $this->assign('prov',$num);
    /*展示数据*/
    $data['shop_id']=session('shopUser.id');
    $count = D('code_num')->where($data)->count();
    $page=$_REQUEST['p'] ? $_REQUEST['p'] :1;
    $pageSize=30;  
    $offset=($page-1)*$pageSize;  
    $list=D('code_num')->where($data)->limit($offset,$pageSize)->order('id desc')->select();
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
   /* public function add(){
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
           $ok2 = D('code')->add($data2);
         }
         if($ok2){
            return show(1,'新增成功');
          }else{
            return show(0,'新增失败');
          }
       }
       
      }

      
    }*/
    
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
         if($ok2){
            return show(1,'拆分成功');
          }else{
            return show(0,'拆分失败');
          }
       }

     } 


    }
          
        

     public function code_info(){
      $data['code_num_id'] = I('code_num');
      if(!$data['code_num_id']){
        $this->error('请选择您想要查看得码段');
      }
      $count = D('code')->where($data)->count();
      //print_r($count);exit;
      $page=$_REQUEST['p'] ? $_REQUEST['p'] :1;
      $pageSize=10;  
      $offset=($page-1)*$pageSize;  
      $list=D('code')->where($data)->limit($offset,$pageSize)->order('id desc')->select();
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

    public function yulan(){
     


    }


   
     function yulan_code(){
        $data['id'] = I('code_id');
        if($data['id']){
        $code = D('code')->where($data)->find();
        ob_end_clean();
        $link_url = 'http://redbag.lingcheng888.com/index.php/home/wechat/index?sn='.$code['code_sn'];
        $level=3;  
        $size=4;  
        Vendor('phpqrcode.phpqrcode');  
        $errorCorrectionLevel =intval($level) ;//容错级别  
        $matrixPointSize = intval($size);//生成图片大小  
        //生成二维码图片  
        $object = new \QRcode();  
        $object->png($link_url,false, $errorCorrectionLevel, $matrixPointSize, 2);
        }
    }

  //$code_url = "= "http://www.junuu.net/index.php/Pay/Wxpay/qrcode?data=".ur".urlencode($code_url);

    //// 批量导出码段二维码图片  压缩程zip
    
        public function daochu(){
           if(IS_POST){
             $data['code_num_id'] = I('code_num_id');
             $data['code_number'] = I('code_number');
             if(empty($data)){
               return show(0,'参数错误');
             }
             //print_r($data);exit;
             $code_list = D('code')->where($data)->field('code_sn,number')->select();
             $shop_id = session('shopUser.id');
             //二维码生成后 存入路径  查看该商户有没有属于自己得 文件夹 如果有则返回路径 没有则生成 
             $Path = set_wenjianjia($shop_id);
             foreach ($code_list as $key => $value) {
               set_code_img($value['code_sn'],$Path,$value['number']);
             }
             $url = 'shop'.$shop_id;
             $filename = "Public/erweima/".$url."/".$data['code_number'].".zip";
            //参数1:zip保存路径，参数2：ZIPARCHIVE::CREATE没有即是创建  
             $datalist = list_dir($Path);
             if(!file_exists($filename)){  
            //重新生成文件  
              $zip = new \ZipArchive();//使用本类，linux需开启zlib，windows需取消php_zip.dll前的注释  
              if ($zip->open($filename, \ZIPARCHIVE::CREATE)!==TRUE) {  
                exit('无法打开文件，或者文件创建失败');
              }  
             // print_r($datalist);exit;
              foreach($datalist as $val){ 
                if(file_exists($val)){  
                  $b = $zip->addFile( $val, basename($val));//第二个参数是放在压缩包中的文件名称，如果文件可能会有重复，就需要注意一下  
                }  
              }  
              $zip->close();//关闭  
            }  
            if(!file_exists($filename)){  
              return show(0,'打包失败');
            }else{
              return show(1,'',$filename);
            }  
           /* header("Cache-Control: public"); 
            header("Content-Description: File Transfer"); 
            header('Content-disposition: attachment; filename='.basename($filename)); //文件名  
            header("Content-Type: application/zip"); //zip格式的  
            header("Content-Transfer-Encoding: binary"); //告诉浏览器，这是二进制文件  
            header('Content-Length: '. filesize($filename)); //告诉浏览器，文件大小  
            @readfile($filename);*/
            }


        }
         
         public function downFile(){
              if (empty($_GET['file'])) {
                //print_r($_GET);exit;
                  $this->error("下载地址不存在");
              }
              $filename = $_GET['file'];
              // print_r($filename);exit;
              $filePath =   $filename;
              $filePath = iconv( 'UTF-8', 'GB18030', $filePath);

              if (!file_exists($filePath)) {
                  $this->error("该文件不存在，可能是被删除");
              }
              // $filename = basename($filePath);
              $filename = end(explode('/', $filePath)); 
              //下载完成后 删除目录下得文件
             // deldir($filename);
          // pp($filename,1,1,1);
              header("Content-type: application/octet-stream");
              header('Content-Disposition: attachment; filename="' . $filename . '"');
              header("Content-Length: " . filesize($filePath));

              readfile($filePath);
            
          }
      
       
       //++++++++++++++++++++++++++++++++++++++++++++++++打包下载

       public function zip_download(){
           header("Content-type:text/html;charset=utf-8");
           $Path = 'Public/erweima/shop1/';
          //参数1:zip保存路径，参数2：ZIPARCHIVE::CREATE没有即是创建  
           $datalist = list_dir($Path);
           $filename = "Public/erweima/shop1/ceshi2.zip"; //最终生成的文件名（含路径）  
           if(!file_exists($filename)){  
          //重新生成文件  
            $zip = new \ZipArchive();//使用本类，linux需开启zlib，windows需取消php_zip.dll前的注释  
            if ($zip->open($filename, \ZIPARCHIVE::CREATE)!==TRUE) {  
              exit('无法打开文件，或者文件创建失败');
            }  
           // print_r($datalist);exit;
            foreach($datalist as $val){ 
              if(file_exists($val)){  
                $b = $zip->addFile( $val, basename($val));//第二个参数是放在压缩包中的文件名称，如果文件可能会有重复，就需要注意一下  
              }  
            }  
            $zip->close();//关闭  
          }  
          if(!file_exists($filename)){  
            exit("无法找到文件"); //即使创建，仍有可能失败。。。。  
          }  
          header("Cache-Control: public"); 
          header("Content-Description: File Transfer"); 
          header('Content-disposition: attachment; filename='.basename($filename)); //文件名  
          header("Content-Type: application/zip"); //zip格式的  
          header("Content-Transfer-Encoding: binary"); //告诉浏览器，这是二进制文件  
          header('Content-Length: '. filesize($filename)); //告诉浏览器，文件大小  
          @readfile($filename);
         
       }

   

  

}




























 ?>