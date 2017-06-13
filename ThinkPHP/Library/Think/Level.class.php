<?php
//第一步：定义命名空间
namespace Think;
//第三步：定义模型并且继承父类
class Level{
	/**
	 * [classify description]
	 * @param  array   $data        要分层的数组数据
	 * 
	 * @param  integer $id          默认0为顶级分类，对所有数据都进行统计
	 *                              开始分类的主键id，只对该id类及其子类进行统计分层
	 *
	 * @param  string  $field_id    $data主键id的字段名称，可能每张表不一样,默认为'id'
	 * @param  string  $field_pid   $data父类id的字段名称，可能每张表不一样,默认为'pid'
	 *
	 * @param  string  $level 		返回的等级字段索引名称，默认为'level'
	 * @param  array   &$res        返回的数据的变量，默认为空数组
	 *
	 * @param  integer $level       等级编号，默认从0开始
	 *
	 * @return array                返回引用参数$res
	 */
	public function classify($data,$id=0,$field_id='id',$field_pid='parent_id',$field_level='level',&$res=[],$level = 0){
		$num = count($data);
		for ($i=0; $i < $num; $i++) {
			if (isset($data[$i]["{$field_pid}"])&&$data[$i]["{$field_pid}"] == $id) {
				$data[$i]["{$field_level}"] = $level;
				$res[] = $data[$i];
				$this->classify($data,$data[$i]["{$field_id}"],$field_id,$field_pid,$field_level,$res,$level+1);
			}
		}
	}


	/**
	 * 获取指定分类所有后代的ID，包括自己的
	 * 通过指定记录的id调用classify方法，实现统计其及其子类id的目标
	 * @param  array  $data         要分层的数组数据
	 *                              指定分类的主键id，只对该id类及其子类进行统计
	 * @param  integer $subId       默认0对为顶级分类，对所有数据都进行统计
	 *
	 * @param  string  $field_id    $data主键的id字段名称，可能每张表不一样,默认为'id'
	 * @param  string  $field_pid   $data父类id的字段名称，可能每张表不一样,默认为'pid'
	 *
	 * @return array           		指定分类及其所有后代的ID信息
	 */
	public function getSubId($data,$subId,$field_id='id',$field_pid='pid'){
		$this->classify($data,$subId,$field_id,$field_pid,'level',$array);
		foreach ($array as $v) {
			$res[] = $v["{$field_id}"];
		}
		$res[] = $subId;
		return $res;
	}
}