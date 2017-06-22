<?php
//第一步：定义命名空间
namespace Home\Model;
//第二步：引入父类的控制器
use Think\Model;
//第三步：定义模型并且继承父类
class CategoryModel extends Model{
	public function __construct(){
		parent::__construct();
		//缓存初始化
		S(['type'=>'memcache','host'=>'localhost','port'=>'11211','expire'=>86400]);
	}
	public $error;
	//将分类数据根据parent_id分层级
	public function getLevel($data,$id,$field_id,$field_pid,$field_level){
		$levels = new \Think\Level();
		$levels -> classify($data,$id,$field_id,$field_pid,$field_level,$res);
		return $res;
	}
	//获取指定分类的id及其子类id
	public function getLevelId($data,$subId,$field_id,$field_pid){
		$levels = new \Think\Level();
		$res = $levels -> getSubId($data,$subId,$field_id,$field_pid);
		//返回当前分类的ID及其子ID的数组信息
		return $res;
	}
	//获取导航数据
	public function getNavData($data_list){
		// 先从缓存中取出数据
		$catData = S('catData');
		// 判断如果没有缓存或者缓存过期就重新构造数组
		if(!$catData){
			// 取出所有的分类
			$all = $data_list;
			$ret = [];
			// 循环所有的分类找出顶级分类
			foreach ($all as $k => $v){
				if($v['parent_id'] == 0){
					// 循环所有的分类找出这个顶级分类的子分类
					foreach ($all as $k1 => $v1){
						if($v1['parent_id'] == $v['id']){
							// 循环所有的分类找出这个二级分类的子分类
							foreach ($all as $k2 => $v2){
								if($v2['parent_id'] == $v1['id']){
									$v1['children'][] = $v2;//找到第三级就不找了
								}
							}
							$v['children'][] = $v1;
						}
					}
					$ret[] = $v;
				}
			}
			// 把数组缓存1天
			S('catData',$ret);
			return $ret;
		}else{
			return $catData;  // 有缓存直接返回缓存数据
		}
	}
	public function getFloorData(){
		//获取要显示到楼层的一级主分类
		$res = $this->where([
			'parent_id'=>['eq',0],
			'is_floor'=>['eq','是'],
			'is_show'=>['eq','是'],
		])
		->select();
		foreach ($res as $k => $v) {
			//获取不要显示到楼层的分类数据
			$res[$k]['subCat'] = $this->where([
				'parent_id'=>['eq',$v['id']],
				'is_floor'=>['eq','否'],
				'is_show'=>['eq','是'],
			])->select();
			//获取要显示到楼层的分类数据
			$res[$k]['recSubCat'] = $this->where([
				'parent_id'=>['eq',$v['id']],
				'is_floor'=>['eq','是'],
				'is_show'=>['eq','是'],
			])->select();
			foreach ($res[$k]['recSubCat'] as $k0 => $v0) {
				//为每个显示到楼层的二级分类选取推荐商品
				$goodsModel = D('Goods');
        		$res[$k]['recSubCat'][$k0]['goodslist'] = $goodsModel->getPromoteGoods(5,$res[$k]['recSubCat'][$k0]['id']);
			}
		}
		return $res;
	}
}