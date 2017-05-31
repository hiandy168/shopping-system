<?php
namespace Admin\Controller;
use Think\Controller;
class GoodsController extends CommenController {
	/**
	 * 商品信息列表展示
	 * @return mixed 返回根据条件查询出的商品列表信息，初始还返回品牌列表信息和分类列表信息
	 */
	public function goodsList(){
		$goodsModel = D('goods');
		$catModel = D('category');
		$catres = $catModel->where("is_show='是'")->select();
		if (I('get.tar_page')) {
			//以下组装$where的条件
			if (I('get.cat_id')!=='0') {
				//根据分类查询商品时，获取指定分类及其子分类的所有商品
				$cat_id_list = $catModel->getLevelId($catres,I('get.cat_id'),'id','parent_id','level');

				//根据指定的分类ID，取出若其为主分类时的商品id
				$gids = $goodsModel->field('id')->where(['cat_id'=>['in',$cat_id_list]])->select();
				//根据指定的分类ID，取出若其为扩展分类时的商品ID，DISTINCT去重
				$gcModel = D('goods_cat');
				$gcids = $gcModel->field('DISTINCT goods_id as id')->where(['cat_id'=>['in',$cat_id_list]])->select();
				//将两份id数组合并，得到主分类或者扩展分类为指定分类的商品id数组
				$gids = array_merge($gids,$gcids);

				$ids = [];
				//遍历上面的id二维数组，得到由商品ID组成的一维数组
				foreach ($gids as $k=>$v) {
					if(!in_array($v['id'],$id)){
						$ids[] = $v['id'];
					}
				}
				//如果根据cat_id查到主分类和扩展分类存在此cat_id的商品，那么根据商品id为in条件查询
				if(!empty($ids)){
					$condition['g.id'] = ['in',$ids];
				//否则说明此类商品不存在，为保证查不到东西，则以cat_id本身为in条件，以此保证结果为空
				}else{
					$condition['g.cat_id'] = ['in',$cat_id_list];
				}
			}
			if (I('get.brand_id')!=='0') {
				$condition['brand_id'] = I('get.brand_id');//品牌ID
			}
			if (I('get.intro_type')!=='is_all') {
				$condition[I('get.intro_type')] = '是';//推荐类型，精品、热销、新品
			}
			if (I('get.is_on_sale')!=='is_all') {
				$condition['is_on_sale'] = I('get.is_on_sale')?'是':'否';//是否上架
			}
			//价格区间
			if(I('get.price_low')!=''&&I('get.price_up')!=''){
				$low = I('get.price_low');
				$up = I('get.price_up');
				$condition['shop_price'] = ['between',"{$low},{$up}"];
			}elseif(I('get.price_low')!=''){
				$low = I('get.price_low');
				$condition['shop_price'] = ['EGT',I('get.price_low')];
			}elseif(I('get.price_up')!=''){
				$up = I('get.price_up');
				$condition['shop_price'] = ['ELT',I('get.price_up')];
			}
			//价格排序方式
			if (I('get.price_order')=='price_desc') {
				$order = ['shop_price desc'];
			}elseif(I('get.price_order')=='price_asc'){
				$order = ['shop_price asc'];
			}
			//添加时间区间
			if(I('get.time_start')!=''&&I('get.time_end')!=''){
				$start = I('get.time_start');
				$end = I('get.time_end');
				$condition['addtime'] = ['BETWEEN',["{$start}","{$end}"]];
			}elseif(I('get.time_start')!=''){
				$start = I('get.time_start');
				$condition['addtime'] = ['EGT',"{$start}"];
			}elseif(I('get.time_end')!=''){
				$end = I('get.time_end');
				$condition['addtime'] = ['ELT',"{$end}"];
			}
			//获取分页数据
			$res = $goodsModel->getLimitData(I('get.tar_page'),I('get.rowsNum'),$condition,$order);
			//将搜索的条件存入session
			session('search',[I('get.tar_page'),I('get.rowsNum'),$condition,$order,I('get.')]);
			echo json_encode($res);
		}else{
			//如果是从编辑页面回来的，则按原查询方式查询，从session中拿回查询条件
			if (I('get.from')=='goodsEdit'&&session('search')) {
				$search = session('search');
				//及时删除session，避免初始没有指定查询条件时也读取旧的session条件存在
				$res = $goodsModel->getLimitData($search[0],$search[1],$search[2],$search[3]);
				$search_condition = $search[4];
			}else{
				session('search',null);
				//初始默认显示所有数据的的第一页,（页码、条目）
				$res = $goodsModel->getLimitData(1,5);
				$search_condition = 'null';
			}
			//以下获取总的品牌和分类列表用户显示在搜索栏
			$cat_list = $catModel->getLevel($catres,0,'id','parent_id','level');
			$brandModel = D('brand');
			$brand_list = $brandModel->where("is_show='是'")->select();
			$this->assign([
				'goods_list' =>	$res['goods_list'],
				'pages'		 =>	$res['pages'],
				'cat_list'	 => $cat_list,
				'brand_list' => $brand_list,
				'search_condition'=>$search_condition
			]);
			$this->display();
		}
	}
	/**
	 * 默认展示商品添加表单，ajax执行添加操作
	 * @return [type] [description]
	 */
	public function goodsAdd(){
		//判断是否提交了表单
		if (IS_POST) {
			$model = D('Goods');
			//接收并验证表单
			//使用I方法过滤表单数据，1指定为添加
			if ($model->create(I('post.'),1)) {
				if ($model->add()) {
					$sign = 'success';
				}else{
					$sign = $model->error;
				}
			}else{
				$sign = $model->getError();
			}
			echo json_encode($sign);
		}else{
			$catModel = D('category');
			$res = $catModel->where("is_show='是'")->select();
			$cat_list = $catModel->getLevel($res,0,'id','parent_id','level');

			$brandModel = D('brand');
			$brand_list = $brandModel->where("is_show='是'")->select();

			//创建模型关联会员级别表，并取出所有会员级别信息
			$memberModel = D('member_level');
			$member_level_list = $memberModel->select();

			$this->assign([
				'brand_list'=> $brand_list,
				'cat_list'	=> $cat_list,
				'member_level_list'=>$member_level_list
			]);
			$this->display();
		}
	}
	/**
	 * 默认展示商品信息更新表单，ajax执行更新操作
	 * @return [type] [description]
	 */
	public function goodsEdit(){
		$model = D('Goods');
		//判断是否提交了表单
		if (IS_POST) {
			//接收并验证表单,使用I方法过滤表单数据，2指定为更新
			$data = $model->create(I('post.'),2);
			if ($data) {
				// $sign = $model->fetchSql(true)->where('id = '.I('post.id'))->save($data);
				if ($model->where('id = '.I('post.id'))->save($data)!==FALSE) {
					$sign = 'success';
				}else{
					$sign = $model->error;
				}
			}else{
				$sign = $model->getError();
			}
			echo json_encode($sign);
		}else{
			//要修改信息的商品的ID
			$id = I('get.id');
			$condition['goods_id'] = $id;
			$goods_detail = $model->where("id = {$id}")->find();
			//获取分类和品牌信息
			$catModel = D('category');
			$res = $catModel->where("is_show='是'")->select();
			$cat_list = $catModel->getLevel($res,0,'id','parent_id','level');
			$brandModel = D('brand');
			$brand_list = $brandModel->where("is_show='是'")->select();

			$mpModel = D('member_price');
			$goods_detail_member_price_list = $mpModel->field('l.*,r.level_name')->alias('l')->join('left join ss_member_level as r on l.level_id = r.id')->where($condition)->select();
			if(empty($goods_detail_member_price_list)){
				//这里是为了处理之前还没有添加会员价格表，因此有的商品没有记录，于是以此生成空白的输入框
				$mlModel = D('member_level');
				$goods_detail_member_price_list =$mlModel->field('l.level_name,l.id,r.*')->alias('l')->join('left join ss_member_price as r on l.id = r.level_id and goods_id = '.$id)->select(); 
			}

			$gcModel = D('goods_cat');
			$goods_detail_ext_cat_list = $gcModel->where($condition)->select();

			$this->assign([
				'brand_list'=> $brand_list,
				'cat_list'	=> $cat_list,
				'goods_detail'=>$goods_detail,
				'goods_detail_member_price_list'=>$goods_detail_member_price_list,
				'goods_detail_ext_cat_list'=>$goods_detail_ext_cat_list
			]);
			$this->display();
		}
	}
	/**
	 * 将商品放置回收站
	 * @return [type] [description]
	 */
	public function goodsToTrash(){
		$model = D('Goods');
		$trash_id = I('get.id');
		$data['is_delete'] = "是";
		$data['id'] = $trash_id;
		// $sign = $model->fetchSql(true)->where('id='.$trash_id)->save($data);
		//如果成功放置回收站，则返回success
		if ($model->where('id='.$trash_id)->save($data)!==FALSE) {
			$sign = 'success';
		}else{
			// $sign = $model->getError();
			$sign = $model->getError();
		}
		echo json_encode($sign);
	}
	/**
	 * 展示商品回收站
	 * @return [type] [description]
	 */
	public function goodsTrash(){
		$this->display();
	}
}