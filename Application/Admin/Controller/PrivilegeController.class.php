<?php
namespace Admin\Controller;
use Think\Controller;
class PrivilegeController extends Controller {
	public function privilegeList(){
        $priModel = D('privilege');
        $pri_list = $priModel->where('id > 0')->select();
        $pri_list = $priModel->getLevel($pri_list,0,'id','parent_id','level');
        $this->assign([
            'pri_list'=>$pri_list,
            '_page_title'=>"属性列表页",
            '_btn_name'=>"添加属性",
            '_URL_'=>"privilegeAdd",
        ]);
        // var_dump($pri_list);
        $this->display();
	}
	public function privilegeAdd(){
		$model = D('privilege');
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
	        $priModel = D('privilege');
	        $pri_list = $priModel->where('id > 0')->select();
	        $pri_list = $priModel->getLevel($pri_list,0,'id','parent_id','level');
	        $this->assign([
	            'pri_list'=>$pri_list,
	            '_page_title'=>"添加属性页",
	            '_btn_name'=>"属性列表",
	            '_URL_'=>"privilegeList",
	        ]);
			$this->display();
		}
	}
	public function privilegeEdit(){
		$model = D('privilege');
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
			// $sign = I('post.');
			echo json_encode($sign);
		}else{
			$id = I('get.id');
	        $priModel = D('privilege');
	        $pri_list = $priModel->where('id > 0')->select();
	        $pri_list = $priModel->getLevel($pri_list,0,'id','parent_id','level');
			$privilege_detail = $model->where("id = {$id}")->find();
	        $this->assign([
				'privilege_detail'=>$privilege_detail,
	            'pri_list'=>$pri_list,
	            '_page_title'=>"修改属性页",
	            '_btn_name'=>"属性列表",
	            '_URL_'=>"privilegeList",
	        ]);
			$this->display();
		}
	}
	public function privilegeDelete(){
		$id = I('get.id');
        $model = D('privilege');
        if ($model->delete($id)!==FALSE) {
            $sign = 'success';
        }else{
            $sign = $model->getError();
        }
        echo json_encode($sign);
	}
}