<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>商城后台 管理中心 - <?php echo ($_page_title); ?> </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/css/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/css/main.css" rel="stylesheet" type="text/css" />
<!-- layer -->
<script src="/Public/Admin/js/jquery-3.2.1.min.js"></script>
<script src="/Public/Plugins/layer/layer.js"></script>

<!-- 文本编辑器的js文件 -->
<link href="/Public/Plugins/umeditor/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="/Public/Plugins/umeditor/third-party/jquery.min.js"></script>
<script type="text/javascript" src="/Public/Plugins/umeditor/third-party/template.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/Plugins/umeditor/umeditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/Plugins/umeditor/umeditor.min.js"></script>
<script type="text/javascript" src="/Public/Plugins/umeditor/lang/zh-cn/zh-cn.js"></script>
<style>#tableList td{text-align:center;}
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button{
        -webkit-appearance: none !important;
        margin: 0; 
    }
</style>
</head>
<body>
<h1>
    <span class="action-span"><a href="/Admin/Category/<?php echo ($_URL_); ?>.html"><?php echo ($_btn_name); ?></a></span>
    <span class="action-span1"><a href="/Admin">商城后台 管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo ($_page_title); ?></span>
    <div style="clear:both"></div>
</h1>


<div class="main-div">
    <form action="" method="post" name="theForm" enctype="multipart/form-data" id="categoryAdd">
        <table width="100%" id="general-table">
            <tr>
                <td class="label">分类名称:</td>
                <td>
                    <input type='text' name='cat_name' maxlength="20" value='' size='27' id="cat_name"/> <font color="red">*</font>
                </td>
            </tr>
            <tr>
                <td class="label">上级分类:</td>
                <td>
                    <select name="parent_id" id="parent_id">
                        <option value="0">顶级分类-</option>
                        <?php if(is_array($cat_list)): foreach($cat_list as $key=>$val): ?><option value="<?php echo ($val["id"]); ?>"><?php echo (str_repeat('&nbsp;&nbsp;',$val["level"])); ?>-<?php echo ($val["cat_name"]); ?></option><?php endforeach; endif; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="label">排序:</td>
                <td>
                    <input type="text" name='sort_num'  value="" size="15" />
                </td>
            </tr>
            <tr>
                <td class="label">是否显示:</td>
                <td>
                    <input type="radio" name="is_show" value="是"  checked="true"/> 是 
                    <input type="radio" name="is_show" value="否"  /> 否
                </td>
            </tr>
            <tr>
                <td class="label">导航显示:</td>
                <td>
                    <input type="radio" name="is_floor" value="是"  checked="true"/> 是 
                    <input type="radio" name="is_floor" value="否"  /> 否
                </td>
            </tr>
            <tr>
                <td class="label">关键字:</td>
                <td>
                    <input type="text" name="keywords" value='' size="50" id="keywords"/>
                    <span>关键词之间请用逗号隔开</span>
                </td>
            </tr>
        </table>
        <div class="button-div">
            <input type="submit" value=" 确定 " />
            <input type="reset" value=" 重置 " />
        </div>
    </form>
</div>
<script>
$('#categoryAdd').submit(function(evt){
    //收集表单域信息
    var data = new FormData(this);
    loadXMLDoc(data,"/Admin/Category/categoryAdd",function(){
        if(xhr.readyState!=4){
            //layer加载层
            layer.load(2);
            // layer.msg('请稍等！正在努力加载中！', {icon: 4});
        }
        if(xhr.readyState==4 && xhr.status==200){
            // console.log(xhr.responseText);
            layer.closeAll('loading');
            var object=JSON.parse(xhr.responseText,function(key,value){
                if (value=='success') {
                    layer.alert('新分类添加成功！',function(){
                        window.location.href = "/Admin/Category/categoryList";
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
</script>

<div id="footer">
版权所有 &copy; 2017-2017 ThinkPHP ZY 学习。</div>
</body>
</html>