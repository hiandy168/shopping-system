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



<div class="tab-div">
    <div id="tabbar-div">
        <p>
            <span class="tab-front" id="tab-first">基本信息</span>
            <span class="tab-back">其他信息</span>
            <span class="tab-back">商品属性</span>
            <span class="tab-back">商品相册</span>
        </p>
    </div>
    <div id="tabbody-div">
        <form enctype="multipart/form-data" method="post" id="goodsAdd">
            <table width="90%" id="general-table" align="center" class="tab_table">
                <tr>
                    <td class="label">商品名称：</td>
                    <td><input type="text" name="goods_name" value="" size="30" id="goods_name"/>
                    <span class="require-field">*</span></td>
                </tr>
                <tr>
                    <td class="label">商品货号： </td>
                    <td>
                        <input type="text" name="goods_sn" value="" size="20" id="goods_sn"/>
                        <span id="goods_sn_notice"></span><br />
                        <span class="notice-span"id="noticeGoodsSN">如果您不输入商品货号，系统将自动生成一个唯一的货号。</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">商品分类：</td>
                    <td>
                        <select name="cat_id" id="cat_id">
                            <option value="0">请选择........</option>
                            <?php if(is_array($cat_list)): foreach($cat_list as $key=>$val): ?><option value="<?php echo ($val["id"]); ?>"><?php echo (str_repeat('&nbsp;&nbsp;',$val["level"])); ?>-<?php echo ($val["cat_name"]); ?></option><?php endforeach; endif; ?>
                        </select>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">扩展分类：</td>
                    <td>
                        <input type="button" id="btn_add_cat" value="添加一个" /><br/>
                        <ul id="ext_cat">
                            <li> 
                                <select name="ext_cat_id[]" id="ext_cat_id">
                                    <option value="0">请选择........</option>
                                    <?php if(is_array($cat_list)): foreach($cat_list as $key=>$val): ?><option value="<?php echo ($val["id"]); ?>"><?php echo (str_repeat('&nbsp;&nbsp;',$val["level"])); ?>-<?php echo ($val["cat_name"]); ?></option><?php endforeach; endif; ?>
                                </select>
                            </li> 
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td class="label">商品品牌：</td>
                    <td>
                        <select name="brand_id" id="brand_id">
                            <option value="0">请选择...</option>
                            <?php if(is_array($brand_list)): foreach($brand_list as $key=>$val): ?><option value="<?php echo ($val["id"]); ?>"><?php echo ($val["brand_name"]); ?></option><?php endforeach; endif; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label">商品LOGO：</td>
                    <td>
                        <input type="file" name="logo" size="35" id="logo" onmouseover="this.style.cursor='pointer'"/>
                    </td>
                </tr>
                <tr>
                    <td class="label">本店售价：</td>
                    <td>
                        <input type="text" name="shop_price" value="" size="20" id="shop_price"/>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">市场售价：</td>
                    <td>
                        <input type="text" name="market_price" value="" size="20" />
                    </td>
                </tr>
                <tr>
                    <td class="label">商品数量：</td>
                    <td>
                        <input type="text" name="goods_number" size="8" value="" id="goods_number"/>
                    </td>
                </tr>
                <tr>
                    <td class="label">是否上架：</td>
                    <td>
                        <input type="radio" name="is_on_sale" value="是" checked="true"/> 是
                        <input type="radio" name="is_on_sale" value="否"/> 否
                    </td>
                </tr>
                <tr>
                    <td class="label">是否推荐到楼层：</td>
                    <td>
                        <input type="radio" name="is_floor" value="是"/> 是
                        <input type="radio" name="is_floor" value="否" checked="true"/> 否
                    </td>
                </tr>
                <tr>
                    <td class="label">是否促销：</td>
                    <td>
                        促销价：￥<input type="text" name="promote_price" id="promote_price" size="8"/>元<br/>
                        开始时间：<input type="text" name="promote_start_date" id="promote_start_date"/><br/>
                        结束时间：<input type="text" name="promote_end_date" id="promote_end_date"/>
                    </td>
                </tr>
                <tr>
                    <td class="label">加入推荐：</td>
                    <td>
                        <input type="checkbox" name="is_best" value="1" /> 精品 
                        <input type="checkbox" name="is_new" value="1" /> 新品 
                        <input type="checkbox" name="is_hot" value="1" /> 热销
                    </td>
                </tr>
                <tr>
                    <td class="label">推荐排序：</td>
                    <td>
                        <input type="text" name="sort_num" size="5" value="100"/>
                    </td>
                </tr>
            </table>
            <!-- 其他信息 -->
            <table width="90%" align="center" class="tab_table" style="display:none;">
                <tr>
                    <td class="label">会员价格：</td>
                    <td>
                       <?php if(is_array($member_level_list)): $i = 0; $__LIST__ = $member_level_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><span><?php echo ($vol["level_name"]); ?>：￥</span><input type="text" name="member_price[<?php echo ($vol["id"]); ?>]" value=""><br/><?php endforeach; endif; else: echo "" ;endif; ?>
                    </td>
                </tr>
                <tr>
                    <td class="label">商品描述：</td>
                    <td>
                        <textarea id="goods_desc" name="goods_desc" cols="40" rows="3"></textarea>
                    </td>
                </tr>
            </table>
            <!-- 商品属性 -->
            <table style="display:none;" width="90%" class="tab_table" align="center">
                <tr>
                    <td>
                        类型选择：<select name="type_id" id="type_id">
                            <option value="">请选择--</option>
                            <?php if(is_array($type_list)): $i = 0; $__LIST__ = $type_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vol["id"]); ?>"><?php echo ($vol["type_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><ul id="attr_list"></ul></td>
                </tr>
            </table>
            <!-- 商品相册 -->
            <table style="display:none;" width="100%" class="tab_table" align="center">
                <tr>
                <td>
                    <input id="btn_add_pic" type="button" value="添加一张" />
                    <hr />
                    <ul id="ul_pic_list"></ul>
                </td>
                </tr>
            </table>
            <div class="button-div">
                <input type="submit" value=" 确 定 " class="button" onmouseover="this.style.cursor='pointer'"/>
                <input type="reset" value=" 重 置 " class="button" onmouseover="this.style.cursor='pointer'"/>
            </div>
        </form>
    </div>
</div>
<!-- 时间插件 -->
<link href="/Public/Plugins/datetimepicker/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="utf-8" src="/Public/Plugins/datetimepicker/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/Plugins/datetimepicker/datepicker-zh_cn.js"></script>
<link rel="stylesheet" media="all" type="text/css" href="/Public/Plugins/datetimepicker/time/jquery-ui-timepicker-addon.min.css" />
<script type="text/javascript" src="/Public/Plugins/datetimepicker/time/jquery-ui-timepicker-addon.min.js"></script>
<script type="text/javascript" src="/Public/Plugins/datetimepicker/time/i18n/jquery-ui-timepicker-addon-i18n.min.js"></script>
<script>
$('#goodsAdd').submit(function(evt){
    //收集表单域信息
    console.log(this);
    var data = new FormData(this);
    console.log(data);
    loadXMLDoc(data,"/Admin/Goods/goodsAdd",function(){
        if(xhr.readyState!=4){
            //layer加载层
            layer.load(2);
            // layer.msg('请稍等！正在努力加载中！', {icon: 4});
        }
        if(xhr.readyState==4 && xhr.status==200){
            layer.closeAll('loading');
            var object=JSON.parse(xhr.responseText,function(key,value){
                if (value=='success') {
                    layer.alert('新商品添加成功！',function(){
                        window.location.href = "/Admin/Goods/goodsList";
                        icon: 6;
                    });
                }else if(key!=''){
                    curChange(0,$('#tab-first'));
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
//优化文本编辑框
UM.getEditor('goods_desc',{
    initialFrameWidth:'80%', //初始化编辑器宽度
    initialFrameHeight:150  //初始化编辑器高度
});
// 使用插件优化时间输入框
$.timepicker.setDefaults($.timepicker.regional['zh-CN']);
$('#promote_start_date').datetimepicker();
$('#promote_end_date').datetimepicker();
/*****************切换table的代码******************/
$('#tabbar-div p span').click(function(){
    //电机的是第几个按钮
    var i = $(this).index();
    curChange(i,this);
});
//出现错误提示时，控制回到表格第一栏
function curChange(i,w){
    //县隐藏所有的table
    $('.tab_table').hide();
    //再将指定的table显示出来
    $('.tab_table').eq(i).show();
    //同时先将所有按钮的样式改为tab-back
    $('.tab-front').removeClass('tab-front').addClass('tab-back');
    //再将点击的那个按钮的样式改为tab-front
    $(w).removeClass('tab-back').addClass('tab-front');
}
// 添加一个扩展分类
$('#btn_add_cat').click(function(){
    //每按一次按钮，将第一个select标签复制一个放到最后
    $('#ext_cat').append($('#ext_cat').find('li').eq(0).clone());
    //定义一个input按钮用于删除添加的扩展分类
    var input = $('<input type="button" value="删除"/>');
    input.click(function(){
        $(this).parent().remove()
    });
    $('#ext_cat').children().last().append(input);
});
// 添加一张相片
$("#btn_add_pic").click(function(){
    var file = '<li><input type="file" name="pic[]" /></li>';
    $("#ul_pic_list").append(file);
    var input = $('<input type="button" value="删除"/>');
    input.click(function(){
        $(this).parent().remove()
    });
    $('#ul_pic_list').children().last().append(input);
});
// 选择类型获取属性的AJAX
$("select[name=type_id]").change(function(){
    // 获取当前选中的类型的id
    var typeId = $(this).val();
    // 如果选择了一个类型就执行AJAX取属性
    if(typeId > 0)
    {
        // 根据类型ID执行AJAX取出这个类型下的属性，并获取返回的JSON数据
        $.ajax({
            type : "GET",
            url : "<?php echo U('ajaxGetAttr', '', FALSE); ?>/type_id/"+typeId,
            dataType : "json",
            success : function(data)
            {
                /** 把服务器返回的属性循环拼成一个LI字符串，并显示在页面中 **/
                var li = "";
                // 循环每个属性
                $(data).each(function(k,v){
                    li += '<li>';
                    
                    // 如果这个属性类型是可选的就有一个+
                    if(v.attr_type == '可选')
                        li += '<a onclick="addNewAttr(this);" href="#">[+]</a>';
                    // 属性名称
                    li += v.attr_name + ' : ';  
                    // 如果属性有可选值就做下拉框，否则做文本框
                    if(v.attr_option_values == "")
                        li += '<input type="text" name="attr_value['+v.id+'][]" />';
                    else
                    {
                        li += '<select name="attr_value['+v.id+'][]"><option value="">请选择...</option>';
                        // 把可选值根据,转化成数组
                        var _attr = v.attr_option_values.split(',');
                        // 循环每个值制作option
                        for(var i=0; i<_attr.length; i++)
                        {
                            li += '<option value="'+_attr[i]+'">';
                            li += _attr[i];
                            li += '</option>';
                        }
                        li += '</select>';
                    }
                        
                    li += '</li>'
                });
                // 把拼好的LI放到 页面中
                $("#attr_list").html(li);
            }
        });
    }
    else
        $("#attr_list").html("");  // 如果选的是请 选择就直接清空
});

// 点击属性的+号
function addNewAttr(a)
{
    // $(a)  --> 把a转换成jquery中的对象，然后才能调用jquery中的方法
    // 先获取所在的li
    var li = $(a).parent();
    if($(a).text() == '[+]')
    {
        var newLi = li.clone();
        // +变-
        newLi.find("a").text('[-]');
        // 新的放在li后面
        li.after(newLi);
    }
    else
        li.remove();
}
</script>

<div id="footer">
版权所有 &copy; 2017-2017 ThinkPHP ZY 学习。</div>
</body>
</html>