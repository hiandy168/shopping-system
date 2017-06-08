<?php
namespace Admin\Controller;
use Think\Controller;
class RoleController extends Controller {
	public function roleList(){
        $Model = D('role');
        $Roledata = $Model->alias('a')
        ->field('a.*,c.pri_name')
        ->join('left join ss_role_pri as b on a.id = b.role_id')
        ->join('left join ss_privilege as c on b.pri_id = c.id')
        ->group('a.id')->select();
        $this->assign([
            'Roledata'=>$Roledata,
            '_page_title'=>"角色列表页",
            '_btn_name'=>"添加角色",
            '_URL_'=>"roleAdd",
        ]);
        $this->display();
	}
	public function roleAdd(){
        $model = D('Role');
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
            // $sign = I('post.pri_id');
            echo json_encode($sign);
        }else{
            $priModel = D('privilege');
            $pri_list = $priModel->where('id > 0')->select();
            $pri_list = $priModel->getLevel($pri_list,0,'id','parent_id','level');
            $this->assign([
                'pri_list'=>$pri_list,
                '_page_title'=>"添加角色页",
                '_btn_name'=>"角色列表",
                '_URL_'=>"roleList",
            ]);
            // var_dump($pri_list);
            $this->display();
        }
	}
    public function roleEdit(){
        $model = D('role');
        //判断是否提交了表单
        if (IS_POST) {
            $id = I('post.id');
            //若表单攻击，修改超级管理员则默认返回
            if($id<=0){
                $sign = "success";
            }else{
                //接收并验证表单,使用I方法过滤表单数据，2指定为更新
                $data = $model->create(I('post.'),2);
                if ($data) {
                    if ($model->where('id = '.$id)->save($data)!==FALSE) {
                        $sign = 'success';
                    }else{
                        $sign = $model->error;
                    }
                }else{
                    $sign = $model->getError();
                }
                // $sign = I('post.');
            }
            echo json_encode($sign);
        }else{
            //要修改信息的角色的ID
            $id = I('get.id');
            $roleModel = D('role');
            $role_detail = $roleModel->where("id = {$id}")->find();//角色detail

            $priModel = D('privilege');
            $pri_list = $priModel->where('id > 0')->select();
            $pri_list = $priModel->getLevel($pri_list,0,'id','parent_id','level');//权限列表

            //获取角色已经拥有的权限列表
            $rpModel = D('role_pri');
            $role_detail_pri_list = $rpModel->field('GROUP_CONCAT(pri_id) as pri_id')->where("role_id = {$id}")->find();
            //分隔组成一维数组
            $role_detail_pri_list = explode(',',$role_detail_pri_list['pri_id']);
            $this->assign([
                'role_detail'=>$role_detail,
                'pri_list'=>$pri_list,
                'role_detail_pri_list'=>$role_detail_pri_list,
                '_page_title'=>"修改角色页",
                '_btn_name'=>"角色列表",
                '_URL_'=>"roleList",
            ]);
            $this->display();
        }
    }
    public function roleDelete(){
        $id = I('get.id');//获取要删除商品的ID
        $model = D('role');
        if($id==1){
            $sign = '无权操作超级管理员';//亦可返回提示消息
        }else{
            if ($model->delete($id)!==FALSE) {
                $sign = 'success';
            }else{
                $sign = $model->getError();
            }
        }
        echo json_encode($sign);
    }
}