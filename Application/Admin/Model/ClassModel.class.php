<?php 
namespace Admin\Model;
use Think\Model;
//分类树
class ClassModel extends Model{
	public function classtree(){
		$data=$this->select();                        //取出相应数据
        return $this->_resort($data);            //调用下面的函数_resort
		
	}


//递归运算 对所有分类排序
    public function _resort($data,$parentid=0,$level=0){                       //level 0代表顶级分类 1代表二级。。。
    	static $ret=array();         //默认0      默认0                             //静态数组 用于存储数据
    	foreach($data as $k=>$v){
              if($v['parentid']==$parentid){      //如果取出来的数据parentid=0 则
              	$v['level']=$level;                         //认为是顶级分类
              	$ret[]=$v;
              	$this->_resort($data,$v['id'],$level+1);     //重新调用函数_resort 根据class_id找二级分类      $level+1是二级分类
              }
    	}
    	return $ret;
    }
  }
 ?>