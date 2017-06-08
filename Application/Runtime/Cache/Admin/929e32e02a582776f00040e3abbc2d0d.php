<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 商品库存 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/css/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/css/main.css" rel="stylesheet" type="text/css" />
<script src="/Public/Admin/js/jquery-3.2.1.min.js"></script>
<script src="/Public/Plugins/layer/layer.js"></script>
<style>
    #tableList td{text-align:center;}
    .tron{height:35px;}
</style>
</head>
<body>
<h1>
    <span class="action-span"><a href="/Admin/Goods/goodsNumberAdd.html">添加新库存</a></span>
    <span class="action-span1"><a href="/Admin">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 商品库存 </span>
    <div style="clear:both"></div>
</h1>
<form method="post" action="" name="listForm">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1" id="tableList">
            <tr>
                <?php if(is_array($gaData)): $i = 0; $__LIST__ = $gaData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><th><?php echo ($key); ?></th><?php endforeach; endif; else: echo "" ;endif; ?>
                <th>库存量</th>
                <th>操作</th>
            </tr>
                <tr class="tron">
                    <?php if(is_array($gaData)): $i = 0; $__LIST__ = $gaData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><td>
                            <select>
                                <option value="">请选择--</option>
                                <?php if(is_array($val)): $i = 0; $__LIST__ = $val;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vul): $mod = ($i % 2 );++$i;?><option value=""><?php echo ($vul[]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </td><?php endforeach; endif; else: echo "" ;endif; ?>
                    <td></td>
                    <td>
                        <a href="/Admin/Goods/goodsNumberEdit/id/<?php echo ($vol["id"]); ?>" title="编辑">编辑</a> |
                        <a href="javascript:delete_confirm(<?php echo ($vol["id"]); ?>)" title="编辑">移除</a> 
                    </td>
                </tr>
        </table>
    </div>
</form>
<div id="footer">
版权所有 &copy; 2017-2017 ThinkPHP ZY 学习。</div>
</body>
<script>
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
/**
 * 页面加载完毕时，加载此函数
 * 主要渲染之前标签的值
 */
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
 * 将商品移至回收站时，调用此函数
 * @param  int delete_id 回收商品的ID
 */
function deletec(delete_id){
    loadXMLDoc("/Admin/Goods/goodsNumberDelete/id/"+delete_id,function(){
        if(xhr.readyState!=4){
            //layer加载层
            layer.load(2);
            // layer.msg('请稍等！正在努力加载中！', {icon: 4});
        }
        if(xhr.readyState==4 && xhr.status==200){
            layer.closeAll('loading');
            var object=JSON.parse(xhr.responseText,function(key,value){
                if (value=='success') {
                    layer.alert('该库存已被删除！',function(){
                        window.location.href = "/Admin/Goods/goodsNumberList/from/goodsNumberEdit";
                        icon: 6;
                    });
                }else if(key!=''){
                    layer.tips(value, '#'+key, {tipsMore: true});
                }
            });
        }
    });
}
function delete_confirm(confirm_id){
    layer.msg('确定要删除此库存？', {
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