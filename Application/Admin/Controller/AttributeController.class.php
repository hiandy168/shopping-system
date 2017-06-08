<?php
namespace Admin\Controller;
use Think\Controller;
class AttributeController extends Controller{
    public function attributeList(){
        $model = D('attribute');
        if(I('get.act')=='search'){
            //以下组装$where的条件
            if (I('get.attr_name')!='') {
                $condition['attr_name'] = I('get.attr_name');
            }
            if (I('get.type_id')!='') {
                $condition['type_id'] = I('get.type_id');
            }
            if (I('get.attr_type')=='0') {
                $condition['attr_type'] = '唯一';
            }elseif(I('get.attr_type')=='1'){
                $condition['attr_type'] = '可选';
            }
            $sign['attribute_list'] = $model->where($condition)->select();
            echo json_encode($sign);
        }else{
            $type_id = I('get.type_id');
            if($type_id!=''){
                $condition = ['type_id'=>['eq',$type_id]];
            }else{
                $condition = '';
            }
            $attributeModel = D('attribute');
            $attribute_list = $attributeModel->where($condition)->select();
            $this->assign([
                'attribute_list'=>$attribute_list,
                'type_id'=>$type_id,
                '_page_title'=>"属性列表页",
                '_btn_name'=>"添加新属性",
                '_URL_'=>"attributeAdd",
            ]);
            $this->display();
        }
    }
    public function attributeAdd(){
        $model = D('attribute');
        $type_id = I('get.type_id');
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
            $typeModel = D('type');
            $type_list = $typeModel->select();
            $this->assign([
                'type_list'=>$type_list,
                'type_id'=>$type_id,
                '_page_title'=>"添加属性页",
                '_btn_name'=>"属性列表",
                '_URL_'=>"attributeList",
            ]);
            $this->display();
        }
    }
    public function attributeEdit(){
        $model = D('attribute');
        $type_id = I('get.type_id');
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
            $attribute_detail = $model->where("id = {$id}")->find();
            $typeModel = D('type');
            $type_list = $typeModel->select();
            $this->assign([
                'attribute_detail'=>$attribute_detail,
                'type_id'=>$type_id,
                'type_list'=>$type_list,
                '_page_title'=>"修改属性页",
                '_btn_name'=>"属性列表",
                '_URL_'=>"attributeList",
            ]);
            $this->display();
        }
    }
    public function attributeDelete(){
        $model = D('attribute');
        $delete_id = I('get.id');
        if ($model->delete($delete_id)!==FALSE) {
            $sign = 'success';
        }else{
            $sign = $model->error;
        }
        echo json_encode($sign);
    }
}