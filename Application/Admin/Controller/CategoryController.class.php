<?php
namespace Admin\Controller;
use Think\Controller;
class CategoryController extends CommenController {
	public function categoryList(){
		$catModel = D('category');
		$res = $catModel->where("is_show='是'")->select();
		$cat_list = $catModel->getLevel($res,0,'id','parent_id','level');
		echo json_encode($cat_list);
	}
}