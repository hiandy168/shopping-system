<?php
namespace Admin\Controller;
use Think\Controller;
class ManagerController extends CommenController {
    public function ManagerList(){
        $Model = D('Manager');
        $Managerdata = $Model->alias('a')
        ->field('a.*,GROUP_CONCAT(c.role_name) as manager_role')
        ->join('left join ss_manager_role as b on a.id = b.manager_id')
        ->join('left join ss_role as c on b.role_id = c.id')
        ->group('a.id')->select();
        $this->assign([
            'Managerdata'=>$Managerdata,
            '_page_title'=>"管理员列表页",
            '_btn_name'=>"添加管理员",
            '_URL_'=>"managerAdd",
        ]);
        $this->display();
    }
    public function ManagerAdd(){
        $model = D('Manager');
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
            // $sign = array_unique(I('post.role_id'));
            echo json_encode($sign);
        }else{
            $roleModel = D('role');
            $role_list = $roleModel->where('id > 0')->select();
            $this->assign([
                'role_list'=>$role_list,
                '_page_title'=>"添加管理员页",
                '_btn_name'=>"管理员列表",
                '_URL_'=>"managerList",
            ]);
            $this->display();
        }
    }
    public function ManagerEdit(){
        $model = D('manager');
        //判断是否提交了表单
        if (IS_POST) {
            $id = I('post.id');
            if($id==1){
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
            }
            echo json_encode($sign);
        }else{
            $mrModel = D('manager_role');
            $roleModel = D('role');
            //要修改信息的管理员的ID
            $id = I('get.id');
            $manager_detail = $model->where("id = {$id}")->find();
            $manager_detail_role_ids = $mrModel->where("manager_id = {$id} and role_id != 0")->select();
            $role_list = $roleModel->where('id > 0')->select();
            $this->assign([
                'manager_detail'=>$manager_detail,
                'manager_detail_role_ids'=>$manager_detail_role_ids,
                'role_list'=>$role_list,
                '_page_title'=>"修改管理员页",
                '_btn_name'=>"管理员列表",
                '_URL_'=>"managerList",
            ]);
            $this->display();
        }
    }
    public function ManagerDelete(){
        $model = D('manager');
        $id = I('get.id');
        if($id==1){
            $sign = '超级管理员root不能删除';
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