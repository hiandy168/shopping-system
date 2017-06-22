<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
    	//获取首页三级分类数据
		$catModel = D('Category');
        $goodsModel = D('Goods');
		$res = $catModel->where(['is_show'=>['eq','是']])->select();//获取所有分类数据
		$cat_list = $catModel->getNavData($res);//将分类数据二次分类处理

        $floorData = $catModel->getFloorData();
        
        //疯狂选购的商品列表,或者应该以订单数为标准
        $promote_goods_list = $goodsModel->getPromoteGoods(5);
        //热卖商品的列表
        $hot_goods_list = $goodsModel->getRecGoods('is_hot',5);
        //精品商品的列表
        $best_goods_list = $goodsModel->getRecGoods('is_best',5);
        //新品商品的列表
        $new_goods_list = $goodsModel->getRecGoods('is_new',5);
    	$this->assign([
    		'_page_title'=>'商城首页',
    		'_show_nav'=>1,
    		'_page_keywords'=>'商城首页',
    		'_page_description'=>'商城首页',
            'cat_list'=>$cat_list,
            'floorData'=>$floorData,
            'promote_goods_list'=>$promote_goods_list,
            'hot_goods_list'=>$hot_goods_list,
            'best_goods_list'=>$best_goods_list,
    		'new_goods_list'=>$new_goods_list,
    	]);
    	$this->display();
    }
    public function address(){
    	$this->assign([
    		'_page_title'=>'商城首页',
    		'_show_nav'=>0,
    	]);
    	$this->display();
    }
}