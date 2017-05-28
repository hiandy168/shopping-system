<?php
//第一步：定义命名空间
namespace Think;
//第三步：定义模型并且继承父类
class Fenye{
	/**
	 * 获取分页页码
	 * @param  int 	$totalRows [总数据行数]
	 * @param  int 	$tar_page  [目标页码]
	 * @param  int  $rowsNum   [每行显示数目]
	 * @return array            [返回页码数据]
	 */
	public function getPageNumber(int $totalRows,int $tar_page,int $rowsNum){
		//每页条目默认必须至少为1
		$rowsNum = $rowsNum>0?$rowsNum:1;
		//记录总页数，ceil向上取整，无论有没有数据，页码至少为1
		$res['pageNum'] = (int)ceil($totalRows/$rowsNum)==0?1:(int)ceil($totalRows/$rowsNum);
		//求出上一页的页码
		$res['prev'] = $tar_page>1?$tar_page-1:1;
		//当前页的第一条记录位置
		$res['firstRows'] = ($tar_page-1)*$rowsNum;
		//求出下一页的页码
		$res['next'] = $tar_page<$res['pageNum']?$tar_page+1:$tar_page;
		//分页成功后，目标页码即为当前页码
		$res['cur_page'] = $tar_page;
		//分页成功后，返回每页显示条目数
		$res['rowsNum'] = $rowsNum;
		//返回总记录行数
		$res['totalRows'] = $totalRows;
		return $res;
	}
}