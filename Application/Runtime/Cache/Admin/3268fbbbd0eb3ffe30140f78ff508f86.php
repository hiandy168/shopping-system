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
    <span class="action-span"><a href="/Admin/Goods/<?php echo ($_URL_); ?>.html"><?php echo ($_btn_name); ?></a></span>
    <span class="action-span1"><a href="/Admin">商城后台 管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo ($_page_title); ?></span>
    <div style="clear:both"></div>
</h1>


<div class="form-div">
    <ol>
        <span>筛选：</span>
        <!-- 分类 -->
        <select name="cat_id" id="cat_search" onchange="javascript:searchc(1,'a')" onmouseover="this.style.cursor='pointer'">
            <option value="0">所有分类</option>
            <?php if(is_array($cat_list)): $i = 0; $__LIST__ = $cat_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vol["id"]); ?>"><?php echo (str_repeat('&nbsp;&nbsp;',$vol["level"])); ?>-<?php echo ($vol["cat_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
        <!-- 品牌 -->
        <select name="brand_id" id="brand_search" onchange="javascript:searchc(1,'a')" onmouseover="this.style.cursor='pointer'">
            <option value="0">所有品牌</option>
            <?php if(is_array($brand_list)): $i = 0; $__LIST__ = $brand_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vol["id"]); ?>"><?php echo ($vol["brand_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
        <!-- 推荐 -->
        <select name="intro_type" id="type_search" onchange="javascript:searchc(1,'a')" onmouseover="this.style.cursor='pointer'">
            <option value="is_all">全部推荐</option>
            <option value="is_best">精品</option>
            <option value="is_new">新品</option>
            <option value="is_hot">热销</option>
        </select>
        <!-- 上架 -->
        <select name="is_on_sale" id="sale_search" onchange="javascript:searchc(1,'a')" onmouseover="this.style.cursor='pointer'">
            <option value='is_all'>全部商品</option>
            <option value="1">上架</option>
            <option value="0">下架</option>
        </select>
        <!-- 每页条目 -->
        <select name="rowsNum" id="rowsNum" onchange="javascript:searchc(1,'a')" onmouseover="this.style.cursor='pointer'">
            <option value="1">每页1条</option>
            <option value="2">每页2条</option>
            <option value="3">每页3条</option>
            <option value="4">每页4条</option>
            <option value="5">每页5条</option>
            <option value="6">每页6条</option>
            <option value="7">每页7条</option>
            <option value="8">每页8条</option>
            <option value="9">每页9条</option>
            <option value="10">每页10条</option>
        </select>
    </ol>
    <ol>
        <span>价格区间：</span>
        <input type="number" placeholder="价格下限" style="width:60px;text-align:center;" id="price_low" onkeyup="javascript:searchc(1,'a')"/> —
        <input type="number" placeholder="价格上限" style="width:60px;text-align:center;" id="price_up" onkeyup="javascript:searchc(1,'a')"/>

        <input type="radio" value="price_natural" name="radio" class="price_order_by" id="price_natural"/>默认排序
        <input type="radio" value="price_asc" name="radio" class="price_order_by" id="price_asc"/>升序
        <input type="radio" value="price_desc" name="radio" class="price_order_by" id="price_desc"/>降序       
    </ol>
    <ol>
        <span>时间区间：</span>
        <input type="text" placeholder="请选择起始时间" id="time_start"> —
        <input type="text" placeholder="请选择终止时间" id="time_end">
    </ol>
    <ol>
    <span>以上改变会自动搜索，也可以点击这里：</span>
        <!-- 关键字 -->
    <!--     关键字 <input type="text" name="keyword" size="15" id="keywords"/> -->
        <input style="cursor:pointer;width:60px;text-align:center;background:url('/Public/Admin/images/icon_search.gif') no-repeat;" type="button" value="  搜 索" class="button" id="search" onclick="javascript:searchc(1,'s')""/>
    </ol>
</div>

<!-- 商品列表 -->
<form method="post" action="" name="listForm" onsubmit="">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1" id='tableList'>
            <tr>
                <th>编号</th>
                <th>商品名称</th>
                <th>品牌</th>
                <th>分类</th>
                <th>扩展分类</th>
                <th>LOGO</th>>
                <th>货号</th>
                <th>添加时间</th>
                <th>价格</th>
                <th>上架</th>
                <th>精品</th>
                <th>新品</th>
                <th>热销</th>
                <th>推荐排序</th>
                <th>库存</th>
                <th>操作</th>
            </tr>
            <?php if(is_array($goods_list)): $i = 0; $__LIST__ = $goods_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><tr class="tron">
                <td><?php echo ($i); ?></td>
                <td><?php echo ($vol["goods_name"]); ?></td>
                <td><?php echo ($vol["brand_name"]); ?></td>
                <td><?php echo ($vol["cat_name"]); ?></td>
                <td><?php echo ($vol["ext_cat_name"]); ?></td>
                <td><img src="/<?php echo ($vol["sm_logo"]); ?>"/></td>
                <td><?php echo ($vol["goods_sn"]); ?></td>
                <td><?php echo ($vol["addtime"]); ?></td>
                <td><?php echo ($vol["shop_price"]); ?></td>
                <td><img src="<?php if(($vol["is_on_sale"] == 是)): ?>/Public/Admin/images/yes.gif <?php else: ?>  /Public/Admin/images/no.gif<?php endif; ?>"/></td>
                <td><img src="<?php if(($vol["is_best"] == 是)): ?>/Public/Admin/images/yes.gif <?php else: ?> /Public/Admin/images/no.gif<?php endif; ?>"/></td>
                <td><img src="<?php if(($vol["is_new"] == 是)): ?>/Public/Admin/images/yes.gif <?php else: ?> /Public/Admin/images/no.gif<?php endif; ?>"/></td>
                <td><img src="<?php if(($vol["is_hot"] == 是)): ?>/Public/Admin/images/yes.gif <?php else: ?> /Public/Admin/images/no.gif<?php endif; ?>"/></td>
                <td><?php echo ($vol["sort_num"]); ?></td>
                <td><?php echo ($vol["goods_number"]); ?></td>
                <td>
                <a href="/Admin/Goods/goodsNum/id/<?php echo ($vol["id"]); ?>" title="库存"><img src="/Public/Admin/images/icon_view.gif" width="16" height="16" border="0" /></a>
                <a href="/Admin/Goods/goodsEdit/id/<?php echo ($vol["id"]); ?>" title="编辑"><img src="/Public/Admin/images/icon_edit.gif" width="16" height="16" border="0" /></a>
                <a href="javascript:trash_confirm(<?php echo ($vol["id"]); ?>)" title="回收站" id="goodsToTrash"><img src="/Public/Admin/images/icon_trash.gif" width="16" height="16" border="0" /></a></td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </table>

    <!-- 分页开始 -->
        <table id="page-table" cellspacing="0">
            <tr id="pagesfoot">
                <td colspan=12 style="text-align: center;font-size:16px;">
                    <a href="javascript:searchc(1,'l')" id="first"">首页</a>

                    <a href="javascript:searchc(<?php echo ($pages["prev"]); ?>,'l')" id="prev"">上一页</a>
                    <a href="javascript:searchc(<?php echo ($pages["next"]); ?>,'r')" id="next"">下一页</a>
                    <a href="javascript:searchc(<?php echo ($pages["pageNum"]); ?>,'r')" id="pageNum"">尾页</a>
                    <span id="pageNum1">当前共有<?php echo ($pages["pageNum"]); ?>页，当前为第</span>

                    <select name="cur_page" id="curt_page" onchange="javascript:searchc(this.value,'a')">
<<<<<<< HEAD
                        <?php $__FOR_START_621__=0;$__FOR_END_621__=$pages["pageNum"];for($i=$__FOR_START_621__;$i < $__FOR_END_621__;$i+=1){ ?><option value="<?php echo ($i+1); ?>"><?php echo ($i+1); ?></option><?php } ?>
=======
                        <?php $__FOR_START_26248__=0;$__FOR_END_26248__=$pages["pageNum"];for($i=$__FOR_START_26248__;$i < $__FOR_END_26248__;$i+=1){ ?><option value="<?php echo ($i+1); ?>"><?php echo ($i+1); ?></option><?php } ?>
>>>>>>> 50a6ed1e9d8ead543ca117b99304dee76f9da7d7
                    </select>页，可切换选择
                </td>
            </tr>
        </table>
    <!-- 分页结束 -->
    </div>
</form>
<!-- 时间插件 -->
<link href="/Public/Plugins/datetimepicker/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="utf-8" src="/Public/Plugins/datetimepicker/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/Plugins/datetimepicker/datepicker-zh_cn.js"></script>
<link rel="stylesheet" media="all" type="text/css" href="/Public/Plugins/datetimepicker/time/jquery-ui-timepicker-addon.min.css" />
<script type="text/javascript" src="/Public/Plugins/datetimepicker/time/jquery-ui-timepicker-addon.min.js"></script>
<script type="text/javascript" src="/Public/Plugins/datetimepicker/time/i18n/jquery-ui-timepicker-addon-i18n.min.js"></script>
<script>
//前期为原生js代码
var cat_search = document.getElementById('cat_search');
var brand_search = document.getElementById('brand_search');
var type_search = document.getElementById('type_search');
var sale_search = document.getElementById('sale_search');
var curt_page = document.getElementById('curt_page');
var prev = document.getElementById('prev');
var next = document.getElementById('next');
var rowsNum = document.getElementById('rowsNum');
var pageNum = document.getElementById('pageNum');
var pageNum1 = document.getElementById('pageNum1');
var tableList = document.getElementById('tableList');
var price_low = document.getElementById('price_low');
var price_up = document.getElementById('price_up');
var time_start = document.getElementById('time_start');
var time_end = document.getElementById('time_end');
var price_order_by = document.getElementsByClassName('price_order_by');
//渲染鼠标选中的tr行背景颜色改变
$(".tron").mouseover(function(){
    $(this).find('td').css('backgroundColor','#ccc');
});
$(".tron").mouseout(function(){
    $(this).find('td').css('backgroundColor','#fff');
});
var xhr;
/**
 * 用于查询数据的函数，页面所有连接调用此函数，根据不同的条件，调用ajax向服务器查询数据
 * @param  int tar_page 目标页码，用于分页查询，不翻页默认都是传递1
 */
function searchc(tar_page,poi){
    if(tar_page==curt_page.value&&poi=='r'){
        layer.msg('这已经是最后一页了');return;
    }
    if(tar_page==curt_page.value&&poi=='l'){
        layer.msg('这已经是第一页了');return;
    }
    if(parseInt(price_low.value) > parseInt(price_up.value)){
        layer.tips('请搞清楚上限和下限谁大！','#price_low',{tips:[1,'#0FA6D8']});return;
    }
    var data = 'tar_page/'+tar_page+'/cat_id/'+cat_search.value+'/brand_id/'+brand_search.value+'/intro_type/'+type_search.value+'/rowsNum/'+rowsNum.value+'/is_on_sale/'+sale_search.value;
    data += price_low.value!==''?'/price_low/'+price_low.value:'';
    data += price_up.value!==''?'/price_up/'+price_up.value:'';
    data += time_start.value!==''?'/time_start/'+time_start.value:'';
    data += time_end.value!==''?'/time_end/'+time_end.value:'';
    if (price_order_by[0].checked==false) {
        data += price_order_by[1].checked==true?'/price_order/'+price_order_by[1].value:'/price_order/'+price_order_by[2].value;
    }else{
        data += '/price_order/'+price_order_by[0].value;
    }
    loadXMLDoc("/Admin/Goods/goodsList/"+data,function(){
        if(xhr.readyState!=4){
            //layer加载层
            layer.load(2);
            // layer.msg('请稍等！正在努力加载中！', {icon: 4});
        }
        if(xhr.readyState==4 && xhr.status==200){
            layer.closeAll();//关闭所有弹出层
            // console.log(xhr.responseText);return;
            var obj = JSON.parse(xhr.responseText);
            resetpageUrl(obj.pages);
            resetpageNum(curt_page,obj.pages.pageNum);
            curt_page.value = tar_page;
            resetdata(tableList,obj.goods_list);
            if (obj.goods_list.length==0) {
                layer.msg('啥也没查到！');return;
            }
        }
    });
}
/**
 * 将商品移至回收站时，调用此函数
 * @param  int delete_id 回收商品的ID
 */
function deletec(delete_id){
    loadXMLDoc("/Admin/Goods/goodsToTrash/id/"+delete_id,function(){
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
                    layer.alert('商品信息已移至回收站！',function(){
                        window.location.href = "/Admin/Goods/goodsList/from/goodsEdit";
                        icon: 6;
                    });
                }else if(key!=''){
                    layer.tips(value, '#'+key, {tipsMore: true});
                }
            });
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
    rowsNum.value = <?php echo ($pages["rowsNum"]); ?>;
    price_order_by[0].checked = 'checked';
    //如果传递了查询条件变量，说明是回收站后或编辑后的返回显示
    if (<?php echo ($search_condition); ?>!=null) {
        $('#cat_search').val("<?php echo ($search_condition['cat_id']); ?>");
        $('#brand_search').val("<?php echo ($search_condition['brand_id']); ?>");
        $('#type_search').val("<?php echo ($search_condition['intro_type']); ?>");
        $('#sale_search').val("<?php echo ($search_condition['is_on_sale']); ?>");
        $('#price_low').val("<?php echo ($search_condition['price_low']); ?>");
        $('#price_up').val("<?php echo ($search_condition['price_up']); ?>");
        $('#time_start').val("<?php echo ($search_condition['time_start']); ?>");
        $('#time_end').val("<?php echo ($search_condition['time_end']); ?>");
        $(".price_order_by[value=<?php echo ($search_condition['price_order']); ?>]").attr("checked",true);
        $('#curt_page').val("<?php echo ($search_condition['tar_page']); ?>");
    }

}
/**
 * 重新生成分页的链接
 * @param  array arr 获取的页码信息数组
 */
function resetpageUrl(arr){
    prev.href="javascript:searchc("+arr.prev+",'l')";
    next.href="javascript:searchc("+arr.next+",'r')";
    pageNum.href="javascript:searchc("+arr.pageNum+",'r')";
    pageNum1.innerHTML="当前共有"+arr.pageNum+"页，当前为第";
}
/**
 * 用于重新生成跳转页码的select标签
 * @param  object   tag_id      select标签对象
 * @param  int      pageNum     总页数
 * @return null                 直接渲染生成标签
 */
function resetpageNum(tag_id,pageNum){
    var n = tag_id.children.length;
    for(var i=0;i<n;i++){
        tag_id.children[0].parentNode.removeChild(tag_id.children[0]);
    }
    for(var k=1;k<=pageNum;k++){
        var option = document.createElement("option");
        option.innerHTML = k;
        option.value = k;
        tag_id.appendChild(option);
    }
}
/**
 * 用于重新生成查询得到的数据
 * @param  string tag_id    渲染数据的父标签id
 * @param  array data_list  查询得到的数据
 */
function resetdata(tag_id,data_list){
    var n = tag_id.children[0].children.length;
    for(var i=1;i<n;i++){
        //找到table下tr里的td，从其父元素中依次移除第二个，因为移除一个，之前的第三个就成了第二个
        tag_id.children[0].children[0].parentNode.removeChild(tag_id.children[0].children[1]);
    }
    for(var k=0;k<data_list.length;k++){
        var img1 = document.createElement("img");
        var img2 = document.createElement("img");
        var img3 = document.createElement("img");
        var img4 = document.createElement("img");
        var img5 = document.createElement("img");
        var img6 = document.createElement("img");
        var img7 = document.createElement("img");
        var img8 = document.createElement("img");
        img1.src = '/'+data_list[k].sm_logo;
        img2.src = data_list[k].is_on_sale=='是'?"/Public/Admin/images/yes.gif":"/Public/Admin/images/no.gif";
        img3.src = data_list[k].is_best=='是'?"/Public/Admin/images/yes.gif":"/Public/Admin/images/no.gif";
        img4.src = data_list[k].is_new=='是'?"/Public/Admin/images/yes.gif":"/Public/Admin/images/no.gif";
        img5.src = data_list[k].is_hot=='是'?"/Public/Admin/images/yes.gif":"/Public/Admin/images/no.gif";
        img6.src = "/Public/Admin/images/icon_view.gif";
        img7.src = "/Public/Admin/images/icon_edit.gif";
        img8.src = "/Public/Admin/images/icon_trash.gif";
        img6.width="16"; img6.height="16"; img6.border="0";
        img7.width="16"; img7.height="16"; img7.border="0";
        img8.width="16"; img8.height="16"; img8.border="0";
        var tr = document.createElement("tr");
        tr.class="tron";
        var td1 = document.createElement("td");
        td1.innerHTML = k+1;
        tr.appendChild(td1);

        var td2 = document.createElement("td");
        td2.innerHTML = data_list[k].goods_name;
        tr.appendChild(td2);

        var td14 = document.createElement("td");
        td14.innerHTML = data_list[k].brand_name;
        tr.appendChild(td14);

        var td15 = document.createElement("td");
        td15.innerHTML = data_list[k].cat_name;
        tr.appendChild(td15);

        var td16 = document.createElement("td");
        td16.innerHTML = data_list[k].ext_cat_name;
        tr.appendChild(td16);

        var td3 = document.createElement("td");
        td3.appendChild(img1);
        tr.appendChild(td3);

        var td4 = document.createElement("td");
        td4.innerHTML = data_list[k].goods_sn;
        tr.appendChild(td4);

        var td13 = document.createElement("td");
        td13.innerHTML = data_list[k].addtime;
        tr.appendChild(td13);

        var td5 = document.createElement("td");
        td5.innerHTML = data_list[k].shop_price;
        tr.appendChild(td5);

        var td6 = document.createElement("td");
        td6.appendChild(img2);
        tr.appendChild(td6);

        var td7 = document.createElement("td");
        td7.appendChild(img3);
        tr.appendChild(td7);

        var td8 = document.createElement("td");
        td8.appendChild(img4);
        tr.appendChild(td8);

        var td9 = document.createElement("td");
        td9.appendChild(img5);
        tr.appendChild(td9);

        var td10 = document.createElement("td");
        td10.innerHTML = data_list[k].sort_num;
        tr.appendChild(td10);

        var td11 = document.createElement("td");
        td11.innerHTML = data_list[k].goods_number;
        tr.appendChild(td11);

        var td12 = document.createElement("td");
            var a1 = document.createElement("a");
            a1.title="库存";a1.href="/Admin/Goods/goodsNum/id/"+data_list[k].id;
            a1.appendChild(img6);
            td12.appendChild(a1);

            var a2 = document.createElement("a");
            a2.title="编辑";a2.href="/Admin/Goods/goodsEdit/id/"+data_list[k].id;
            a2.appendChild(img7);
            td12.appendChild(a2);

            var a3 = document.createElement("a");
            a3.title="回收站";a3.href="javascript:trash_confirm("+data_list[k].id+")";
            a3.id="goodsToTrash";
            a3.appendChild(img8);
            td12.appendChild(a3);
        tr.appendChild(td12);
        tag_id.children[0].appendChild(tr);
    }
}
// 使用插件优化时间输入框
$.timepicker.setDefaults($.timepicker.regional['zh-CN']);
$('#time_start').datetimepicker();
$('#time_end').datetimepicker();
/**
 * 点击回收按钮时，调用此函数确认操作
 * @param  int confirm_id 要删除商品的ID
 */
function trash_confirm(confirm_id){
    layer.msg('确定移至回收站？', {
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

<div id="footer">
版权所有 &copy; 2017-2017 ThinkPHP ZY 学习。</div>
</body>
</html>