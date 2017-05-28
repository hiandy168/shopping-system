<?php
//第一步：定义命名空间
namespace Admin\Model;
//第二步：引入父类的控制器
use Think\Model;
//第三步：定义模型并且继承父类
class UserModel extends Model{
	public $error;
	// 是否批处理验证
    protected $patchValidate    =   true;
    //定义添加操作，允许接收的表单字段
	protected $insertFields = 'username,password,face,jifen,password_check';
    //定义更新操作，允许接收的表单字段
	protected $updateFields = 'id,username,password,face,jifen,password_check';
	//指定包含表前缀的实际表名
	protected $trueTableName = 'ss_member';
	//自定义设置验证规则，$_validate属于父类Model
	protected $_validate = [
		//为表单域定义具体验证规则
		//array(字段名称/表单域name属性值,验证规则,错误提示[,验证条件,附加规则,验证时间])
		['username','require',' * 用户名不能为空',1],
		['username','',' * 该用户名已存在！',1,'unique',1],//新增验证用户名唯一
		['username','check_username',' * 该用户名已存在！',1,'callback',2],//修改验证用户名唯一
		['password','require',' * 密码不能为空！',1],
		['password_check','password',' * 两次密码不一致！',1,'confirm'],//验证密码必须一致

	];
	protected function _before_insert(&$data,$option){
		//插入前对密码加密
		$data['password'] = md5($data['password']);
	}
	public function check_username($arg){
		//查询除了自己这个id的记录中，还有没有同名的记录行
		$sql = 'select username from ss_member where id != '.I('post.id')." and username = '{$arg}'";
		if($this->db->query($sql)){
			return false;
		}
		return true;
	}
	/**
	 * [getLimitData description]
	 * @param  integer $tar_page  目标页码
	 * @param  integer $rowsNum   每页条目
	 * @param  string  $condition $where查询条件
	 * @param  string  $order     $order查询条件
	 * @return [type]             返回数据，包括页码和查询的数据
	 */
	public function getLimitData($tar_page=1,$rowsNum=5,$condition=[]){
		//总记录行数
		$totalRows = $this->where($condition)->count();
		//获取分页类模型
		$fenye = new \Think\Fenye();
		//获取分页页码
		$pages = $fenye->getPageNumber($totalRows,$tar_page,$rowsNum);
		//分页查询
		$user_list = $this->where($condition)->limit($pages['firstRows'],$pages['rowsNum'])->select();
		return [
			'totalRows' => $totalRows,
			'pages'      =>  $pages,
			'user_list' =>  $user_list,
		];
	}
}