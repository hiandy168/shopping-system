<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 商品品牌 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/css/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/css/main.css" rel="stylesheet" type="text/css" />
<script src="/Public/Admin/js/jquery-3.2.1.min.js"></script>
<script src="/Public/Plugins/layer/layer.js"></script>
<style>
    #tableList td{text-align:center;}
    #logo{width:50px;height:50px;border:0;}
    .tron{height:35px;}
</style>
</head>
<body>
<h1>
    <span class="action-span"><a href="/Admin/Brand/brandAdd.html">添加新品牌</a></span>
    <span class="action-span1"><a href="/Admin">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 商品品牌 </span>
    <div style="clear:both"></div>
</h1>
<div class="form-div">
    <img src="/Public/Admin/images/icon_search.gif" width="26" height="22" border="0" alt="search" />
    <input type="text" name="brand_name" size="15" id="brand_name"/>
    <input type="submit" value=" 搜索 " class="button" onclick="javascript:searchc(1,'s')"/>
</div>
<form method="post" action="" name="listForm">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1" id="tableList">
            <tr>
                <th>序号</th>
                <th>品牌名称</th>
                <th>品牌logo</th>
                <th>品牌网址</th>
                <th>品牌描述</th>
                <th>排序</th>
                <th>是否显示</th>
                <th>操作</th>
            </tr>
            <?php if(is_array($brand_list)): $i = 0; $__LIST__ = $brand_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><tr class="tron">
                    <td><?php echo ($i); ?></td>
                    <td><?php echo ($vol["brand_name"]); ?></td>
                    <td class="first-cell">
                        <a href="http://<?php echo ($vol["site_url"]); ?>" target="_brank">
                            <img src="/<?php echo ($vol["sm_logo"]); ?>" class="logo" alt="LOGO"/>
                        </a>
                    </td>
                    <td>
                        <a href="http://<?php echo ($vol["site_url"]); ?>" target="_brank"><?php echo ($vol["site_url"]); ?></a>
                    </td>
                    <td><?php echo ($vol["brand_desc"]); ?></td>
                    <td><?php echo ($vol["sort_num"]); ?></td>
                    <td><img src="<?php if(($vol["is_show"] == 是)): ?>/Public/Admin/images/yes.gif <?php else: ?>  /Public/Admin/images/no.gif<?php endif; ?>" /></td>
                    <td>
                        <a href="/Admin/Brand/brandEdit/id/<?php echo ($vol["id"]); ?>" title="编辑">编辑</a> |
                        <a href="javascript:delete_confirm(<?php echo ($vol["id"]); ?>)" title="编辑">移除</a> 
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </table>
        <table id="page-table" cellspacing="0">
            <tr>
                <td nowrap="true" colspan="6" style="text-align: center;font-size:16px;">
                    <div id="turn-page">
                        总计 <span id="totalRecords"><?php echo ($pages["totalRows"]); ?></span>
                        个记录，共分为 <span id="totalPages"><?php echo ($pages["pageNum"]); ?></span>页，每页

                        <!-- 每页条目 -->
                        <select name="rowsNum" id="rowsNum" onchange="javascript:searchc(1,'a')" onmouseover="this.style.cursor='pointer'">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                        </select>条
                        <span id="page-link">
                            <a href="javascript:searchc(1,'l')" id="first"">首页</a>

                            <a href="javascript:searchc(<?php echo ($pages["prev"]); ?>,'l')" id="prev"">上一页</a>
                            <a href="javascript:searchc(<?php echo ($pages["next"]); ?>,'r')" id="next"">下一页</a>
                            <a href="javascript:searchc(<?php echo ($pages["pageNum"]); ?>,'r')" id="pageNum"">尾页</a>
                            当前为第<select name="cur_page" id="curt_page" onchange="javascript:searchc(this.value,'a')">
                                <?php $__FOR_START_2196__=0;$__FOR_END_2196__=$pages["pageNum"];for($i=$__FOR_START_2196__;$i < $__FOR_END_2196__;$i+=1){ ?><option value="<?php echo ($i+1); ?>"><?php echo ($i+1); ?></option><?php } ?>
                            </select>页，可切换选择
                        </span>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</form>
<div id="footer">
版权所有 &copy; 2017-2017 ThinkPHP ZY 学习。</div>
</body>
<script>
var mark = '';
$('#brand_name').change(function(){
    mark = 'changed';
});
function searchc(tar_page,poi){
    //长度为2表示，当前处于列表状态，上一次查询有指定品牌名称
    if($('#brand_name').val()==''&&poi=='s'&&$('#tableList').children().children().length>2){
        layer.msg('请先输入查询品牌名称！');return;
    }
    if(poi=='s'&&mark!='changed'){
        layer.msg('条件并未改变');return;
    }
    mark = '';
    if(tar_page==$('#curt_page').val()&&poi=='r'){
        layer.msg('这已经是最后一页了');return;
    }
    if(tar_page==$('#curt_page').val()&&poi=='l'){
        layer.msg('这已经是第一页了');return;
    }
    var data = 'tar_page/'+tar_page+'/rowsNum/'+$('#rowsNum').val()+'/brand_name/'+$('#brand_name').val();
    loadXMLDoc("/Admin/Brand/brandList/"+data,function(){
        if(xhr.readyState!=4){
            //layer加载层
            layer.load(2);
            // layer.msg('请稍等！正在努力加载中！', {icon: 4});
        }
        if(xhr.readyState==4 && xhr.status==200){
            layer.closeAll();
            // console.log(xhr.responseText);
            var obj = JSON.parse(xhr.responseText);

            resetpageUrl(obj.pages,'curt_page'); //重新生成url
            resetdata(obj.brand_list);//重新生成数据

            $('#curt_page').val(tar_page);//显示当前页

            if (obj.brand_list.length==0) {
                layer.msg('啥也没查到！');return;
            }
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
/**
 * 页面加载完毕时，加载此函数
 * 主要渲染之前标签的值
 */
window.onload=function(){
    //显示默认数据
    $('#rowsNum').val(<?php echo ($pages["rowsNum"]); ?>);
    //如果传递了查询条件变量，说明是回收站后或编辑后的返回显示
    if (<?php echo ($search_condition); ?>!=null) {
        $('#curt_page').val("<?php echo ($search_condition['tar_page']); ?>");
        $('#brand_name').val("<?php echo ($search_condition['brand_name']); ?>");
    }
}
//渲染鼠标选中的tr行背景颜色改变
$(".tron").mouseover(function(){
    $(this).find('td').css('backgroundColor','#ccc');
});
$(".tron").mouseout(function(){
    $(this).find('td').css('backgroundColor','#fff');
});
function resetpageUrl(arr,tag_id){
    $("#totalRecords").html(arr.totalRows);
    $("#totalPages").html(arr.pageNum);
    $("#prev").attr('href',"javascript:searchc("+arr.prev+",'l')");
    $("#next").attr('href',"javascript:searchc("+arr.next+",'r')");
    $("#pageNum").attr('href',"javascript:searchc("+arr.pageNum+",'r')");

    $('#'+tag_id).empty();
    for(var k=1;k<=arr.pageNum;k++){
        var option = document.createElement("option");
        option.innerHTML = k;
        option.value = k;
        $('#'+tag_id).append(option);
    }
}
function resetdata(data_list){
    $('#tableList .tron').remove();
    for(var k=0;k<data_list.length;k++){
        var tr = $('<tr></tr>');tr.attr('class','tron');
        var img = $('<img/>');img.attr('alt','LOGO');img.attr('src','/'+data_list[k].sm_logo);img.attr('class','logo');
        var img2 = $('<img/>');img2.attr('src',data_list[k].is_show=='是'?"/Public/Admin/images/yes.gif":"/Public/Admin/images/no.gif");
        var td1 = $('<td></td>');
        var td2 = $('<td></td>');
        var td3 = $('<td></td>');
        var td4 = $('<td></td>');
        var td5 = $('<td></td>');
        var td6 = $('<td></td>');
        var td7 = $('<td></td>');
        var td8 = $('<td></td>');

        var a1 = $('<a></a>');
        a1.attr('href','http://'+data_list[k].site_url);
        a1.attr('target','_blank');
        var a2 = $('<a></a>');
        a2.attr('href','http://'+data_list[k].site_url);
        a2.attr('target','_blank');
        a2.html(data_list[k].site_url);
        var a3 = $('<a></a>');
        a3.attr('href',"/Admin/Brand/brandEdit/id/"+data_list[k].id);
        a3.attr('title','编辑');a3.html('编辑');
        var a4 = $('<a></a>');
        a4.attr('href',"javascript:delete_confirm("+data_list[k].id+')');
        a4.attr('title','删除');a4.html('删除');

        td1.html(k+1);tr.append(td1);
        td2.html(data_list[k].brand_name);tr.append(td2);
        a1.append(img);td3.append(a1);tr.append(td3);
        td4.append(a2);tr.append(td4);
        td5.html(data_list[k].brand_desc);tr.append(td5);
        td6.html(data_list[k].sort_num);tr.append(td6);
        td7.append(img2);tr.append(td7);

        td8.append(a3);td8.append(' | ');td8.append(a4);tr.append(td8);
        $('#tableList').append(tr);
    }
}
/**
 * 将商品移至回收站时，调用此函数
 * @param  int delete_id 回收商品的ID
 */
function deletec(delete_id){
    loadXMLDoc("/Admin/Brand/brandDelete/id/"+delete_id,function(){
        if(xhr.readyState!=4){
            //layer加载层
            layer.load(2);
            // layer.msg('请稍等！正在努力加载中！', {icon: 4});
        }
        if(xhr.readyState==4 && xhr.status==200){
            layer.closeAll('loading');
            var object=JSON.parse(xhr.responseText,function(key,value){
                if (value=='success') {
                    layer.alert('该用户已被删除！',function(){
                        window.location.href = "/Admin/Brand/brandList/from/brandEdit";
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
    layer.msg('确定要删除此用户？', {
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