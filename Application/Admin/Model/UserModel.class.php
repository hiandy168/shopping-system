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
		/*********插入图片前先处理图片*********/
		if($_FILES['face']['error']===0){//error为0表示上传了文件
			//调用自定义函数验证图片文件并上传原图
			$res = $this->checkFile($_FILES['face']);
			//如果原图上传失败则返回错误信息
			if (!$res) {
				return false;
			}else{
				//imageUrl自定义函数上传缩略图
				$resz = $this->imageUrl($res);
			}
			$data['face'] = $res;
			$data = array_merge($data,$resz);
		}
		//插入前对密码加密
		$data['password'] = md5($data['password']);
	}
	protected function _before_update(&$data,$option){
		/*********在更新信息之前先处理图片*********/
		if($_FILES['face']['error']===0){//error为0表示上传了文件
			//如果上传了新文件，就删除旧文件，这里先存储路径信息
			//可选择是否删除原来的logo图，一般删除，节省磁盘空间
			$oldface = $this->field('face,sm_face')->where('id='.$data['id'])->find();
			session('old_face_update',$oldface);

			//调用自定义函数验证图片文件并上传原图
			$res = $this->checkFile($_FILES['face']);
			//如果原图上传失败则返回错误信息
			if (!$res) {
				return false;
			}else{
				//imageUrl自定义函数上传缩略图
				$resz = $this->imageUrl($res);
			}
			$data['face'] = $res;
			$data = array_merge($data,$resz);
		}
		//插入前对密码加密
		$data['password'] = md5($data['password']);
	}
	protected function _after_update($data,$option){
		$old_face_url = session('old_face_update');
		$this->delete_old_face($old_face_url);
	}
	///彻底删除商品信息前调用此函数
	protected function _before_delete($option){
		//从数据库删除数据前，先将图片路径存入session
		$oldface = $this->field('face,sm_face')->where('id='.$option['where']['id'])->find();
		session('old_face_delete',$oldface);
	}
	//彻底删除商品信息后调用此函数
	protected function _after_delete($option){
		//如果session中有就文件路径信息，就删掉
		if (session('old_face_delete')) {
			//商品的信息已经从数据库删除，然后再从session拿回图片路径，删除服务器中的图片
			$old_url = session('old_face_delete');
			session('old_face_delete',null);//用完即删
			$this->delete_old_face($old_url);
		}
	}
	protected function delete_old_face($old_url){
		$keys = array_keys($old_url);
		for ($i=0; $i < count($keys); $i++) {
			unlink($old_url["{$keys[$i]}"]);
		}
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
			'pages'      =>  $pages,
			'user_list' =>  $user_list,
		];
	}
	/**
	 * 调用自定义函数验证图片文件并上传原图
	 * @param  [array] $uploadfile [上传的文件]
	 * @return [type]             [description]
	 */
	private function checkFile($uploadfile){
		$arg = [
			'maxSize'       =>  1024*1024, //上传的文件大小限制1M
        	'exts'          =>  array('jpg','png','gif','jpeg'), //允许上传的文件后缀
        	'subName'       =>  array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
        	'rootPath'      =>  'Public/Uploads/', //保存根目录
        	'savePath'		=>	'user/',//附件上传子目录
		];
		$file = new \Think\Upload($arg);
		//上传原图并保存
		$res = $file->uploadOne($uploadfile);
		if ($res) {
			//返回完整路径
			return $arg['rootPath'].$res['savepath'].$res['savename'];
		}else{
			$this->error['face'] = $file->getError();
			return false;
		}
	}

	/**
	 * 根据上传图片的临时路径生成缩略图并保存
	 * @param  string $imgurl [上传原图的完整路径]
	 * @return array          [原图和缩略图的路径]
	 */
	private function imageUrl($imgurl){
		$dirname = dirname($imgurl);
		$filename = basename($imgurl);
		//加载框架图片处理类
		$image = new \Think\Image();
		//指定缩略图片保存路径
		$data['sm_face'] = $dirname.'/thumb_sm_'.$filename;
		//thumb保存缩略图
		$image->open($imgurl);
		$image->thumb(30,30)->save($data['sm_face']);
		//返回缩略图的路径
		return $data;
	}
}