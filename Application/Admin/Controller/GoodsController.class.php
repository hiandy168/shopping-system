<?php
namespace Admin\Controller;
use Think\Controller;
class GoodsController extends CommenController {
	public function goodsList(){
		$catModel = D('category');
		$res = $catModel->where("is_show='是'")->select();
		$cat_list = $catModel->getLevel($res,0,'id','parent_id','level');
		$this->assign('cat_list',$cat_list);
		$brandModel = D('brand');
		$brand_list = $brandModel->where("is_show='是'")->select();
		$this->assign('brand_list',$brand_list);
		$goodsModel = D('goods');
		$goods_list = $goodsModel->where("is_on_sale='是'")->select();
		$this->assign('goods_list',$goods_list);
		$this->display();
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
			$this->assign('cat_list',$cat_list);
			$brandModel = D('brand');
			$brand_list = $brandModel->where("is_show='是'")->select();
			$this->assign('brand_list',$brand_list);
			$this->display();
		}
	}
}