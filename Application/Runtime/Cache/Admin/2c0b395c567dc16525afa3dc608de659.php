<?php if (!defined('THINK_PATH')) exit();?><!-- $Id: brand_info.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 添加管理员 </title>
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
    <span class="action-span"><a href="/Admin/Manager/managerList.html">管理员列表</a></span>
    <span class="action-span1"><a href="/Admin">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 添加管理员 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form method="post" action="" enctype="multipart/form-data" id="managerEdit">
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">管理员用户名：</td>
                <td>
                    <input type="text" name="username" maxlength="60" value="<?php echo ($manager_detail["username"]); ?>" id="username"/>
                    <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">管理员密码：</td>
                <td>
                    <input type="password" name="password" value="" id="password"/>
                    <span class="require-field">*区分大小写</span>
                </td>
            </tr>
            <tr>
                <td class="label">密码确认：</td>
                <td>
                    <input type="password" name="password_check" value=""  id="password_check"/>
                    <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">管理员角色：</td>
                <td>
                    <input type="button" id="btn_add_role" value="添加一个" />
                    <span class="require-field"> * 不选择则默认为超级管理员，拥有所有角色权限</span><br/>
                    <ul id="ext_role">
                        <li> 
                            <select name="role_id[]" id="role_id">
                                <option value="">请选择--</option>
                                <?php if(is_array($role_list)): $i = 0; $__LIST__ = $role_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vol["id"]); ?>"><?php echo ($vol["role_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </li>
                            <?php if(is_array($manager_detail_role_ids)): $i = 0; $__LIST__ = $manager_detail_role_ids;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><li value="<?php echo ($vol["role_id"]); ?>"> 
                                <select name="role_id[]" class="_role_id">
                                    <option value="">请选择--</option>
                                    <?php if(is_array($role_list)): foreach($role_list as $key=>$val): ?><option value="<?php echo ($val["id"]); ?>" ><?php echo ($val["role_name"]); ?></option><?php endforeach; endif; ?>
                                </select>
                                <input type="button" value="删除" onclick="$(this).parent().remove();"/>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                    
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center"><br />
                    <input type="hidden" name="id" value="<?php echo ($manager_detail["id"]); ?>"/>
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
$('#managerEdit').submit(function(evt){
    //收集表单域信息
    var data = new FormData(this);
    loadXMLDoc(data,"/Admin/Manager/managerEdit",function(){
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
                    layer.alert('用户修改成功！',function(){
                        window.location.href = "/Admin/Manager/managerList";
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
// 添加一个扩展分类
$('#btn_add_role').click(function(){
    //每按一次按钮，将第一个select标签复制一个放到最后
    $('#ext_role').append($('#ext_role').find('li').eq(0).clone());
    //定义一个input按钮用于删除添加的扩展分类
    var input = $('<input type="button" value="删除"/>');
    input.click(function(){
        $(this).parent().remove()
    });
    $('#ext_role').children().last().append(input);
});
window.onload=function(){
    //这里选择将select的value值暂放在父类元素ul上，然后再赋值
    $('._role_id').each(function(){
        $(this).val($(this).parent().val());
    });
}
</script>
</html>