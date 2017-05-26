<?php
namespace Admin\Controller;
use Think\Controller;
class GoodsController extends CommenController {
	public function goodsList(){
		$goodsModel = D('goods');
		if (isset($_GET['tar_page'])) {
			//以下组装$where的条件
			if (I('get.cat_id')!=='0') {
				$condition['cat_id'] = I('get.cat_id');
			}
			if (I('get.brand_id')!=='0') {
				$condition['brand_id'] = I('get.brand_id');
			}
			if (I('get.intro_type')!=='is_all') {
				$condition[I('get.intro_type')] = '是';
			}
			if (I('get.is_on_sale')!=='is_all') {
				$condition['is_on_sale'] = I('get.is_on_sale')?'是':'否';
			}
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
			if (I('get.price_order')=='price_desc') {
				$order = 'shop_price desc';
			}elseif(I('get.price_order')=='price_asc'){
				$order = 'shop_price asc';
			}
			if(I('get.time_start')!=''&&I('get.time_end')!=''){
				$start = I('get.time_start');
				$end = I('get.time_end');
				$sql = "unix_timestamp(addtime) between unix_timestamp('{$start}') and unix_timestamp('{$end}')";
			}elseif(I('get.time_start')!=''){
				$start = I('get.time_start');
				$sql = "unix_timestamp(addtime) >= unix_timestamp('{$start}')";
			}elseif(I('get.time_end')!=''){
				$end = I('get.time_end');
				$sql = "unix_timestamp(addtime) <= unix_timestamp('{$end}')";
			}
			//获取分页数据
			$res = $goodsModel->getLimitData(I('get.tar_page'),I('get.rowsNum'),$condition,$order,$sql);
			echo json_encode($res);
		}else{
			//初始默认显示所有数据的的第一页
			$res = $goodsModel->getLimitData(1,9);
			//以下获取总的品牌和分类列表用户显示在搜索栏
			$catModel = D('category');
			$catres = $catModel->where("is_show='是'")->select();
			$cat_list = $catModel->getLevel($catres,0,'id','parent_id','level');
			$brandModel = D('brand');
			$brand_list = $brandModel->where("is_show='是'")->select();
			$this->assign([
				'goods_list' =>	$res['goods_list'],
				'pages'		 =>	$res['pages'],
				'cat_list'	 => $cat_list,
				'brand_list' => $brand_list
			]);
			$this->display();
		}
	}	
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
			$this->assign([
				'brand_list'=> $brand_list,
				'cat_list'	=> $cat_list
			]);
			$this->display();
		}
	}
}