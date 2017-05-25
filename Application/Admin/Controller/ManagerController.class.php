<?php
namespace Admin\Controller;
use Think\Controller;
class ManagerController extends Controller {
    public function login(){
    	if($_POST['act']=='signin'){
    		$username = I('post.username');
    		$password = md5(I('post.password'));
    		$captcha = I('post.captcha');
    		if($this->check_captcha($captcha)){
    			$manager = D('Manager');
	    		if ($manager->create($_POST)){
	    			$res = $manager->where("username='{$username}' and password='{$password}'")->find();
	    			if ($res){
	    				setcookie("username",$username,time()+3600*24*30,__MODULE__);
						$_SESSION['login_time'] = date('Y-m-d H:i:s',time());
						$_SESSION['islogin']='ok';
	    				$sign = "success";
	    			}else{
	    				$sign = ['username'=>' * 用户名或密码错误！'];
	    			}
	    		}else{
	    			$sign = $manager->getError();
	    		}
    		}else{
    			$sign = ['captcha'=>' * 验证码错误!'];
    		}
    		echo json_encode($sign);
    	}else{
    		$this->display();
    	}
    }
    public function check(){
    	$res = $this->check_captcha(addslashes(trim($_GET['captcha'])));
    	if($res){
    		echo json_encode(["<p style='color:green;margin:0px'> * 验证码正确!</p>"]);
    	}else{
    		echo json_encode(" * 验证码错误!");
    	}
    }
    public function check_captcha($captcha){
		$Verify = new \Think\Verify();
		$Verify->reset = false;
		//验证验证码
		if($Verify->check($captcha)){
			return true;
		}else{
			return false;
		}
    }
    public function Verify(){
		$cfg = [
			'imageH' => 40,// 验证码图片高度
    		'imageW' => 140,// 验证码图片宽度
    		'fontSize' => 18,// 验证码字体大小(px)
    		'length' => 4,// 验证码位数
    		'fontttf' => '4.ttf',// 验证码字体，不设置随机获取
		];
    	$Verify = new \Think\Verify($cfg);
    	
    	$Verify->entry();
	}
	public function logout(){
		unset($_SESSION['islogin']);
		header("Location:".__CONTROLLER__."/login");
	}
}