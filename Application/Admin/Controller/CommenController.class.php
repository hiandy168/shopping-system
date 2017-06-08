<?php
//第一步：定义命名空间
namespace Admin\Controller;
//第二步：引入父类的控制器
use Think\Controller;
//第三步：定义控制器并且继承父类
class CommenController extends Controller {
	public function _initialize(){
		//判断session中是否有成功标志
		$islogin = session('islogin');
		if(empty($islogin)){
			$url = __MODULE__."/Login/login.html";
			echo "<script>top.location.href='$url'</script>";exit;
		}
		// 所有管理员都可以进入后台的首页
		if(CONTROLLER_NAME == 'Index')
			return TRUE;
		$priModel = D('Privilege');
		//如果没有访问权限，则返回404错误
		if(!$priModel->chkPri()){
			// $this->error('无权访问！');
			header("HTTP/1.1 404 Not Found");exit;
		}
	}
}