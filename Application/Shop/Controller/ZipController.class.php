<?php 
namespace Shop\Controller;
use Think\Controller;
class ZipController extends CommenController {
 
  public function __construct($curpath,$savepath){
    $this->currentdir=$curpath;//返回当前目录
    $this->savepath=$savepath;//返回当前目录
  } 


   /**
  * 返回文件的大小
  *
  * @param string $filename 文件名
  * @return 文件大小(KB)
  */
 public function getfilesize($fname){
  return filesize($fname)/1024;
 }


   //遍历目录
 public function scandir($filepath){
  if (is_dir($filepath)){
    $arr=scandir($filepath);
    foreach ($arr as $k=>$v){
     $this->fileinfo[$v][]=$this->getfilesize($v);
    }
   }else {
    echo "<script>alert('当前目录不是有效目录');</script>";
   }
 }
 
  /**
  * 压缩文件(zip格式)
  */
	 public function tozip($items){ 
	  $zip=new ZipArchive();
	  $zipname=date('YmdHis',time());
	  if (!file_exists($zipname)){
	   $zip->open($savepath.$zipname.'.zip',ZipArchive::OVERWRITE);//创建一个空的zip文件
	   for ($i=0;$i<count($items);$i++){
	    $zip->addFile($this->currentdir.'/'.$items[$i],$items[$i]);
	   }
	   $zip->close();
	   $dw=new download($zipname.'.zip',$savepath); //下载文件
	   $dw->getfiles();
	   unlink($savepath.$zipname.'.zip'); //下载完成后要进行删除 
	  }
	 }
   

    








	}











