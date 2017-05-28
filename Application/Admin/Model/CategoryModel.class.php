<?php
//第一步：定义命名空间
namespace Admin\Model;
//第二步：引入父类的控制器
use Think\Model;
//第三步：定义模型并且继承父类
class CategoryModel extends Model{
	public function getLevel($data,$id,$field_id,$field_pid,$field_level){
		$levels = new \Think\Level();
		$levels -> classify($data,$id,$field_id,$field_pid,$field_level,$res);
		return $res;
	}
	public function getLevelId($data,$subId,$field_id,$field_pid){
		$levels = new \Think\Level();
		$res = $levels -> getSubId($data,$subId,$field_id,$field_pid);
		//返回当前分类的ID及其子ID的数组信息
		return $res;
	}
}