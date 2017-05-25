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
			$url = __MODULE__."/Manager/login.html";
			echo "<script>top.location.href='$url'</script>";exit;
		}
	}
}