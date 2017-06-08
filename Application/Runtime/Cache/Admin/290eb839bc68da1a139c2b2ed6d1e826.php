<?php if (!defined('THINK_PATH')) exit();?><!-- $Id: brand_info.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 修改会员级别 </title>
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
    <span class="action-span"><a href="/Admin/Level/levelList.html">会员级别列表</a></span>
    <span class="action-span1"><a href="/Admin">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 修改会员级别 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form method="post" action="" enctype="multipart/form-data" id="levelEdit">
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">会员级别名称：</td>
                <td>
                    <input type="text" name="level_name" maxlength="60" value="<?php echo ($level_detail["level_name"]); ?>" id="level_name"/>
                    <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">积分上限：</td>
                <td>
                    <input type="text" name="jifen_top" value="<?php echo ($level_detail["jifen_top"]); ?>" id="jifen_top"/>
                    <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">积分下限：</td>
                <td>
                    <input type="text" name="jifen_bottom" value="<?php echo ($level_detail["jifen_bottom"]); ?>"  id="jifen_bottom"/>
                    <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center"><br />
                <input type="hidden" name="id" value="<?php echo ($level_detail["id"]); ?>"/>
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
$('#levelEdit').submit(function(evt){
    //收集表单域信息
    var data = new FormData(this);
    loadXMLDoc(data,"/Admin/Level/levelEdit",function(){
        if(xhr.readyState!=4){
            //layer加载层
            layer.load(2);
            // layer.msg('请稍等！正在努力加载中！', {icon: 4});
        }
        if(xhr.readyState==4 && xhr.status==200){
            layer.closeAll('loading');
            var object=JSON.parse(xhr.responseText,function(key,value){
                if (value=='success') {
                    layer.alert('新级别修改成功！',function(){
                        window.location.href = "/Admin/Level/levelList";
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