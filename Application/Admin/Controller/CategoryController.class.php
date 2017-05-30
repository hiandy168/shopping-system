<?php
namespace Admin\Controller;
use Think\Controller;
class CategoryController extends CommenController {
	public function categoryList(){
		$catModel = D('category');
		$res = $catModel->select();
		$cat_list = $catModel->getLevel($res,0,'id','parent_id','level');
		$this->assign('cat_list',$cat_list);
		$this->display();
	}
	public function categoryAdd(){
		$model = D('category');
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
			$res = $model->where("is_show='是'")->select();
			$cat_list = $model->getLevel($res,0,'id','parent_id','level');
			$this->assign('cat_list',$cat_list);
			$this->display();
		}
	}
	public function categoryEdit(){
		$model = D('category');
		//判断是否提交了表单
		if (IS_POST) {
			//接收并验证表单,使用I方法过滤表单数据，2指定为更新
			$data = $model->create(I('post.'),2);
			if ($data) {
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
			$res = $model->where("is_show='是'")->select();
			$cat_list = $model->getLevel($res,0,'id','parent_id','level');
			//要修改信息的商品的ID
			$id = I('get.id');
			$category_detail = $model->where("id = {$id}")->find();
			$this->assign([
				'category_detail'=>$category_detail,
				'cat_list'=>$cat_list
			]);
			$this->display();
		}
	}
	public function categoryDelete(){
		$model = D('category');
		$delete_id = I('get.id');
		$sign = $delete_id;
		if ($model->delete($delete_id)!==FALSE) {
			$sign = 'success';
		}else{
			$sign = $model->error;
		}
		echo json_encode($sign);
	}
}