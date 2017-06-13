<?php
//第一步：定义命名空间
namespace Home\Model;
//第二步：引入父类的控制器
use Think\Model;
//第三步：定义模型并且继承父类
class GoodsModel extends Model{
	public function getPromoteGoods($limit){
		$today = date('Y-m-d H:i:s');
		return $this->field('id,goods_name,mid_logo,promote_price')
		->where([
			'promote_price'=>['gt',0],
			'promote_start_date'=>['elt',$today],
			'promote_end_date'=>['egt',$today],
			'is_on_sale'=>['eq','是'],
		])
		->order('sort_num asc')
		->limit($limit)
		->select();
	}
	public function getRecGoods($rectype,$limit=5){
		return $this->field('id,goods_name,mid_logo,shop_price')
		->where([
			"{$rectype}"=>['eq','是'],
		])
		->order('sort_num asc')
		->limit($limit)
		->select();
	}
}