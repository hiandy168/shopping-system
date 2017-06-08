<?php
namespace Admin\Controller;
use Think\Controller;
class TypeController extends Controller{
    public function typeList(){
        $typeModel = D('type');
        $type_list = $typeModel->select();
        $this->assign([
            'type_list'=>$type_list,
            '_page_title'=>"类型列表页",
            '_btn_name'=>"添加类型",
            '_URL_'=>"typeAdd",
        ]);
        $this->display();
    }
    public function typeAdd(){
        $model = D('type');
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
                '_page_title'=>"添加类型页",
                '_btn_name'=>"类型列表",
                '_URL_'=>"typeList",
            ]);
            $this->display();
        }
    }
    public function typeEdit(){
        $model = D('type');
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
            $id = I('get.id');
            $type_detail = $model->where("id = {$id}")->find();
            $this->assign([
                'type_detail'=>$type_detail,
                '_page_title'=>"修改类型页",
                '_btn_name'=>"类型列表",
                '_URL_'=>"typeList",
            ]);
            $this->display();
        }
    }
    public function typeDelete(){
        $model = D('type');
        $delete_id = I('get.id');
        $sign = $model->delete($delete_id);
        if ($model->delete($delete_id)!==FALSE) {
            $sign = 'success';
        }else{
            $sign = $model->error;
        }
        echo json_encode($sign);
    }
}