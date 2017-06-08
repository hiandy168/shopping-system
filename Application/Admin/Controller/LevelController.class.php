<?php
namespace Admin\Controller;
use Think\Controller;
class LevelController extends CommenController {
	public function levelList(){
		$mlModel = D('member_level');
		$mlData = $mlModel->select();
		$this->assign([
			'mlData'=>$mlData,
            '_page_title'=>"会员级别列表页",
            '_btn_name'=>"添加会员级别",
            '_URL_'=>"levelAdd",
		]);
		$this->display();
	}
	public function levelAdd(){
		$model = D('level');
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
			// $sign = I('post.');
			echo json_encode($sign);
		}else{
			$this->assign([
	            '_page_title'=>"添加会员级别页",
	            '_btn_name'=>"会员级别列表",
	            '_URL_'=>"levelList",
			]);
			$this->display();
		}
	}
	public function levelEdit(){
		$model = D('level');
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
			//要修改信息的商品的ID
			$id = I('get.id');
			$level_detail = $model->where("id = {$id}")->find();
			$this->assign([
				'level_detail'=>$level_detail,
	            '_page_title'=>"修改会员级别页",
	            '_btn_name'=>"会员级别列表",
	            '_URL_'=>"levelList",
			]);
			$this->display();
		}
	}
	public function  levelDelete(){
		$mlModel = D('member_level');
		$delete_id = I('get.id');
		if ($mlModel->delete($delete_id)!==FALSE) {
			$sign = 'success';
		}else{
			$sign = $mlModel->error;
		}
		echo json_encode($sign);
	}
}