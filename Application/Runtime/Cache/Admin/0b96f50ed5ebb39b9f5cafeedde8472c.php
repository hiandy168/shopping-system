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
<!-- 时间插件 -->
<link href="/Public/Plugins/datetimepicker/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="utf-8" src="/Public/Plugins/datetimepicker/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/Plugins/datetimepicker/datepicker-zh_cn.js"></script>
<link rel="stylesheet" media="all" type="text/css" href="/Public/Plugins/datetimepicker/time/jquery-ui-timepicker-addon.min.css" />
<script type="text/javascript" src="/Public/Plugins/datetimepicker/time/jquery-ui-timepicker-addon.min.js"></script>
<script type="text/javascript" src="/Public/Plugins/datetimepicker/time/i18n/jquery-ui-timepicker-addon-i18n.min.js"></script>
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
    <span class="action-span"><a href="/Admin/Role/<?php echo ($_URL_); ?>.html"><?php echo ($_btn_name); ?></a></span>
    <span class="action-span1"><a href="/Admin">商城后台 管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo ($_page_title); ?></span>
    <div style="clear:both"></div>
</h1>



<div class="main-div">
    <form method="post" action="" enctype="multipart/form-data" id="roleAdd">
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">角色名：</td>
                <td>
                    <input type="text" name="role_name" maxlength="60" value="" id="role_name"/>
                    <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">角色权限：</td>
                <td>
                    <span>勾选选择↓</span><br/>
                        <?php if(is_array($pri_list)): $i = 0; $__LIST__ = $pri_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?>-<?php echo (str_repeat('——',$vol["level"])); ?>-
                            <input type="checkbox" level_id="<?php echo ($vol["level"]); ?>" name="pri_id[]" value="<?php echo ($vol["id"]); ?>"><?php echo ($vol["pri_name"]); ?><br/><?php endforeach; endif; else: echo "" ;endif; ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center"><br />
                    <input type="submit" class="button" value=" 确定 "  onmouseover="this.style.cursor='pointer'"/>
                    <input type="reset" class="button" value=" 重置 "  onmouseover="this.style.cursor='pointer'"/>
                </td>
            </tr>
        </table>
    </form>
</div>

<script>
$('#roleAdd').submit(function(evt){
    //收集表单域信息
    var data = new FormData(this);
    loadXMLDoc(data,"/Admin/Role/roleAdd",function(){
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
                    layer.alert('新角色添加成功！',function(){
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

<div id="footer">
版权所有 &copy; 2017-2017 ThinkPHP ZY 学习。</div>
</body>
</html>