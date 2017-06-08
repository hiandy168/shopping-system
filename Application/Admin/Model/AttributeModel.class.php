<?php
//第一步：定义命名空间
namespace Admin\Model;
//第二步：引入父类的控制器
use Think\Model;
//第三步：定义模型并且继承父类
class attributeModel extends Model{
	public $error;
	// 是否批处理验证
    protected $patchValidate    =   true;
	protected $insertFields = ['attr_name','attr_type','attr_option_values','type_id'];
	protected $updateFields = ['id','attr_name','attr_type','attr_option_values','type_id'];
	protected $_validate = [
		['attr_name', 'require', '属性名称不能为空！', 1, 'regex', 3],
		['attr_name', '1,30', '属性名称的值最长不能超过 30 个字符！', 1, 'length', 3],
		['attr_type', 'require', '属性类型不能为空！', 1, 'regex', 3],
		['attr_type', '唯一,可选', "属性类型的值只能是在 '唯一,可选' 中的一个值！", 1, 'in', 3],
		['attr_option_values', '1,300', '属性可选值的值最长不能超过 300 个字符！', 2, 'length', 3],
		['type_id', 'require', '所属类型Id不能为空！', 1, 'regex', 3],
		['type_id', 'number', '所属类型Id必须是一个整数！', 1, 'regex', 3],
		['attr_name','check_attr_name_add',' * 该类型已存在该属性！',1,'callback',1],//新增验证属性名唯一
		['attr_name','check_attr_name_edit',' * 该类型已存在该属性！',1,'callback',2],//修改验证属性名唯一
	];
	// 添加前
	protected function _before_insert(&$data, $option){
		$data['attr_option_values'] = str_replace('，',',',$data['attr_option_values']);
	}
	// 修改前
	protected function _before_update(&$data, $option){
		
	}
	// 删除前
	protected function _before_delete($option){

	}
	/************************************ 其他方法 ********************************************/
	public function check_attr_name_add($arg){
		//查询同一type_id的记录中，还有没有同名的属性
		$sql = 'select attr_name from ss_attribute where type_id = '.I('post.type_id')." and attr_name = '{$arg}'";
		if($this->db->query($sql)){
			return false;
		}
		return true;
	}
	public function check_attr_name_edit($arg){
		//查询除了自己这个id的记录中，还有没有同名的记录行
		$sql = 'select attr_name from ss_attribute where id != '.I('post.id')." and type_id = ".I('post.type_id')." and attr_name = '{$arg}'";
		if($this->db->query($sql)){
			return false;
		}
		return true;
	}
}