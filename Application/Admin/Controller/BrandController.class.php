<?php
namespace Admin\Controller;
use Think\Controller;
class BrandController extends CommenController {
	public function brandList(){
		//创建会员模型关联member表
		$brandModel = D('brand');
		if (I('get.tar_page')) {
			//以下组装$where的条件
			if (I('get.brand_name')!='') {
				$condition['brand_name'] = I('get.brand_name');
			}
			//获取分页数据
			$res = $brandModel->getLimitData(I('get.tar_page'),I('get.rowsNum'),$condition);
			//将搜索的条件存入session
			session('search',[I('get.tar_page'),I('get.rowsNum'),$condition,I('get.')]);
			echo json_encode($res);
		}else{
			//如果是从编辑页面回来的，则按原查询方式查询，从session中拿回查询条件
			if (I('get.from')=='brandEdit'&&session('search')) {
				$search = session('search');
				//及时删除session，避免初始没有指定查询条件时也读取旧的session条件存在
				$res = $brandModel->getLimitData($search[0],$search[1],$search[2]);
				$search_condition = $search[3];
			}else{
				session('search',null);
				//初始默认显示所有数据的的第一页,（页码、条目）
				$res = $brandModel->getLimitData(1,5);
				$search_condition = 'null';
			}
			$this->assign([
				'pages'=>$res['pages'],
				'brand_list'=>$res['brand_list'],
				'search_condition'=>$search_condition,
                '_page_title'=>"品牌列表页",
                '_btn_name'=>"添加新品牌",
                '_URL_'=>"brandAdd",
			]);
			$this->display();
		}
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
			$this->assign([
				'_page_title'=>"添加品牌页",
                '_btn_name'=>"品牌列表",
                '_URL_'=>"brandList",
			]);
			$this->display();
		}
	}
	public function brandEdit(){
		$model = D('brand');
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
			$brand_detail = $model->where("id = {$id}")->find();
			$this->assign([
				'brand_detail'=>$brand_detail,
                '_page_title'=>"修改品牌页",
                '_btn_name'=>"品牌列表",
                '_URL_'=>"brandList",
			]);
			$this->display();
		}
	}
	public function brandDelete(){
		$model = D('brand');
		$delete_id = I('get.id');
		if ($model->delete($delete_id)!==FALSE) {
			$sign = 'success';
		}else{
			$sign = $model->getError();
		}
		echo json_encode($sign);
	}
}