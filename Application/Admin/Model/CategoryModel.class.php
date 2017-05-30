<?php
//第一步：定义命名空间
namespace Admin\Model;
//第二步：引入父类的控制器
use Think\Model;
//第三步：定义模型并且继承父类
class CategoryModel extends Model{
	public $error;
	// 是否批处理验证
    protected $patchValidate    =   true;
    //定义添加操作，允许接收的表单字段
	protected $insertFields = 'cat_name,parent_id,is_show,is_floor,sort_num,keywords';
    //定义更新操作，允许接收的表单字段
	protected $updateFields = 'id,cat_name,parent_id,is_show,is_floor,sort_num,keywords';
	//指定包含表前缀的实际表名
	// protected $trueTableName = 'ss_cat';
	//自定义设置验证规则，$_validate属于父类Model
	protected $_validate = [
		//为表单域定义具体验证规则
		//array(字段名称/表单域name属性值,验证规则,错误提示[,验证条件,附加规则,验证时间])
		['cat_name','require',' * 分类名不能为空',1],
		['cat_name','',' * 该分类名已存在！',1,'unique',1],//新增验证分类名唯一
		['cat_name','check_cat_name',' * 该分类名已存在！',1,'callback',2],//修改验证分类名唯一
	];
	protected function _before_insert(&$data,$option){

	}
	protected function _after_insert($data,$option){

	}
	protected function _before_update(&$data,$option){
		$ids_data = $this->select();
		$update_id = $data['id'];
		$update_parent_id = $data['parent_id'];
		$res_ids = $this->getLevelId($ids_data,$update_id,'id','parent_id');
		$this->error = [$data];
		if(in_array($update_parent_id,$res_ids)){
			$this->error = '商品分类更新失败！！不可将当前分类或当前分类的子类作为其上级分类！';
			return false;
		}
	}
	protected function _before_delete($option){
		$ids_data = $this->select();
		$update_id = $option['where']['id'];
		$res_ids = $this->getLevelId($ids_data,$update_id,'id','parent_id');
		if(count($res_ids)>1){
			$this->error = '商品分类删除失败！！当前分类还有子分类，无法删除！';
			return false;
		}
	}
	public function check_cat_name($arg){
		//查询除了自己这个id的记录中，还有没有同名的记录行
		$sql = 'select cat_name from ss_category where id != '.I('post.id')." and cat_name = '{$arg}'";
		if($this->db->query($sql)){
			return false;
		}
		return true;
	}
	//将分类数据根据parent_id分层级
	public function getLevel($data,$id,$field_id,$field_pid,$field_level){
		$levels = new \Think\Level();
		$levels -> classify($data,$id,$field_id,$field_pid,$field_level,$res);
		return $res;
	}
	//获取指定分类的id及其子类id
	public function getLevelId($data,$subId,$field_id,$field_pid){
		$levels = new \Think\Level();
		$res = $levels -> getSubId($data,$subId,$field_id,$field_pid);
		//返回当前分类的ID及其子ID的数组信息
		return $res;
	}
}