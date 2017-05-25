<?php
namespace Admin\Controller;
use Think\Controller;
class BrandController extends CommenController {
	public function brandList(){
		$brandModel = D('brand');
		$brand_list = $brandModel->where("is_show='是'")->select();
		echo json_encode($brand_list);
	}	
}