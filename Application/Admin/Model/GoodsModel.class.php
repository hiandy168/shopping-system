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
	//自定义设置验证规则，$_validate属于父类Model
	protected $insertFields = 'goods_name,goods_sn,cat_id,brand_id,market_price,shop_price,is_on_sale,goods_desc,is_best,is_new,is_hot,sort_order,keywords,goods_img';
	protected $_validate = [
		//为表单域定义具体验证规则
		//array(字段名称/表单域name属性值,验证规则,错误提示[,验证条件,附加规则,验证时间])
		
		//require验证必须存在,1必须验证
		['goods_name','require',' * 所以您卖的是叫啥！',1],
		['goods_name','',' * 商品名称居然都能重复！',1,'unique'],
		['shop_price','require',' * 您是要送给别人么！',1],
		['shop_price','number',' * 价格应该是个数字吧！',1],
		['cat_id',0,' * 你必须选择一种分类',1,'notequal']
	];
	//这个方法会在执行数据insert前自动调用
	protected function _before_insert(&$data,$option){
		/*********处理图片*********/
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
		}
		$data['logo'] = $res;
		//给商品信息加上时间
		$data['addtime'] = date('Y-m-d H:i:s',time());
		//调用自定义的防止XSS注入的函数过滤出HTML代码，此函数包含了htmlpurifier插件包
		$data['goods_desc'] = removeXSS($_POST['goods_desc']);
		$data['goods_sn'] = time();
		$data = array_merge($data,$resz);
	}
	/**
	 * 根据上传图片的临时路径生成缩略图并保存两张图
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
		$image->open($imgurl);
		$image->thumb(50,50)->save($data['sm_logo']);
		$image->thumb(130,130)->save($data['mid_logo']);
		$image->thumb(350,350)->save($data['big_logo']);
		$image->thumb(700,700)->save($data['mbig_logo']);
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
}