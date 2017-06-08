<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommenController {
    public function index(){
    	$this->display();
    }
    public function Main(){
    	$username = cookie('username');
    	$goodsModel = D('goods');
    	$goods_count = $goodsModel->field('count(*) as c')->find();
    	$goods_count_new = $goodsModel->field('count(*) as c')->where('is_new = "是"')->find();
    	$goods_count_hot = $goodsModel->field('count(*) as c')->where('is_hot = "是"')->find();
    	$goods_count_best = $goodsModel->field('count(*) as c')->where('is_best = "是"')->find();
    	if(extension_loaded('sockets')){$socket="是";}else{$socket="否";}
    	$this->assign([
    		'manager_name'=>$username,
    		'PHP_OS'=>PHP_OS,
    		'sever_version'=>apache_get_version(),
    		'php_version'=>PHP_VERSION,
    		'sql_version'=>mysql_get_server_info(),
    		'socket'=>$socket,
    		'goods_count'=>$goods_count,
    		'goods_count_new'=>$goods_count_new,
    		'goods_count_hot'=>$goods_count_hot,
    		'goods_count_best'=>$goods_count_best,
    	]);
    	$this->display();
    }
}