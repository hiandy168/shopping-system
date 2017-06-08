<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 添加权限 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/css/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/css/main.css" rel="stylesheet" type="text/css" />
<!-- 弹窗优化的js文件 -->
<script src="/Public/Admin/js/jquery-3.2.1.min.js"></script>
<script src="/Public/Plugins/layer/layer.js"></script>
</head>
<body>
<h1>
    <span class="action-span"><a href="/Admin/Privilege/privilegeList">商品权限</a></span>
    <span class="action-span1"><a href="/Admin">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 添加权限 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form action="" method="post" name="theForm" enctype="multipart/form-data" id="privilegeAdd">
        <table width="100%" id="general-table">
            <tr>
                <td class="label">权限名称：</td>
                <td>
                    <input type='text' name='pri_name' maxlength="20" value='' size='27' id="pri_name"/> <font color="red">*</font>
                </td>
            </tr>
            <tr>
                <td class="label">模块名称：</td>
                <td> 
                    <input  type="text" name="module_name" id="module_name" value="" />
                </td>
            </tr>
            <tr>
                <td class="label">控制器名称：</td>
                <td>
                    <input  type="text" name="controller_name" id="controller_name" value="" />
                </td>
            </tr>
            <tr>
                <td class="label">方法名称：</td>
                <td>
                    <input  type="text" name="action_name" id="action_name" value="" />
                </td>
            </tr>
            <tr>
                <td class="label">上级权限：</td>
                <td>
                    <select name="parent_id" id="parent_id">
                        <option value="0">顶级权限-</option>
                        <?php if(is_array($pri_list)): foreach($pri_list as $key=>$val): ?><option value="<?php echo ($val["id"]); ?>"><?php echo (str_repeat('&nbsp;&nbsp;',$val["level"])); ?>-<?php echo ($val["pri_name"]); ?></option><?php endforeach; endif; ?>
                    </select>
                </td>
            </tr>
        </table>
        <div class="button-div">
            <input type="submit" value=" 确定 " />
            <input type="reset" value=" 重置 " />
        </div>
    </form>
</div>
<div id="footer">
版权所有 &copy; 2017-2017 ThinkPHP ZY 学习。</div>
</body>>
<script>
$('#privilegeAdd').submit(function(evt){
    //收集表单域信息
    var data = new FormData(this);
    loadXMLDoc(data,"/Admin/Privilege/privilegeAdd",function(){
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
                    layer.alert('新权限添加成功！',function(){
                        window.location.href = "/Admin/Privilege/privilegeList";
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
</html>