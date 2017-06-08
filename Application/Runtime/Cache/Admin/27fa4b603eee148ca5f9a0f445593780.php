<?php if (!defined('THINK_PATH')) exit();?><!-- $Id: brand_info.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 添加角色 </title>
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
    <span class="action-span"><a href="/Admin/Role/roleList.html">角色列表</a></span>
    <span class="action-span1"><a href="/Admin">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 修改角色 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form method="post" action="" enctype="multipart/form-data" id="roleEdit">
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">角色名：</td>
                <td>
                    <input type="text" name="role_name" maxlength="60" value="<?php echo ($role_detail["role_name"]); ?>" id="role_name"/>
                    <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">角色权限：</td>
                <td>
                    <span>勾选选择↓</span><br/>
                        <?php if(is_array($pri_list)): $i = 0; $__LIST__ = $pri_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i; if(in_array($vol['id'],$role_detail_pri_list))$checked='checked';else $checked=''; ?>
                            -<?php echo (str_repeat('——',$vol["level"])); ?>-
                            <input <?php echo ($checked); ?> type="checkbox" level_id="<?php echo ($vol["level"]); ?>" name="pri_id[]" value="<?php echo ($vol["id"]); ?>"><?php echo ($vol["pri_name"]); ?><br/><?php endforeach; endif; else: echo "" ;endif; ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center"><br />
                    <input type="hidden" name="id" value="<?php echo ($role_detail["id"]); ?>"/>
                    <input type="submit" class="button" value=" 确定 "  onmouseover="this.style.cursor='pointer'"/>
                    <input type="reset" class="button" value=" 重置 "  onmouseover="this.style.cursor='pointer'"/>
                </td>
            </tr>
        </table>
    </form>
</div>
<div id="footer">
版权所有 &copy; 2017-2017 ThinkPHP ZY 学习。</div>
</body>
<script>
$('#roleEdit').submit(function(evt){
    //收集表单域信息
    var data = new FormData(this);
    loadXMLDoc(data,"/Admin/Role/roleEdit",function(){
        if(xhr.readyState!=4){
            //layer加载层
            layer.load(2);
            // layer.msg('请稍等！正在努力加载中！', {icon: 4});
        }
        if(xhr.readyState==4 && xhr.status==200){
            layer.closeAll('loading');
            // console.log(xhr.responseText);
            var object=JSON.parse(xhr.responseText,function(key,value){
                if (value=='success') {
                    layer.alert('角色信息修改成功！',function(){
                        window.location.href = "/Admin/Role/roleList";
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
// 为所有的复选框绑定一个点击事件
$(":checkbox").click(function(){
    // 先获取点击的这个level_id
    var tmp_level_id = level_id = $(this).attr("level_id");
    // 判断是选中还是取消
    if($(this).prop("checked")){
        // 所有的子权限也选中
        $(this).nextAll(":checkbox").each(function(k,v){
            if($(v).attr("level_id") > level_id){
                $(v).attr("checked", "checked");
            }else{
                return false;//遇到一个level不小的，说明子权限遍历完了
            }
        });
        // 所有的上级权限也选中
        $(this).prevAll(":checkbox").each(function(k,v){
            if($(v).attr("level_id") < tmp_level_id){
                $(v).attr("checked", "checked");
                tmp_level_id--; // 再找更上一级的
            }
        });
    }else{
        // 所有的子权限也取消
        $(this).nextAll(":checkbox").each(function(k,v){
            if($(v).attr("level_id") > level_id){
                $(v).removeAttr("checked");
            }else{
                return false;
            }
        });
    }
});
</script>
</html>