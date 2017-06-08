<?php
//第一步：定义命名空间
namespace Admin\Model;
//第二步：引入父类的控制器
use Think\Model;
//第三步：定义模型并且继承父类 
class ManagerModel extends Model{
	public $error;
	// 是否批处理验证
    protected $patchValidate    =   true;
	//自定义设置验证规则，$_validate属于父类Model
	protected $_validate = [
		//为表单域定义具体验证规则
		//array(字段名称/表单域name属性值,验证规则,错误提示[,验证条件,附加规则,验证时间])
		
		//require验证必须存在
		['username','require',' * 用户名不能为空！'],
		['username','',' * 该用户名已存在！',1,'unique',1],//新增验证用户名唯一
		['username','check_username',' * 该用户名已存在！',1,'callback',2],//修改验证用户名唯一
		['password','require',' * 密码不可为空！',1],
		['password_check','require',' * 确认密码不可为空！',1],
		['password_check','password',' * 两次密码不一致！',1,'confirm'],//验证密码必须一致

	];
	public function check_username($arg){
		//查询除了自己这个id的记录中，还有没有同名的记录行
		$sql = 'select username from ss_manager where id != '.I('post.id')." and username = '{$arg}'";
		if($this->db->query($sql)){
			return false;
		}
		return true;
	}
	public function _before_insert(&$data,$option){
		//插入前对密码加密
		$data['password'] = md5($data['password']);
	}
	public function _after_insert($data,$option){
		$mrModel = D('manager_role');
		$manager_id = $data['id'];
		$role_ids = array_unique(I('post.role_id'));
		asort($role_ids);
		foreach ($role_ids as $v) {
			if($v!=false){
				$mrModel->add([
					'manager_id'=>$manager_id,
					'role_id'=>$v,
				]);
			}
		}
	}
	public function _before_update(&$data,$option){
		//插入前对密码加密
		$data['password'] = md5($data['password']);
	}
	public function _after_update($data,$option){
		$mrModel = D('manager_role');
		$manager_id = $data['id'];
		$mrModel->where([
			'manager_id'=>['eq',$manager_id]
		])->delete();
		$role_ids = array_unique(I('post.role_id'));
		asort($role_ids);
		foreach ($role_ids as $v) {
			if($v!=false){
				$mrModel->add([
					'manager_id'=>$manager_id,
					'role_id'=>$v,
				]);
			}
		}
	}
	public function _before_delete($option){

	}
	public function _after_delete($option){
		$mrModel = D('manager_role');
		$mrModel->where([
			'manager_id' => ['eq', $option['id']],
		])->delete();
	}
}