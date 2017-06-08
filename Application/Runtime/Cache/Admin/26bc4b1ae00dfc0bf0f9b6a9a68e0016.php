<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 角色列表 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/css/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/css/main.css" rel="stylesheet" type="text/css" />
<script src="/Public/Admin/js/jquery-3.2.1.min.js"></script>
<script src="/Public/Plugins/layer/layer.js"></script>
<style>
    #tableList td{text-align:center;}
    #face{width:30px;height:30px;border:0;}
    .tron{height:35px;}
</style>
</head>
<body>
<h1>
    <span class="action-span"><a href="/Admin/Role/roleAdd.html">添加角色</a></span>
    <span class="action-span1"><a href="/Admin">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 角色列表 </span>
    <div style="clear:both"></div>
</h1>
<form method="post" action="" name="listForm">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1" id="tableList">
            <tr id="table_first">
                <th>序号</th>
                <th>角色名称</th>
                <th>操作</th>
            </tr>
            <?php if(is_array($Roledata)): $i = 0; $__LIST__ = $Roledata;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><tr class="tron">
                    <td><?php echo ($i); ?></td>
                    <td><?php echo ($vol["role_name"]); ?></td>
                    <td>
                    <?php if($vol["id"] != 0): ?><a href="/Admin/Role/roleEdit/id/<?php echo ($vol["id"]); ?>" title="编辑">编辑修改权限</a> |
                        <a href="javascript:delete_confirm(<?php echo ($vol["id"]); ?>)" title="移除">移除</a>
                    <?php else: ?>
                        <p>无权操作</p><?php endif; ?>
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </table>
    </div>
</form>
<div id="footer">
版权所有 &copy; 2017-2017 ThinkPHP ZY 学习。</div>
</body>
<script>
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
window.onload=function(){

}
//渲染鼠标选中的tr行背景颜色改变
$(".tron").mouseover(function(){
    $(this).find('td').css('backgroundColor','#ccc');
});
$(".tron").mouseout(function(){
    $(this).find('td').css('backgroundColor','#fff');
});
/**
 * 将角色移至回收站时，调用此函数
 * @param  int delete_id 回收角色的ID
 */
function deletec(delete_id){
    loadXMLDoc("/Admin/Role/roleDelete/id/"+delete_id,function(){
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
                    layer.alert('该角色已被删除！',function(){
                        window.location.href = "/Admin/Role/roleList/from/roleEdit";
                        icon: 6;
                    });
                }else{
                    layer.msg(value);
                }
            });
        }
    });
}
function delete_confirm(confirm_id){
    layer.msg('确定要删除此角色？', {
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
</script>
</html>