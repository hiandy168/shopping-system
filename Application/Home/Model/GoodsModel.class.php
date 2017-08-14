<?php
//第一步：定义命名空间
namespace Home\Model;
//第二步：引入父类的控制器
use Think\Model;
//第三步：定义模型并且继承父类
class GoodsModel extends Model{
	/**
	 * 获取推荐/促销商品
	 * @param  int   $limit  首页推荐商品显示条目数
	 * @return array         返回推荐商品数据
	 */
	public function getPromoteGoods($limit=5,$cat_id=''){
		$today = date('Y-m-d H:i:s');
		$where = ['promote_price'=>['gt',0],
				  'promote_start_date'=>['elt',$today],
				  'promote_end_date'=>['egt',$today],
				  'is_on_sale'=>['eq','是'],
				];
		//根据分类ID查询其分类下及其子分类下的商品ID
		$ids = $this->getGoodsIdByCatId($cat_id);
		//如果根据cat_id查到主分类和扩展分类存在此cat_id的商品，那么根据商品id为in条件查询
		if(!empty($ids)){
			$where = array_merge($where,['id'=>['in',$ids]]);
		//否则说明此类商品不存在，为保证查不到东西，则以cat_id本身为in条件，以此保证结果为空
		}else{
			$where = array_merge($where,['cat_id'=>$cat_id]);
		}
		return $this->field('id,goods_name,mid_logo,promote_price')
		->where($where)
		->order('sort_num asc')
		->limit($limit)
		->select();
	}
	/**
	 * 根据条件字段选取商品
	 * @param  string  $rectype 选取的条件字段
	 * @param  integer $limit   首页显示条目数
	 * @return array            返回推荐商品数据
	 */
	public function getRecGoods($rectype,$limit=5){
		return $this->field('id,goods_name,mid_logo,shop_price')
		->where([
			"{$rectype}"=>['eq','是'],
		])
		->order('sort_num asc')
		->limit($limit)
		->select();
	}
	public function getGoodsIdByCatId($cat_id){
		//为0则是获取所有分类下的商品，无需查找子分类
		$ids = [];
		if ($cat_id!=0) {
			$catModel = D('Category');
        	$goodsModel = D('Goods');
			$gcModel = D('goods_cat');
			//先获取所有分类数据
			$catres = $catModel->where("is_show='是'")->select();
			//根据分类查询商品时，获取指定分类及其子分类的所有ID
			$cat_id_list = $catModel->getLevelId($catres,$cat_id,'id','parent_id','level');

			//根据指定的分类ID，取出若其为主分类时的商品id
			$gids = $goodsModel->field('id')->where(['cat_id'=>['in',$cat_id_list]])->select();
			//根据指定的分类ID，取出若其为扩展分类时的商品ID，DISTINCT去重
			$gcids = $gcModel->field('DISTINCT goods_id as id')->where(['cat_id'=>['in',$cat_id_list]])->select();
			//将两份id数组合并，得到主分类或者扩展分类为指定分类的商品id数组
			$gids = array_merge($gids,$gcids);
			//遍历上面的id二维数组，得到由商品ID组成的一维数组
			foreach ($gids as $k=>$v) {
				if(!in_array($v['id'],$ids)){
					$ids[] = $v['id'];
				}
			}
		}
		return $ids;
	}
}