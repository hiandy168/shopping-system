<?php
//第一步：定义命名空间
namespace Admin\Model;
//第二步：引入父类的控制器
use Think\Model;
//第三步：定义模型并且继承父类
class ManagerModel extends Model{
	// 是否批处理验证
    protected $patchValidate    =   true;
	//自定义设置验证规则，$_validate属于父类Model
	protected $_validate = [
		//为表单域定义具体验证规则
		//array(字段名称/表单域name属性值,验证规则,错误提示[,验证条件,附加规则,验证时间])
		
		//require验证必须存在
		['username','require','* 用户名不能为空！'],
		['password','require','* 密码不可为空！'],
	];
}