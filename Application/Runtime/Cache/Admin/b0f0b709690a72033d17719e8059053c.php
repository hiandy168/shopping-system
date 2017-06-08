<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心</title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/css/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/css/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a>——欢迎管理员-
    <?php echo ($manager_name); ?></span>
    <span id="search_id" class="action-span1"></span>
    <div style="clear:both"></div>
</h1>
<div class="list-div">
    <table cellspacing='1' cellpadding='3'>
        <tr>
            <th colspan="4" class="group-title">订单统计信息</th>
        </tr>
        <tr>
            <td width="20%"><a href="#">待发货订单:</a></td>
            <td width="30%"><strong style="color:red">4</strong></td>
            <td width="20%"><a href="#">未确认订单:</a></td>
            <td width="30%"><strong>2</strong></td>
        </tr>
        <tr>
            <td><a href="#">待支付订单:</a></td>
            <td><strong>3</strong></td>
            <td><a href="#">已成交订单数:</a></td>
            <td><strong>3</strong></td>
        </tr>
        <tr>
            <td><a href="#">新缺货登记:</a></td>
            <td><strong>2</strong></td>
            <td><a href="#">退款申请:</a></td>
            <td><strong>0</strong></td>
        </tr>
        <tr>
            <td><a href="#">部分发货订单:</a></td>
            <td><strong>1</strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </table>
</div>
<!-- end order statistics -->
<br />
<!-- start goods statistics -->
<div class="list-div">
    <table cellspacing='1' cellpadding='3'>
        <tr>
            <th colspan="4" class="group-title">实体商品统计信息</th>
        </tr>
        <tr>
            <td width="20%">商品总数:</td>
            <td width="30%"><strong><?php echo ($goods_count["c"]); ?></strong></td>
            <td width="20%"><a href="#">库存警告商品数:</a></td>
            <td width="30%"><strong style="color:red">7</strong></td>
        </tr>
        <tr>
            <td><a href="#">新品推荐数:</a></td>
            <td><strong><?php echo ($goods_count_new["c"]); ?></strong></td>
            <td><a href="#">精品推荐数:</a></td>
            <td><strong><?php echo ($goods_count_best["c"]); ?></strong></td>
        </tr>
        <tr>
            <td><a href="#">热销商品数:</a></td>
            <td><strong><?php echo ($goods_count_hot["c"]); ?></strong></td>
            <td><a href="#">促销商品数:</a></td>
            <td><strong>2</strong></td>
        </tr>
    </table>
</div>
<!-- end order statistics -->
<br />
<!-- start system information -->
<div class="list-div">
    <table cellspacing='1' cellpadding='3'>
        <tr>
            <th colspan="4" class="group-title">系统信息</th>
        </tr>
        <tr>
            <td width="20%">服务器操作系统:</td>
            <td width="30%"><?php echo ($PHP_OS); ?></td>
            <td width="20%">Web 服务器:</td>
            <td width="30%"><?php echo ($sever_version); ?></td>
        </tr>
        <tr>
            <td>PHP 版本:</td>
            <td><?php echo ($php_version); ?></td>
            <td>MySQL 版本:</td>
            <td><?php echo ($sql_version); ?></td>
        </tr>
        <tr>
            <td>Socket 支持:</td>
            <td><?php echo ($socket); ?></td>
            <td>时区设置:</td>
            <td>PRC</td>
        </tr>
    </table>
</div>
<div id="footer">
版权所有 &copy; 2017-2017 ThinkPHP ZY 学习。</div>
</body>
</html>