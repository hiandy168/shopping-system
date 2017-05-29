<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 编辑品牌 </title>
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
    <span class="action-span"><a href="/Admin/Brand/brandList.html">品牌列表</a>
    </span>
    <span class="action-span1"><a href="/Admin">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 编辑品牌 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form method="post" action="" enctype="multipart/form-data" id="brandEdit">
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">品牌名称</td>
                <td>
                    <input type="text" name="brand_name" maxlength="60" value="<?php echo ($brand_detail["brand_name"]); ?>" id="brand_name"/>
                    <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">品牌网址</td>
                <td>
                    <input type="text" name="site_url" maxlength="60" size="40" value="<?php echo ($brand_detail["site_url"]); ?>" id="site_url"/>
                </td>
            </tr>
            <tr>
                <td class="label">品牌LOGO</td>
                <td>
                    <span>当前logo：</span><img src="/<?php echo ($brand_detail["sm_logo"]); ?>"><br/>
                    <input type="file" name="logo" id="logo" size="45"/><br/>
                    <span class="notice-span" style="display:block"  id="warn_brandlogo">请上传图片，做为品牌的LOGO！</span>
                </td>
            </tr>
            <tr>
                <td class="label">排序</td>
                <td>
                    <input type="text" name="sort_order" maxlength="40" size="15" value="<?php echo ($brand_detail["sort_num"]); ?>" id="sort_num"/>
                </td>
            </tr>
            <tr>
                <td class="label">是否显示</td>
                <td>
                    <input type="radio" name="is_show" value="是" id="is_show_1"/> 是
                    <input type="radio" name="is_show" value="否" id="is_show_0"/> 否(当品牌下还没有商品的时候，首页及分类页的品牌区将不会显示该品牌。)
                </td>
            </tr>
            <tr>
                <td class="label">品牌描述</td>
                <td>
                    <textarea  name="brand_desc" cols="60" rows="4" id="brand_desc"><?php echo ($brand_detail["brand_desc"]); ?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center"><br />
                    <input type="hidden" name="id" value="<?php echo ($brand_detail["id"]); ?>"/>
                    <input type="submit" class="button" value=" 确定 " onmouseover="this.style.cursor='pointer'"/>
                    <input style="width:45px;" type="bubtton" value=" 返 回 " class="button" onclick="location='/Admin/Brand/brandList/from/brandEdit'" onmouseover="this.style.cursor='pointer'"/>
                </td>
            </tr>
        </table>
    </form>
</div>
<div id="footer">版权所有 &copy; 2017-2017 ThinkPHP ZY 学习。</div>
</body>
<script>
$('#brandEdit').submit(function(evt){
    //收集表单域信息
    var data = new FormData(this);
    loadXMLDoc(data,"/Admin/Brand/brandEdit",function(){
        if(xhr.readyState!=4){
            //layer加载层
            layer.load(2);
            // layer.msg('请稍等！正在努力加载中！', {icon: 4});
        }
        if(xhr.readyState==4 && xhr.status==200){
            layer.closeAll('loading');
            var object=JSON.parse(xhr.responseText,function(key,value){
                if (value=='success') {
                    layer.alert('用户信息更新成功！',function(){
                        window.location.href = "/Admin/Brand/brandList";
                        icon: 6;
                    });
                }else if(key!=''){
                    layer.tips(value, '#'+key, {tipsMore: true});
                }
            });
        }
    });
    evt.preventDefault();
});
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
UM.getEditor('brand_desc',{
    initialFrameWidth:'100%', //初始化编辑器宽度
    initialFrameHeight:150  //初始化编辑器高度
});
//渲染默认被选择的单选框和复选框
window.onload=function(){
    if("<?php echo ($brand_detail["is_show"]); ?>"=='是'){
        $('#is_show_1').attr('checked','true');
    }else if("<?php echo ($brand_detail["is_show"]); ?>"=='否'){
        $('#is_show_0').attr('checked','true');
    }
}
</script>
</html>