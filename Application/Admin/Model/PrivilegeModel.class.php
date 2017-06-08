<?php
//第一步：定义命名空间
namespace Admin\Model;
//第二步：引入父类的控制器
use Think\Model;
//第三步：定义模型并且继承父类
class PrivilegeModel extends Model{
	public $error;
	// 是否批处理验证
    protected $patchValidate    =   true;
    //定义添加操作，允许接收的表单字段
	protected $insertFields = 'pri_name,module_name,controller_name,action_name,parent_id';
    //定义更新操作，允许接收的表单字段
	protected $updateFields = 'id,pri_name,module_name,controller_name,action_name,parent_id';
	//指定包含表前缀的实际表名
	// protected $trueTableName = 'ss_pri';
	//自定义设置验证规则，$_validate属于父类Model
	protected $_validate = [
		//为表单域定义具体验证规则
		//array(字段名称/表单域name属性值,验证规则,错误提示[,验证条件,附加规则,验证时间])
		['pri_name','require',' * 权限名称不能为空！',1],
		['pri_name','',' * 权限名称已存在！',1,'unique',1],
		['pri_name','check_pri_name',' * 权限名称已存在！',1,'callback',2],
		['module_name','require',' * 模块名称不能为空！',1],
		['controller_name','require',' * 控制器名称不能为空！',1],
		['action_name','require',' * 方法名称不能为空！',1],
		['module_name', '1,30', '模块名称的值最长不能超过 30 个字符！', 2, 'length', 3],
		['controller_name', '1,30', '控制器名称的值最长不能超过 30 个字符！', 2, 'length', 3],
		['action_name', '1,30', '方法名称的值最长不能超过 30 个字符！', 2, 'length', 3],
		['parent_id', 'number', '上级权限Id必须是一个数字！', 2, 'regex', 3],
	];
	protected function _before_insert(&$data,$option){

	}
	protected function _after_insert($data,$option){

	}
	protected function _before_update(&$data,$option){
		$update_id = $data['id'];
		$update_parent_id = $data['parent_id'];
		$ids_data = $this->select();
		$res_ids = $this->getLevelId($ids_data,$update_id,'id','parent_id');//获取当前权限的id和子权限id
		if(in_array($update_parent_id,$res_ids)){
			$this->error = ['parent_id'=>'权限更新失败！！不可将当前权限或当前权限的子类作为其上级权限！'];
			return false;
		}
	}
	protected function _after_update($data,$option){

	}
	protected function _before_delete($option){
		$ids_data = $this->select();
		$update_id = $option['where']['id'];
		$res_ids = $this->getLevelId($ids_data,$update_id,'id','parent_id');
		if(count($res_ids)>1){//大于1表示出了自己的id，还有子id
			$this->error = '权限删除失败！！当前权限还有子权限，无法删除！';
			return false;
		}
	}
	protected function _after_delete($option){
		// 从中间表中把这个权限相关的数据删除
		$rpModel = D('role_pri');
		$rpModel->where(array(
			'pri_id' => array('eq', $option['id'])
		))->delete();
	}
	public function check_pri_name($arg){
		//查询除了自己这个id的记录中，还有没有同名的记录行
		$sql = 'select pri_name from ss_privilege where id != '.I('post.id')." and pri_name = '{$arg}'";
		if($this->db->query($sql)){
			return false;
		}
		return true;
	}
	//将权限数据根据parent_id分层级
	public function getLevel($data,$id,$field_id,$field_pid,$field_level){
		$levels = new \Think\Level();
		$levels -> classify($data,$id,$field_id,$field_pid,$field_level,$res);
		return $res;
	}
	//获取指定权限的id及其子类id
	public function getLevelId($data,$subId,$field_id,$field_pid){
		$levels = new \Think\Level();
		$res = $levels -> getSubId($data,$subId,$field_id,$field_pid);
		//返回当前权限的ID及其子ID的数组信息
		return $res;
	}
	/**
	 * 检查当前管理员是否有权限访问这个页面
	 */
	public function chkPri(){
		// 获取当前管理员正要访问的模型名称、控制器名称、方法名称
		// tP中正带三个常量
		//MODULE_NAME , CONTROLLER_NAME , ACTION_NAME
		$managerId = session('id');
		// 如果是超级管理员直接返回 TRUE
		if($managerId == 1)
			return TRUE;
		$arModel = D('manager_role');
		//返回管理员是否拥有权限
		$has = $arModel->alias('a')
		->join('LEFT JOIN ss_role_pri as b ON a.role_id=b.role_id 
		        LEFT JOIN ss_privilege as c ON b.pri_id=c.id')
		->where(array(
			'a.manager_id' => array('eq', $managerId),
			'c.module_name' => array('eq', MODULE_NAME),
			'c.controller_name' => array('eq', CONTROLLER_NAME),
			'c.action_name' => array('eq', ACTION_NAME),
		))->count();
		return ($has > 0);
	}
	/**
	 * 获取当前管理员所拥有的前两级的权限
	 *
	 */
	public function getBtns(){
		/*************** 先取出当前管理员所拥有的所有的权限 ****************/
		$managerId = session('id');
		if($managerId == 1){
			$priModel = D('Privilege');
			$priData = $priModel->select();
		}else{
			// 取出当前管理员所在角色 所拥有的权限
			$arModel = D('manager_role');
			$priData = $arModel->alias('a')
			->field('DISTINCT c.id,c.pri_name,c.module_name,c.controller_name,c.action_name,c.parent_id')
			->join('LEFT JOIN ss_role_pri as b ON a.role_id=b.role_id 
			        LEFT JOIN ss_privilege as c ON b.pri_id=c.id')
			->where(array(
				'a.manager_id' => array('eq', $managerId),
			))->select();
		}
		/*************** 从所有的权限中挑出前两级的 **********************/
		$btns = array();  // 前两级权限
		foreach ($priData as $k => $v){
			if($v['parent_id'] == 0){
				// 再找这个顶的子级
				foreach ($priData as $k1 => $v1){
					if($v1['parent_id'] == $v['id']){
						$v['children'][] = $v1;
					}
				}
				$btns[] = $v;
			}
		}
		return $btns;
	}
}