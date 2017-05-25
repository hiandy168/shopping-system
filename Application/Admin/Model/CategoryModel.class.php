<?php
//第一步：定义命名空间
namespace Admin\Model;
//第二步：引入父类的控制器
use Think\Model;
//第三步：定义模型并且继承父类
class CategoryModel extends Model{
	public function getLevel($data,$id,$field_id,$field_pid,$field_level){
		$layers = new \Think\Level();
		$layers->classify($data,$id,$field_id,$field_pid,$field_level,$res);
		return $res;
	}
}