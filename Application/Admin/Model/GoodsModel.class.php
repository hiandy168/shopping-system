<?php
//第一步：定义命名空间
namespace Admin\Model;
//第二步：引入父类的控制器
use Think\Model;
//第三步：定义模型并且继承父类
class GoodsModel extends Model{
	public $error;
	// 是否批处理验证
    protected $patchValidate    =   true;
    //定义添加操作，允许接收的表单字段
	protected $insertFields = 'goods_name,goods_sn,cat_id,brand_id,market_price,shop_price,is_on_sale,goods_desc,is_best,is_new,is_hot,sort_order,keywords,goods_img,goods_number,sort_num,member_price,type_id,promote_price,promote_start_date,promote_end_date';
    //定义更新操作，允许接收的表单字段
	protected $updateFields = 'id,goods_name,goods_sn,cat_id,brand_id,market_price,shop_price,is_on_sale,goods_desc,is_best,is_new,is_hot,sort_order,keywords,goods_img,goods_number,sort_num,member_price,type_id,promote_price,promote_start_date,promote_end_date';

	//自定义设置验证规则，$_validate属于父类Model
	protected $_validate = [
		//为表单域定义具体验证规则
		//array(字段名称/表单域name属性值,验证规则,错误提示[,验证条件,附加规则,验证时间])
		
		//require验证必须存在，条件1必须验证
		['goods_name','require',' * 所以您卖的是叫啥！',1],
		//条件1必须验证，验证时间1代表新增时才验证数据
		['goods_name','',' * 商品名称居然都能重复！',1,'unique',1],
		//条件0存在字段则验证，验证时间1代表新增时才验证数据
		['goods_sn','',' * 该货号已存在！',0,'unique',1],
		//若存在字段则验证，货号长度需小于等于13位，跟从数据库设计的要求
		['goods_sn','0,13',' * 货号格式或长度不合适！',0,'length'],
		//验证店铺价格必须存在，条件1必须验证
		['shop_price','require',' * 您是要送给别人么！',1],
		//验证店铺价格应是货币格式，1设定为必须验证
		['shop_price','currency',' * 您知道这并不是一个价格！',1],
		//验证市场价格应是货币格式
		['market_price','currency',' * 您知道这并不是一个价格！',2],
		//验证促销价格应是货币格式
		['promote_price','currency',' * 您知道这并不是一个价格！',2],
		//验证库存数量应是数字
		['goods_number','number',' * 商品数量应该是个数字',2],
		//验证分类选择不能是0
		['cat_id',0,' * 你必须选择一种分类',1,'notequal'],
		//条件2代表不为空时调用函数验证，验证时间2代表编辑时才验证数据
		['goods_sn','check_good_sn',' * 该货号重复了！',2,'callback',2],
		//条件2代表不为空时调用函数验证，验证时间2代表编辑时才验证数据
		['goods_name','check_good_name',' * 该名称重复了！',2,'callback',2],
	];
	public function check_good_sn($arg){
		//定义规则，如果修改的货号已存在，则返回false
		//要排除自己，因为如果没做修改，表单照样接收，验证会跟自己重复
		$sql = 'select goods_sn from ss_goods where id != '.I('post.id')." and goods_sn = '{$arg}'";
		if($this->db->query($sql)){
			return false;
		}
		return true;
	}
	public function check_good_name($arg){
		//查询除了自己这个id的记录中，还有没有同名的记录行
		$sql = 'select goods_name from ss_goods where id != '.I('post.id')." and goods_name = '{$arg}'";
		if($this->db->query($sql)){
			return false;
		}
		return true;
	}
	//这个方法会在执行数据insert前自动调用
	protected function _before_insert(&$data,$option){
		/*********插入图片前先处理图片*********/
		if($_FILES['logo']['error']===0){//error为0表示上传了文件
			//调用自定义函数验证图片文件并上传原图
			$res = $this->checkFile($_FILES['logo']);
			//如果原图上传失败则返回错误信息
			if (!$res) {
				return false;
			}else{
				//imageUrl自定义函数上传缩略图
				$resz = $this->imageUrl($res);
			}
			$data['logo'] = $res;
			$data = array_merge($data,$resz);
		}
		//给商品信息加上时间
		$data['addtime'] = date('Y-m-d H:i:s',time());
		//调用自定义的防止XSS注入的函数过滤出HTML代码，此函数包含了htmlpurifier插件包
		$data['goods_desc'] = removeXSS($_POST['goods_desc']);
		$data['goods_sn'] = I('post.goods_sn')!=false?I('post.goods_sn'):time();
	}
	//商品信息添加成功之后，会自动调用此方法，其中$data['id']就是新商品的id
	//要调用此方法，数据的主键ID不能是复合主键，Model父类中的add方法中有定义
	protected function _after_insert($data,$option){
		/*****************处理会员价格信息****************/
		//先获取表单中的会员价格信息
		$mp = I('post.member_price');
		$mpModel = M('member_price');
		foreach ($mp as $k => $v) {
			//将用户的输入永远转化为浮点型，非数字转化为0
			//这里用框架没有很好的方法去验证，因为member_price是个数组
			$_v = (float)$v;
			//如果有价格则写入此价格
			if($_v>0){
				$mpModel->add([
					'price'=>$v,
					'level_id'=>$k,
					'goods_id'=>$data['id'],
				]);
			}else{
				//如果有会员价格没填，则默认为店铺价
				$mpModel->add([
					'price'=>$data['shop_price'],
					'level_id'=>$k,
					'goods_id'=>$data['id'],
				]);
			}
		}
		/************ 处理扩展分类 ***************/
		$ecid = I('post.ext_cat_id');
		if($ecid){
			$gcModel = D('goods_cat');
			// 去重
			$ecid = array_unique($ecid);
			foreach ($ecid as $k => $v){
				if($v==0)
					continue ;
				$gcModel->add([
					'cat_id' => $v,
					'goods_id' => $data['id'],
				]);
			}
		}
		/************ 处理相册图片 *****************/
		if(isset($_FILES['pic'])){
			$gpModel = D('goods_pic');
			$pics = array();
			foreach ($_FILES['pic']['name'] as $k => $v){
				$pics[] = array(
					'name' => $v,
					'type' => $_FILES['pic']['type'][$k],
					'tmp_name' => $_FILES['pic']['tmp_name'][$k],
					'error' => $_FILES['pic']['error'][$k],
					'size' => $_FILES['pic']['size'][$k],
				);
			}
			// 循环每个上传
			foreach ($pics as $k => $v){
				if($v['error'] == 0){
					$res = $this->checkFile($v);
					//如果原图上传失败则返回错误信息
					if (!$res) {
						continue;
					}else{
						//picUrl自定义函数上传缩略图
						$resz = $this->picUrl($res);
					}
					$data['pic'] = $res;
					$data = array_merge($data,$resz);
					//将路径信息，存入ss_goods_pic表
					$gpModel->add([
							'pic' => $data['pic'],
							'big_pic' => $data['big_pic'],
							'mid_pic' => $data['mid_pic'],
							'sm_pic' => $data['sm_pic'],
							'goods_id' => $data['id'],
					]);
				}
			}
		}
		/************处理商品属性***************/
		$attrValue = I('post.attr_value');
		//第一层循环拿到属性ID和属性值数组
		$gaModel = D('goods_attr');
		foreach ($attrValue as $k => $v) {
			//去重
			$v = array_unique($v);
			// 第二层循环拿到具体的属性值
			foreach ($v as $k1 => $v1) {
				$gaModel->add([
					'goods_id'=>$data['id'],
					'attr_id'=>$k,
					'attr_value'=>$v1,
				]);
			}
		}
	}
	protected function _before_update(&$data,$option){
		/*********在更新信息之前先处理logo图片*********/
		if($_FILES['logo']['error']===0){//error为0表示上传了文件
			//如果上传了新文件，就删除旧文件，这里先存储路径信息
			//可选择是否删除原来的logo图，一般删除，节省磁盘空间
			$oldlogo = $this->field('logo,mbig_logo,sm_logo,big_logo,mid_logo')->where('id='.$data['id'])->find();
			session('old_logo_update',$oldlogo);

			//调用自定义函数验证图片文件并上传原图
			$res = $this->checkFile($_FILES['logo']);
			//如果原图上传失败则返回错误信息
			if (!$res) {
				return false;
			}else{
				//imageUrl自定义函数上传缩略图
				$resz = $this->imageUrl($res);
			}
			$data['logo'] = $res;
			$data = array_merge($data,$resz);
		}
		if (isset($data['is_best'])) {
			$data['is_best']='是';
		}else{
			$data['is_best']='否';
		}
		if (isset($data['is_new'])) {
			$data['is_new']='是';
		}else{
			$data['is_new']='否';
		}
		if (isset($data['is_hot'])) {
			$data['is_hot']='是';
		}else{
			$data['is_hot']='否';
		}
		//给商品信息加上时间
		$data['updtime'] = date('Y-m-d H:i:s',time());
		//调用自定义的防止XSS注入的函数过滤出HTML代码，此函数包含了htmlpurifier插件包
		$data['goods_desc'] = removeXSS($_POST['goods_desc']);
		//没有输入货号时，以当前时间戳作为其货号
		$data['goods_sn'] = I('post.goods_sn')!=false?I('post.goods_sn'):time();
	}
	protected function _after_update($data,$option){
		$id = $data['id'];  // 要修改的商品的ID

		/************ 修改商品属性 *****************/
		//获取旧的属性id数组
		$gaid = I('post.goods_attr_id');
		//获取要更新的商品属性值
		$attrValue = I('post.attr_value');
		$gaModel = D('goods_attr');
		$_i = 0;  // 循环次数
		foreach ($attrValue as $k => $v){
			foreach ($v as $k1 => $v1){
				// 这个replace into可以实现同样的功能
				// replace into ：如果记录存在就修改，记录不存在就添加。以主键字段来判断一条记录是否存在
				//$gaModel->execute('REPLACE INTO p39_goods_attr VALUES("'.$gaid[$_i].'","'.$v1.'","'.$k.'","'.$id.'")');
				// 找这个属性值是否有id
				
				if($gaid[$_i] == '')//每次循环判断对应的attr_id是否存在，以此决定是新增还是修改
					$gaModel->add(array(
						'goods_id' => $id,
						'attr_id' => $k,
						'attr_value' => $v1,
					));
				else 
					$gaModel->where(array(
						'id' => array('eq', $gaid[$_i]),
					))->setField('attr_value', $v1);
				
				$_i++;
			}
		}
		//删除表中id不在$gaid中的记录行
		// $gaModel->where([
		// 	'id'=>['not in',$gaid],
		// ])->delete();
		/************删除旧的会员logo图片*****************/
		$old_logo_url = session('old_logo_update');
		$this->delete_old_logo($old_logo_url);

		/*****************处理会员价格信息*****************/
		//先获取表单中的会员价格信息
		$mp = I('post.member_price');
		$mpModel = M('member_price');
		foreach ($mp as $k => $v) {
			//将用户的输入永远转化为浮点型，非数字转化为0
			//这里用框架没有很好的方法去验证，因为member_price是个数组
			$_v = (float)$v;

			if($_v>0){
				//如果有价格则写入此价格
				$save = ['level_id'=>$k,'goods_id'=>$id];
				$save['price'] = $v;
			}else{
				//如果有会员价格没填，则默认为店铺价
				$save = ['level_id'=>$k,'goods_id'=>$id];
				$save['price'] = $data['shop_price'];
			}
			//因为每个商品的会员价格固定，因此可以选择更新覆盖
			//拼装好一条一条记录信息后，根据表内是否存在，选择是更新还是添加，主要为以后临时level扩展用
			if($mpModel->where('level_id = '.$k.' and goods_id = '.$id)->select()){
				//如果此商品此leve的价格记录存在，则更新操作
				$mpModel->where('level_id = '.$k.' and goods_id = '.$id)->save($save);
			}else{
				//否则添加操作
				$mpModel->add($save);
			}
		}

		/*****************处理扩展分类*********************/
		$ecid = I('post.ext_cat_id');
		//如果有指定扩展分类，就处理
		if($ecid){
			$gcModel = D('goods_cat');
			//因为每个商品对应的扩展分类数量不固定，因此先删除原分类数据
			$gcModel->where(array(
				'goods_id' => array('eq', $id),
			))->delete();
			// 去重
			$ecid = array_unique($ecid);
			foreach ($ecid as $k => $v){
				if($v==0){
					continue ;
				}
				$save = ['cat_id' => $v,'goods_id' => $id];
				//否则添加操作
				$gcModel->add($save);
			}
		}

		/******************处理相册图片********************/
		$gpModel = D('goods_pic');
		$old_pid_ids = I('post.old_pic');
		$pic_condition = array('goods_id'=>array('eq',$id),
								'id' => array('NOT IN', $old_pid_ids)
						);
		//拿出要删的pic的路径
		$old_pic_url = $gpModel->field('pic,sm_pic,big_pic,mid_pic')
						->where($pic_condition)->select();
		//先删除要删的pic数据库记录
		$gpModel->where($pic_condition)->delete();
		//再删除要删的pic文件
		$this->delete_old_logo($old_pic_url);
		//因为每个商品对应的相册相片数量不固定，因此先删除原相册数据
		if(isset($_FILES['pic'])){
			$pics = array();
			foreach ($_FILES['pic']['name'] as $k => $v){
				$pics[] = array(
					'name' => $v,
					'type' => $_FILES['pic']['type'][$k],
					'tmp_name' => $_FILES['pic']['tmp_name'][$k],
					'error' => $_FILES['pic']['error'][$k],
					'size' => $_FILES['pic']['size'][$k],
				);
			}
			// 循环每个上传
			foreach ($pics as $k => $v){
				if($v['error'] == 0){
					$res = $this->checkFile($v);
					//如果原图上传失败则返回错误信息
					if (!$res) {
						continue;
					}else{
						//picUrl自定义函数上传缩略图
						$resz = $this->picUrl($res);
					}
					$data['pic'] = $res;
					$data = array_merge($data,$resz);
					//将路径信息，存入ss_goods_pic表
					$gpModel->where('goods_id = '.$id)->add([
							'pic' => $data['pic'],
							'big_pic' => $data['big_pic'],
							'mid_pic' => $data['mid_pic'],
							'sm_pic' => $data['sm_pic'],
							'goods_id' => $data['id'],
					]);
				}
			}
		}

	}
	///彻底删除商品信息前调用此函数
	protected function _before_delete($option){
		//从数据库删除数据前，先将图片路径存入session
		$oldlogo = $this->field('logo,mbig_logo,sm_logo,big_logo,mid_logo')->where('id='.$option['where']['id'])->find();
		session('old_logo_delete',$oldlogo);
	}
	//彻底删除商品信息后调用此函数
	protected function _after_delete($option){
		//如果session中有就文件路径信息，就删掉
		if (session('old_logo_delete')) {
			//商品的信息已经从数据库删除，然后再从session拿回图片路径，删除服务器中的图片
			$old_logo_url = session('old_logo_delete');
			session('old_logo_delete',null);//用完即删
			$this->delete_old_logo($old_logo_url);
		}
	}
	protected function delete_old_logo($old_logo_url){
		$keys = array_keys($old_logo_url);
		for ($i=0; $i < count($keys); $i++) {
			//如果是二维数组，则遍历删除多张图片的多张size
			if(is_array($old_logo_url[$i])){
				foreach ($old_logo_url[$i] as $v) {
					unlink($v);
				}
			//否则直接循环删除一张图片的多张size
			}else{
				unlink($old_logo_url["{$keys[$i]}"]);
			}
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
		$data['sm_logo'] = $dirname.'/thumb_sm_'.$filename;
		$data['mid_logo'] = $dirname.'/thumb_mid_'.$filename;
		$data['big_logo'] = $dirname.'/thumb_big_'.$filename;
		$data['mbig_logo'] = $dirname.'/thumb_mbig_'.$filename;
		//thumb保存缩略图
		$image->open($imgurl)->thumb(50,50)->save($data['sm_logo']);
		$image->open($imgurl)->thumb(130,130)->save($data['mid_logo']);
		$image->open($imgurl)->thumb(350,350)->save($data['big_logo']);
		$image->open($imgurl)->thumb(700,700)->save($data['mbig_logo']);
		//返回缩略图的路径
		return $data;
	}
	//上传保存相册
	private function picUrl($imgurl){
		$dirname = dirname($imgurl);
		$filename = basename($imgurl);
		//加载框架图片处理类
		$image = new \Think\Image();
		//指定缩略图片保存路径
		$data['sm_pic'] = $dirname.'/thumb_sm_'.$filename;
		$data['mid_pic'] = $dirname.'/thumb_mid_'.$filename;
		$data['big_pic'] = $dirname.'/thumb_big_'.$filename;
		//thumb保存缩略图
		$image->open($imgurl)->thumb(50,50)->save($data['sm_pic']);
		$image->open($imgurl)->thumb(350,350)->save($data['mid_pic']);
		$image->open($imgurl)->thumb(650,650)->save($data['big_pic']);
		//返回缩略图的路径
		return $data;
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
        	'savePath'		=>	'Goods/',//附件上传子目录
		];
		$file = new \Think\Upload($arg);
		//上传原图并保存
		$res = $file->uploadOne($uploadfile);
		if ($res) {
			//返回完整路径
			return $arg['rootPath'].$res['savepath'].$res['savename'];
		}else{
			$this->error['logo'] = $file->getError();
			return false;
		}
	}
	/**
	 * [getLimitData description]
	 * @param  integer $tar_page  目标页码
	 * @param  integer $rowsNum   每页条目
	 * @param  string  $condition $where查询条件
	 * @param  string  $order     $order查询条件
	 * @return [type]             返回数据，包括页码和查询的数据
	 */
	public function getLimitData($tar_page=1,$rowsNum=5,$condition=[],$order=[]){ 
		$condition['is_delete'] = '否';		//总记录行数
		$join = 'left join ss_brand as b on g.brand_id = b.id 
			left join ss_category as c on g.cat_id = c.id 
			left join ss_goods_cat as gc on g.id = gc.goods_id 
			left join ss_category as cc on gc.cat_id = cc.id';
		//两次查询的基本条件应一致
		$totalRows = $this->alias('g')->join($join)->where($condition)->order($order)->count("DISTINCT g.id");
		//获取分页类模型
		$fenye = new \Think\Fenye();
		//获取分页页码
		$pages = $fenye->getPageNumber($totalRows,$tar_page,$rowsNum);
		//分页查询，GROUP_CONCAT函数将分组里的cat_name拼接起来
		$goods_list = $this
		->field("g.*,b.brand_name,c.cat_name,GROUP_CONCAT(cc.cat_name separator ' | ') as ext_cat_name")
		->alias('g')->join($join)->where($condition)->order($order)
		->limit($pages['firstRows'],$pages['rowsNum'])
		->group('g.id')->select();
		return [
			'pages'      =>  $pages,
			'goods_list' =>  $goods_list,
		];
	}
}