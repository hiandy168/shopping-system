<?php if (!defined('THINK_PATH')) exit();?><!-- $Id: category_list.htm 17019 2010-01-29 10:10:34Z liuhui $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 商品分类 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/css/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/css/main.css" rel="stylesheet" type="text/css" />
<script src="/Public/Admin/js/jquery-3.2.1.min.js"></script>
<script src="/Public/Plugins/layer/layer.js"></script>
</head>
<body>
<h1>
    <span class="action-span"><a href="/Admin/Category/categoryAdd">添加新分类</a></span>
    <span class="action-span1"><a href="/Admin">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 商品分类 </span>
    <div style="clear:both"></div>
</h1>
<form method="post" action="" name="listForm">
    <div class="list-div" id="listDiv">
        <table width="100%" cellspacing="1" cellpadding="2" id="list-table">
            <tr>
                <th>分类名称</th>
                <th>导航栏</th>
                <th>是否显示</th>
                <th>排序</th>
                <th>关键词</th>
                <th>操作</th>
            </tr>
            <?php if(is_array($cat_list)): foreach($cat_list as $key=>$val): ?><tr align="center" class="tron">
                <td align="left" class="first-cell" ><?php echo (str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$val["level"])); ?>
                <img src="/Public/Admin/Images/menu_minus.gif" width="9" height="9" border="0" style="margin-left:0em" />
                <span><?php echo ($val["cat_name"]); ?></span>
                </td>
                <td width="15%"><img src="/Public/Admin/Images/<?php if($val["is_floor"] == 是): ?>yes.gif<?php else: ?>no.gif<?php endif; ?>"  /></td>
                <td width="15%"><img src="<?php if($val["is_show"] == 是): ?>/Public/Admin/Images/yes.gif <?php else: ?> /Public/Admin/Images/no.gif<?php endif; ?>" /></td>
                <td width="15%" align="center"><span><?php echo ($val["sort_num"]); ?></span></td>
                <td width="20%" align="center"><?php echo ($val["keywords"]); ?></td>
                <td width="15%" align="center">
                <a href="/Admin/Category/categoryEdit?id=<?php echo ($val["id"]); ?>">编辑</a> |
                <a href="javascript:delete_confirm(<?php echo ($val["id"]); ?>)" title="移除" onclick="">移除</a>
                </td>
            </tr><?php endforeach; endif; ?>
        </table>
    </div>
</form>
<div id="footer">
版权所有 &copy; 2017-2017 ThinkPHP ZY 学习。</div>
</body>
<script>
//渲染鼠标选中的tr行背景颜色改变
$(".tron").mouseover(function(){
    $(this).find('td').css('backgroundColor','#ccc');
});
$(".tron").mouseout(function(){
    $(this).find('td').css('backgroundColor','#fff');
});
/**
 * 将商品移至回收站时，调用此函数
 * @param  int delete_id 回收商品的ID
 */
function deletec(delete_id){
    loadXMLDoc("/Admin/Category/categoryDelete/id/"+delete_id,function(){
        if(xhr.readyState!=4){
            //layer加载层
            layer.load(2);
            // layer.msg('请稍等！正在努力加载中！', {icon: 4});
        }
        if(xhr.readyState==4 && xhr.status==200){
            layer.closeAll('loading');
            var object=JSON.parse(xhr.responseText,function(key,value){
                if (value=='success') {
                    layer.alert('指定分类已被删除！',function(){
                        window.location.href = "/Admin/Category/categoryList/from/categoryEdit";
                        icon: 6;
                    });
                }else{
                    layer.alert(value, {icon: 5});
                }
            });
        }
    });
}
function delete_confirm(confirm_id){
    layer.msg('确定要删除此分类？', {
      time: 5000 
      ,btn: ['是的！', '算了..']
      ,yes: function(index){
        layer.close(index);
        deletec(confirm_id);
      }
      ,no:function(index){
        layer.close(index);
      }
    });
}
/**
 * 创建ajax对象，并向服务器发起请求
 * @param  string url    请求的链接
 * @param  mixed  cfunc  回调函数
 */
function loadXMLDoc(url,cfunc){
        if(window.XMLHttpRequest){
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xhr=new XMLHttpRequest();
        }else{
            // code for IE6, IE5
            xhr=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xhr.onreadystatechange=cfunc;
        xhr.open("get",url,true);
        xhr.send();
}
</script>
</html>