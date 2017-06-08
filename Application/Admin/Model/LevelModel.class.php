<?php
//第一步：定义命名空间
namespace Admin\Model;
//第二步：引入父类的控制器
use Think\Model;
//第三步：定义模型并且继承父类
class LevelModel extends Model{
	public $error;
	// 是否批处理验证
    protected $patchValidate    =   true;
    //定义添加操作，允许接收的表单字段
	protected $insertFields = 'level_name,jifen_top,jifen_bottom';
    //定义更新操作，允许接收的表单字段
	protected $updateFields = 'id,level_name,jifen_top,jifen_bottom';
	//指定包含表前缀的实际表名
	protected $trueTableName = 'ss_member_level';
	//自定义设置验证规则，$_validate属于父类Model
	protected $_validate = [
		//为表单域定义具体验证规则
		//array(字段名称/表单域name属性值,验证规则,错误提示[,验证条件,附加规则,验证时间])
		['level_name','require',' * 会员级别名称不能为空',1],
		['level_name','',' * 该会员级别名称已存在！',1,'unique',1],//新增验证会员级别名称唯一
		['level_name','check_level_name',' * 该会员级别名称已存在！',1,'callback',2],//修改验证会员级别名称唯一
		['jifen_top','require',' * 积分上限不能为空',1],
		['jifen_bottom','require',' * 积分下限不能为空',1],
		['jifen_top','number',' * 积分上限必须是个数字！',1],
		['jifen_bottom','number',' * 积分下限必须是个数字！',1],
		['jifen_bottom','checkTopBottom',' * 积分上限必须比下限大！',1,'callback'],


	];
	protected function _before_insert(&$data,$option){

	}
	protected function _before_update(&$data,$option){

	}
	protected function _after_update($data,$option){

	}
	///彻底删除商品信息前调用此函数
	protected function _before_delete($option){

	}
	//彻底删除商品信息后调用此函数
	protected function _after_delete($option){

	}
	protected function delete_old_jifen_bottom($old_url){

	}
	public function check_level_name($arg){
		//查询除了自己这个id的记录中，还有没有同名的记录行
		$sql = 'select level_name from ss_member_level where id != '.I('post.id')." and level_name = '{$arg}'";
		if($this->db->query($sql)){
			return false;
		}
		return true;
	}
	public function checkTopBottom($arg){
		$top = I('post.jifen_top');
		$bottom = I('post.jifen_bottom');
		if($top>$bottom){
			return true;
		}
		return false;
	}
}