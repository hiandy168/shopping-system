<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends CommenController {
	public function userList(){
		//创建会员模型关联member表
		$userModel = D('user');
		if (I('get.tar_page')) {
			//以下组装$where的条件
			if (I('get.username')!='') {
				$condition['username'] = I('get.username');
			}
			//获取分页数据
			$res = $userModel->getLimitData(I('get.tar_page'),I('get.rowsNum'),$condition);
			//将搜索的条件存入session
			session('search',[I('get.tar_page'),I('get.rowsNum'),$condition,I('get.')]);
			echo json_encode($res);
		}else{
			//如果是从编辑页面回来的，则按原查询方式查询，从session中拿回查询条件
			if (I('get.from')=='userEdit'&&session('search')) {
				$search = session('search');
				//及时删除session，避免初始没有指定查询条件时也读取旧的session条件存在
				$res = $userModel->getLimitData($search[0],$search[1],$search[2]);
				$search_condition = $search[3];
			}else{
				session('search',null);
				//初始默认显示所有数据的的第一页,（页码、条目）
				$res = $userModel->getLimitData(1,5);
				$search_condition = 'null';
			}
			$this->assign([
				'pages'=>$res['pages'],
				'user_list'=>$res['user_list'],
				'search_condition'=>$search_condition,
			]);
			$this->display();
		}
	}
	public function userAdd(){
		//判断是否提交了表单
		if (IS_POST) {
			$model = D('user');
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
			$this->display();
		}
	}
	public function userEdit(){
		$model = D('user');
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
			$user_detail = $model->where("id = {$id}")->find();
			$this->assign([
				'user_detail'=>$user_detail,
			]);
			$this->display();
		}
	}
	public function userDelete(){
		$model = D('user');
		$delete_id = I('get.id');
		if ($model->delete($delete_id)!==FALSE) {
			$sign = 'success';
		}else{
			$sign = $model->getError();
		}
		echo json_encode($sign);
	}
}