<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 编辑会员 </title>
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
    <span class="action-span"><a href="/Admin/User/userList.html">会员列表</a>
    </span>
    <span class="action-span1"><a href="/Admin">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 编辑会员 </span>
    <div style="clear:both"></div>
</h1>

<div class="main-div">
    <form method="post" action="" enctype="multipart/form-data" id="userEdit">
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">会员用户名：</td>
                <td>
                    <input type="text" name="username" maxlength="60" value="<?php echo ($user_detail["username"]); ?>" id="username"/>
                    <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">会员密码：</td>
                <td>
                    <input type="password" name="password" value="" id="password"/>
                    <span class="require-field">*</span>
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
                <td class="label">会员头像：</td>
                <td>
                    <span>当前头像：</span><img src="/<?php echo ($user_detail["sm_face"]); ?>" alt="头像" /><br/>
                    <input type="file" name="face" id="face" size="45"/><br/>
                    <span class="notice-span" style="display:block"  id="warn_brandlogo">请上传图片，做为个人头像！</span>
                </td>
            </tr>
            <tr>
                <td class="label">初始积分：</td>
                <td>
                    <input type="text" name="jifen" maxlength="40" size="15" value="<?php echo ($user_detail["jifen"]); ?>" />
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center"><br />
                    <input type="hidden" name="id" value="<?php echo ($user_detail["id"]); ?>"/>
                    <input type="submit" class="button" value=" 确定 " onmouseover="this.style.cursor='pointer'"/>
                    <input style="width:45px;" type="bubtton" value=" 返 回 " class="button" onclick="location='/Admin/User/userList/from/userEdit'" onmouseover="this.style.cursor='pointer'"/>
                </td>
            </tr>
        </table>
    </form>
</div>
<div id="footer">版权所有 &copy; 2017-2017 ThinkPHP ZY 学习。</div>
</body>
<script>
$('#userEdit').submit(function(evt){
    //收集表单域信息
    var data = new FormData(this);
    loadXMLDoc(data,"/Admin/User/userEdit",function(){
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
                        window.location.href = "/Admin/User/userList/from/userEdit";
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