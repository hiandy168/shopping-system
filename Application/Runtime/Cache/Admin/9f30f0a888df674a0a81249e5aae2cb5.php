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
    <span class="action-span"><a href="/Admin/Attribute/<?php echo ($_URL_); ?>.html"><?php echo ($_btn_name); ?></a></span>
    <span class="action-span1"><a href="/Admin">商城后台 管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo ($_page_title); ?></span>
    <div style="clear:both"></div>
</h1>



<!-- 搜索 -->
<div class="form-div search_form_div">
		<p>
			属性名称：
	   		<input type="text" name="attr_name" size="30" value="" id="attr_name"/>
		</p>
		<p>
			属性类型：
			<input type="radio" value="-1" name="attr_type" id="attr_type_all"/> 全部 
			<input type="radio" value="0" name="attr_type" id="attr_type_unique"/> 唯一 
			<input type="radio" value="1" name="attr_type" id="attr_type_choose"/> 可选 
		</p>
		<p>
			所属类型Id：
	   		<input type="text" name="type_id" size="30" value="<?php echo ($type_id); ?>" id="type_id"/>
		</p>
		<p><input style="cursor:pointer;width:60px;text-align:center;background:url('/Public/Admin/images/icon_search.gif') no-repeat;" type="button" value="  搜 索" class="button" id="search" onclick="javascript:searchc(1,'s')""/></p>
</div>
<!-- 列表 -->
<div class="list-div" id="listDiv">
	<table cellpadding="3" cellspacing="1" id="tableList">
    	<tr>
            <th >属性名称</th>
            <th >属性类型</th>
            <th >属性可选值</th>
            <th >所属类型Id</th>
			<th width="60">操作</th>
        </tr>
		<?php if(is_array($attribute_list)): $i = 0; $__LIST__ = $attribute_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><tr class="tron">
				<td><?php echo ($vol["attr_name"]); ?></td>
				<td><?php echo ($vol["attr_type"]); ?></td>
				<td><?php echo ($vol["attr_option_values"]); ?></td>
				<td><?php echo ($vol["type_id"]); ?></td>
		        <td align="center">
                	<a href="/Admin/Attribute/attributeEdit/id/<?php echo ($vol["id"]); ?>/type_id/<?php echo ($vol["type_id"]); ?>">编辑</a> |
                	<a href="javascript:delete_confirm(<?php echo ($vol["id"]); ?>)" title="移除" onclick="">移除</a>
		        </td>
	        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
	</table>
</div>
<script>
function searchc(tar_page,poi){
	var data = 'act/search';
    data += $('#attr_name').val()!==''?'/attr_name/'+$('#attr_name').val():'';
    data += $('#type_id').val()!==''?'/type_id/'+$('#type_id').val():'';
    if ($('#attr_type_all').is(':checked')==false) {
        data += $('#attr_type_unique').is(':checked')==true?'/attr_type/'+$('#attr_type_unique').val():'/attr_type/'+$('#attr_type_choose').val();
    }
    loadXMLDoc("/Admin/Attribute/attributeList/"+data,function(){
        if(xhr.readyState!=4){
            //layer加载层
            layer.load(2);
            // layer.msg('请稍等！正在努力加载中！', {icon: 4});
        }
        if(xhr.readyState==4 && xhr.status==200){
            layer.closeAll();
            // console.log(xhr.responseText);
            var obj = JSON.parse(xhr.responseText);

            resetdata(obj.attribute_list);//重新生成数据
            $('#attrAddUrl').attr('href',"/Admin/Attribute/attributeAdd/type_id/"+$('#type_id').val());
            if (obj.attribute_list.length==0) {
                layer.msg('啥也没查到！');return;
            }
        }
    });
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
    loadXMLDoc("/Admin/Attribute/attributeDelete/id/"+delete_id,function(){
        if(xhr.readyState!=4){
            //layer加载层
            layer.load(2);
            // layer.msg('请稍等！正在努力加载中！', {icon: 4});
        }
        if(xhr.readyState==4 && xhr.status==200){
            layer.closeAll('loading');
            console.log(xhr.responseText);
            var object=JSON.parse(xhr.responseText,function(key,value){
                if (value=='success') {
                    layer.alert('指定属性已被删除！',function(){
                        window.location.href = "/Admin/Attribute/attributeList/from/attributeEdit/type_id/<?php echo ($type_id); ?>";
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
    layer.msg('确定要删除此属性？', {
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
function resetdata(data_list){
    $('#tableList .tron').remove();
    for(var k=0;k<data_list.length;k++){
        var tr = $('<tr></tr>');tr.attr('class','tron');
        var td1 = $('<td></td>');
        var td2 = $('<td></td>');
        var td3 = $('<td></td>');
        var td4 = $('<td></td>');
        var td5 = $('<td></td>');

        var a1 = $('<a></a>');
        a1.attr('href',"/Admin/Attribute/attributeEdit/id/"+data_list[k].id+'/type_id/'+data_list[k].type_id);
        a1.attr('title','编辑');a1.html('编辑');
        var a2 = $('<a></a>');
        a2.attr('href',"javascript:delete_confirm("+data_list[k].id+')');
        a2.attr('title','删除');a2.html('删除');

        td1.html(data_list[k].attr_name);tr.append(td1);
        td2.html(data_list[k].attr_type);tr.append(td2);
        td3.html(data_list[k].attr_option_values);tr.append(td3);
        td4.html(data_list[k].type_id);tr.append(td4);

        td5.append(a1);td5.append(' | ');td5.append(a2);tr.append(td5);
        $('#tableList').append(tr);
    }
}
window.onload=function(){
	$('#attr_type_all').attr('checked','checked');
}
</script>

<div id="footer">
版权所有 &copy; 2017-2017 ThinkPHP ZY 学习。</div>
</body>
</html>