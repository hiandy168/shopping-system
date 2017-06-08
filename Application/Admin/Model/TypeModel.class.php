<?php
//第一步：定义命名空间
namespace Admin\Model;
//第二步：引入父类的控制器
use Think\Model;
//第三步：定义模型并且继承父类
class typeModel extends Model{
	public $error;
	// 是否批处理验证
    protected $patchValidate    =   true;
    //定义添加操作，允许接收的表单字段
	protected $insertFields = 'type_name';
    //定义更新操作，允许接收的表单字段
	protected $updateFields = 'id,type_name';
	//指定包含表前缀的实际表名
	// protected $trueTableName = 'ss_type';
	//自定义设置验证规则，$_validate属于父类Model
	protected $_validate = [
		//为表单域定义具体验证规则
		//array(字段名称/表单域name属性值,验证规则,错误提示[,验证条件,附加规则,验证时间])
		['type_name','require',' * 类型名不能为空',1],
		['type_name','',' * 该类型名已存在！',1,'unique',1],//新增验证类型名唯一
		['type_name','check_type_name',' * 该类型名已存在！',1,'callback',2],//修改验证类型名唯一
	];
	protected function _before_insert(&$data,$option){

	}
	protected function _after_insert($data,$option){

	}
	protected function _before_update(&$data,$option){

	}
	protected function _before_delete($option){
		$attrModel = D('Attribute');
		$attrModel->where([
			'type_id'=>['eq',$option['where']['id']],
		])->delete();
	}
	public function check_type_name($arg){
		//查询除了自己这个id的记录中，还有没有同名的记录行
		$sql = 'select type_name from ss_type where id != '.I('post.id')." and type_name = '{$arg}'";
		if($this->db->query($sql)){
			return false;
		}
		return true;
	}
}