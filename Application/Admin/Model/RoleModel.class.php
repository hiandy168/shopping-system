<?php
//第一步：定义命名空间
namespace Admin\Model;
//第二步：引入父类的控制器
use Think\Model;
//第三步：定义模型并且继承父类
class RoleModel extends Model{
	public $error;
	// 是否批处理验证
    protected $patchValidate    =   true;
    //定义添加操作，允许接收的表单字段
	protected $insertFields = 'role_name,pri_id';
    //定义更新操作，允许接收的表单字段
	protected $updateFields = 'id,role_name,pri_id';
	//自定义设置验证规则，$_validate属于父类Model
	protected $_validate = [
		//为表单域定义具体验证规则
		//array(字段名称/表单域name属性值,验证规则,错误提示[,验证条件,附加规则,验证时间])
		//require验证必须存在
		['role_name','require',' * 角色名不能为空！'],
		['role_name','',' * 该角色名已存在！',1,'unique',1],//新增验证角色名唯一
		['role_name','check_role_name',' * 该角色名已存在！',1,'callback',2],//修改验证角色名唯一

	];
	public function check_role_name($arg){
		//查询除了自己这个id的记录中，还有没有同名的记录行
		$sql = 'select role_name from ss_role where id != '.I('post.id')." and role_name = '{$arg}'";
		if($this->db->query($sql)){
			return false;
		}
		return true;
	}
	public function _before_insert(&$data,$option){

	}
	public function _after_insert($data,$option){
		$rpModel = D('role_pri');
		$role_id = $data['id'];
		$pri_ids = I('post.pri_id');
		asort($pri_ids);
		foreach ($pri_ids as $v) {//为空时不会写入
			$rpModel->add([
				'role_id'=>$role_id,
				'pri_id'=>$v,
			]);
		}

	}
	public function _before_update(&$data,$option){

	}
	public function _after_update($data,$option){
		$rpModel = D('role_pri');
		$role_id = $data['id'];
		$pri_ids = I('post.pri_id');
		$rpModel->where([
			'role_id'=>['eq',$role_id]
		])->delete();
		asort($pri_ids);

		foreach ($pri_ids as $v) {
			$rpModel->add([
				'role_id'=>$role_id,
				'pri_id'=>$v,
			]);
		}
	}
	public function _before_delete($option){

	}
	public function _after_delete($option){
		$rpModel = D('role_pri');
		$rpModel->where([
			'role_id' => ['eq', $option['id']],
		])->delete();

		$mrModel = D('manager_role');
		$mrModel->where(array(
			'role_id' => array('eq', $option['id'])
		))->delete();
	}
}