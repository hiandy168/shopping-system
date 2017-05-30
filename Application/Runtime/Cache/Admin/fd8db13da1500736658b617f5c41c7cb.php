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
    #face{width:30px;height:30px;border:0;}
    .tron{height:35px;}
</style>
</head>
<body>
<h1>
    <span class="action-span"><a href="/Admin/User/userAdd.html">添加会员</a></span>
    <span class="action-span1"><a href="/Admin">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 会员列表 </span>
    <div style="clear:both"></div>
</h1>
<div class="form-div">
    <img src="/Public/Admin/images/icon_search.gif" width="26" height="22" border="0" alt="search" />
    <input type="text" name="username" size="15" id="username"/>
    <input type="button" value=" 搜索 " class="button" onclick="javascript:searchc(1,'s')"/>
</div>
<form method="post" action="" name="listForm">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1" id="tableList">
            <tr id="table_first">
                <th>序号</th>
                <th>用户名</th>
                <th>用户密码</th>
                <th>头像</th>
                <th>积分</th>
                <th>操作</th>
            </tr>
            <?php if(is_array($user_list)): $i = 0; $__LIST__ = $user_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><tr class="tron">
                    <td><?php echo ($i); ?></td>
                    <td><?php echo ($vol["username"]); ?></td>
                    <td><?php echo ($vol["password"]); ?></td>
                    <td>
                        <img src="/<?php echo ($vol["sm_face"]); ?>" class="face" alt="头像"/>
                    </td>
                    <td><?php echo ($vol["jifen"]); ?></td>
                    <td>
                        <a href="/Admin/User/userEdit/id/<?php echo ($vol["id"]); ?>" title="编辑">编辑</a> |
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
                                <?php $__FOR_START_5207__=0;$__FOR_END_5207__=$pages["pageNum"];for($i=$__FOR_START_5207__;$i < $__FOR_END_5207__;$i+=1){ ?><option value="<?php echo ($i+1); ?>"><?php echo ($i+1); ?></option><?php } ?>
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
$('#username').change(function(){
    mark = 'changed';
});
function searchc(tar_page,poi){
    //长度为2表示，当前处于列表状态，上一次查询有指定用户名
    if($('#username').val()==''&&poi=='s'&&$('#tableList').children().children().length>2){
        layer.msg('请先输入查询用户名！');return;
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
    var data = 'tar_page/'+tar_page+'/rowsNum/'+$('#rowsNum').val()+'/username/'+$('#username').val();
    loadXMLDoc("/Admin/User/userList/"+data,function(){
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
            resetdata(obj.user_list);//重新生成数据

            $('#curt_page').val(tar_page);//显示当前页

            if (obj.user_list.length==0) {
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
        $('#username').val("<?php echo ($search_condition['username']); ?>");
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
        var tr = $('<tr></tr>');
        tr.attr('class','tron');
        var img = $('<img/>');img.attr('alt','头像');img.attr('src','/'+data_list[k].sm_face);
        var td1 = $('<td></td>');
        var td2 = $('<td></td>');
        var td3 = $('<td></td>');
        var td4 = $('<td></td>');
        var td5 = $('<td></td>');
        var td6 = $('<td></td>');

        var a1 = $('<a></a>');
        a1.attr('href',"/Admin/User/userEdit/id/"+data_list[k].id);
        a1.attr('title','编辑');a1.html('编辑');
        var a2 = $('<a></a>');
        a2.attr('href',"javascript:delete_confirm("+data_list[k].id+')');
        a2.attr('title','删除');a2.html('删除');

        td1.html(k+1);tr.append(td1);
        td2.html(data_list[k].username);tr.append(td2);
        td3.html(data_list[k].password);tr.append(td3);
        td4.append(img);tr.append(td4);
        td5.html(data_list[k].jifen);tr.append(td5);

        td6.append(a1);td6.append(' | ');td6.append(a2);tr.append(td6);
        $('#tableList').append(tr);
    }
}
/**
 * 将商品移至回收站时，调用此函数
 * @param  int delete_id 回收商品的ID
 */
function deletec(delete_id){
    loadXMLDoc("/Admin/User/userDelete/id/"+delete_id,function(){
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
                        window.location.href = "/Admin/User/userList/from/userEdit";
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