<?php
namespace Admin\Controller;
use Think\Controller;
class BrandController extends CommenController {
	public function brandList(){
		$brandModel = D('brand');
		$brand_list = $brandModel->where("is_show='是'")->select();
		$this->assign('brand_list',$brand_list);
		$this->display();
	}
	public function brandAdd(){
		$model = D('brand');
		//判断是否提交了表单
		if (IS_POST) {
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
			$brand_list = $model->where("is_show='是'")->select();
			$this->assign([
				'brand_list'=> $brand_list,
			]);
			$this->display();
		}
	}
}