<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 添加新商品 </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/css/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/css/main.css" rel="stylesheet" type="text/css" />
<link href="/Public/Plugins/umeditor/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
<script src="/Public/Admin/js/jquery-3.2.1.min.js"></script>
<script src="/Public/Plugins/layer/layer.js"></script>
<script type="text/javascript" src="/Public/Plugins/umeditor/third-party/jquery.min.js"></script>
<script type="text/javascript" src="/Public/Plugins/umeditor/third-party/template.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/Plugins/umeditor/umeditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/Plugins/umeditor/umeditor.min.js"></script>
<script type="text/javascript" src="/Public/Plugins/umeditor/lang/zh-cn/zh-cn.js"></script>
</head>
<body>
<h1>
    <span class="action-span"><a href="/Admin/Goods/goodsList.html">商品列表</a>
    </span>
    <span class="action-span1"><a href="/Admin">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 添加新商品 </span>
    <div style="clear:both"></div>
</h1>

<div class="tab-div">
    <div id="tabbar-div">
        <p>
            <span class="tab-front" id="general-tab">通用信息</span>
        </p>
    </div>
    <div id="tabbody-div">
        <form enctype="multipart/form-data" method="post" id="goodsAdd">
            <table width="90%" id="general-table" align="center">
                <tr>
                    <td class="label">商品名称：</td>
                    <td><input type="text" name="goods_name" value="" size="30" id="goods_name"/>
                    <span class="require-field">*</span></td>
                </tr>
                <tr>
                    <td class="label">商品货号： </td>
                    <td>
                        <input type="text" name="goods_sn" value="" size="20" id="goods_sn"/>
                        <span id="goods_sn_notice"></span><br />
                        <span class="notice-span"id="noticeGoodsSN">如果您不输入商品货号，系统将自动生成一个唯一的货号。</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">商品分类：</td>
                    <td>
                        <select name="cat_id" id="cat_id">
                            <option value="0">请选择........</option>
                            <?php if(is_array($cat_list)): foreach($cat_list as $key=>$val): ?><option value="<?php echo ($val["id"]); ?>"><?php echo (str_repeat('&nbsp;&nbsp;',$val["level"])); ?>-<?php echo ($val["cat_name"]); ?></option><?php endforeach; endif; ?>
                        </select>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">商品品牌：</td>
                    <td>
                        <select name="brand_id" id="brand_id">
                            <option value="0">请选择...</option>
                            <?php if(is_array($brand_list)): foreach($brand_list as $key=>$val): ?><option value="<?php echo ($val["id"]); ?>"><?php echo ($val["brand_name"]); ?></option><?php endforeach; endif; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label">本店售价：</td>
                    <td>
                        <input type="text" name="shop_price" value="" size="20" id="shop_price"/>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">商品数量：</td>
                    <td>
                        <input type="text" name="goods_number" size="8" value="" id="goods_number"/>
                    </td>
                </tr>
                <tr>
                    <td class="label">是否上架：</td>
                    <td>
                        <input type="radio" name="is_on_sale" value="是" checked="checked"/> 是
                        <input type="radio" name="is_on_sale" value="否"/> 否
                    </td>
                </tr>
                <tr>
                    <td class="label">加入推荐：</td>
                    <td>
                        <input type="checkbox" name="is_best" value="1" /> 精品 
                        <input type="checkbox" name="is_new" value="1" /> 新品 
                        <input type="checkbox" name="is_hot" value="1" /> 热销
                    </td>
                </tr>
                <tr>
                    <td class="label">推荐排序：</td>
                    <td>
                        <input type="text" name="sort_num" size="5" value="100"/>
                    </td>
                </tr>
                <tr>
                    <td class="label">市场售价：</td>
                    <td>
                        <input type="text" name="market_price" value="" size="20" />
                    </td>
                </tr>
                <tr>
                    <td class="label">商品关键词：</td>
                    <td>
                        <input type="text" name="keywords" value="" size="40" /> 用空格分隔
                    </td>
                </tr>
                <tr>
                    <td class="label">商品LOGO：</td>
                    <td>
                        <input type="file" name="logo" size="35" id="logo"/>
                    </td>
                </tr>
                <tr>
                    <td class="label">商品简单描述：</td>
                    <td>
                        <textarea id="goods_desc" name="goods_desc" cols="40" rows="3"></textarea>
                    </td>
                </tr>
            </table>
            <div class="button-div">
                <input type="submit" value=" 确定 " class="button"/>
                <input type="reset" value=" 重置 " class="button" />
            </div>
        </form>
    </div>
</div>

<div id="footer">
共执行 9 个查询，用时 0.025161 秒，Gzip 已禁用，内存占用 3.258 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
<script>
    var xhr;
    function loadXMLDoc(data,url,cfunc){
        if(window.XMLHttpRequest){
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xhr=new XMLHttpRequest();
        }else{
            // code for IE6, IE5
            xhr=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xhr.onreadystatechange=cfunc;
        xhr.open("post",url,true);
        xhr.send(data);
    }
    var form = document.getElementById('goodsAdd');
    form.onsubmit = function(evt){
        //收集表单域信息
        var data = new FormData(this);
        loadXMLDoc(data,"/Admin/Goods/goodsAdd",function(){
            if(xhr.readyState==4 && xhr.status==200){
                console.log(xhr.responseText);
                var object=JSON.parse(xhr.responseText,function(key,value){
                    if (value=='success') {
                        layer.alert('新商品添加成功！',function(){
                            window.location.href = "/Admin/Goods/goodsList";
                            icon: 6;
                        });
                    }else if(key!=''){
                        layer.tips(value, '#'+key, {tipsMore: true});
                    }
                });
            }
        });
        evt.preventDefault();
    }
    UM.getEditor('goods_desc',{
        initialFrameWidth:'100%', //初始化编辑器宽度
        initialFrameHeight:150  //初始化编辑器高度
    });
</script>
</html>