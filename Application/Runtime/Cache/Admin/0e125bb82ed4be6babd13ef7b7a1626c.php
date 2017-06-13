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
        <form enctype="multipart/form-data" method="post" id="goodsEdit">
            <table width="90%" id="general-table" align="center" class="tab_table">
                <tr>
                    <td class="label">商品名称：</td>
                    <td><input type="text" name="goods_name" value="<?php echo ($goods_detail["goods_name"]); ?>" size="30" id="goods_name"/>
                    <span class="require-field">*</span></td>
                </tr>
                <tr>
                    <td class="label">商品货号： </td>
                    <td>
                        <input type="text" name="goods_sn" value="<?php echo ($goods_detail["goods_sn"]); ?>" size="20" id="goods_sn"/>
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
                        <?php if(is_array($goods_detail_ext_cat_list)): $i = 0; $__LIST__ = $goods_detail_ext_cat_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><li value="<?php echo ($vol["cat_id"]); ?>"> 
                                <select name="ext_cat_id[]" class="_ext_cat_id">
                                    <option value="0">请选择........</option>
                                    <?php if(is_array($cat_list)): foreach($cat_list as $key=>$val): ?><option value="<?php echo ($val["id"]); ?>" ><?php echo (str_repeat('&nbsp;&nbsp;',$val["level"])); ?>-<?php echo ($val["cat_name"]); ?></option><?php endforeach; endif; ?>
                                </select>
                                <input type="button" value="删除" onclick="$(this).parent().remove();"/>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
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
                        <span>当前logo</span>
                        <img src="/<?php echo ($goods_detail["sm_logo"]); ?>"/><br/>
                        <input type="file" name="logo" size="35" id="logo" onmouseover="this.style.cursor='pointer'"/>
                    </td>
                </tr>
                <tr>
                    <td class="label">本店售价：</td>
                    <td>
                        <input type="text" name="shop_price" value="<?php echo ($goods_detail["shop_price"]); ?>" size="20" id="shop_price"/>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">市场售价：</td>
                    <td>
                        <input type="text" name="market_price" value="<?php echo ($goods_detail["market_price"]); ?>" size="20" />
                    </td>
                </tr>
                <tr>
                    <td class="label">商品数量：</td>
                    <td>
                        <input type="text" name="goods_number" size="8" value="<?php echo ($goods_detail["goods_number"]); ?>" id="goods_number"/>
                    </td>
                </tr>
                <tr>
                    <td class="label">是否上架：</td>
                    <td>
                        <input type="radio" name="is_on_sale" value="是" id='is_on_sale_1'/> 是
                        <input type="radio" name="is_on_sale" value="否" id='is_on_sale_0'/> 否
                    </td>
                </tr>
                <tr>
                    <td class="label">是否促销：</td>
                    <td>
                        促销价：￥<input type="text" name="promote_price" id="promote_price" value="<?php echo ($goods_detail["promote_price"]); ?>" size="8"/>元<br/>
                        开始时间：<input type="text" name="promote_start_date" id="promote_start_date" value="<?php echo ($goods_detail["promote_start_date"]); ?>"/><br/>
                        结束时间：<input type="text" name="promote_end_date" id="promote_end_date" value="<?php echo ($goods_detail["promote_end_date"]); ?>"/>
                    </td>
                </tr>
                <tr>
                    <td class="label">加入推荐：</td>
                    <td>
                        <input type="checkbox" name="is_best" value="1" id="is_best"/> 精品 
                        <input type="checkbox" name="is_new" value="1" id="is_new"/> 新品 
                        <input type="checkbox" name="is_hot" value="1" id="is_hot"/> 热销
                    </td>
                </tr>
                <tr>
                    <td class="label">推荐排序：</td>
                    <td>
                        <input type="text" name="sort_num" size="5" value="<?php echo ($goods_detail["sort_num"]); ?>"/>
                    </td>
                </tr>
            </table>
            <!-- 其他信息 -->
            <table width="90%" align="center" class="tab_table" style="display:none;">
                <tr>
                    <td class="label">会员价格：</td>
                    <td>
                        <?php if(is_array($goods_detail_member_price_list)): $i = 0; $__LIST__ = $goods_detail_member_price_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><span style="width:50px"><?php echo ($vol["level_name"]); ?>：￥</span><input type="text" name="member_price[<?php echo ($vol["level_id"]); ?>]" value="<?php echo ($vol["price"]); ?>"><br/><?php endforeach; endif; else: echo "" ;endif; ?>
                    </td>
                </tr>
                <tr>
                    <td class="label">商品简单描述：</td>
                    <td>
                        <textarea id="goods_desc" name="goods_desc" cols="40" rows="3"><?php echo ($goods_detail["goods_desc"]); ?></textarea>
                    </td>
                </tr>
            </table>
            <!-- 商品属性 -->
            <table style="display:none;" width="90%" class="tab_table" align="center">
                <tr>
                    <td>
                        类型选择：<select name="type_id" id="type_id">
                            <option value="0">请选择--</option>
                            <?php if(is_array($type_list)): $i = 0; $__LIST__ = $type_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vol["id"]); ?>"><?php echo ($vol["type_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><ul id="attr_list">
                    <!-- 循环遍历商品属性信息 -->
                        <?php if(is_array($gaData)): $i = 0; $__LIST__ = $gaData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i; if(in_array($vol['attr_id'],$attrid)): $opt = '-'; ?>
                            <?php else: ?>
                                <?php $opt = '+';$attrid[] = $vol['attr_id']; endif; ?>
                            <li>
                                <input type="hidden" name="goods_attr_id[]" value="<?php echo ($vol["goods_attr_id"]); ?>">
                                <!-- 如果是可选，则前面加个[+] -->
                                <?php if($vol["attr_type"] == '可选'): ?><a onclick="addNewAttr(this);" href="#">[<?php echo ($opt); ?>]</a><?php endif; ?>
                                <!-- 输出属性名 -->
                                <?php echo ($vol["attr_name"]); ?>
                                <!-- 如果属性可选值不为空，则输出select下拉框 -->
                                <?php if($vol["attr_option_values"] != ''): ?><!-- 先将属性可选值字符串转化为数组 -->
                                    <?php $attr = explode(',',$vol['attr_option_values']); ?>
                                    <select name="attr_value[<?php echo ($vol["id"]); ?>][]" id="">
                                        <option value="">请选择--</option>
                                        <!-- 遍历此数组，并选中此属性值 -->
                                        <?php if(is_array($attr)): foreach($attr as $key=>$val): if($val == $vol['attr_value']): $select = 'selected="selected"'; ?>
                                                <?php else: ?>
                                                    <?php $select = ''; endif; ?>
                                            <option <?php echo ($select); ?> value="<?php echo ($val); ?>"><?php echo ($val); ?></option><?php endforeach; endif; ?>
                                    </select>
                                <?php else: ?>
                                    <input type="text" name="attr_value[<?php echo ($vol["id"]); ?>][]" value="<?php echo ($vol["attr_value"]); ?>"/><?php endif; ?>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul></td>
                </tr>
            </table>
            <!-- 商品相册 -->
            <table style="display:none;" width="100%" class="tab_table" align="center">
                <tr>
                    <td style="float:left;">已存在相册：</td>
                    <?php if(is_array($goods_detail_goods_pic_list)): $i = 0; $__LIST__ = $goods_detail_goods_pic_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><td style="float:left;" >
                            <img style="float:left;margin-bottom:2px" src="/<?php echo ($vol["sm_pic"]); ?>""/><br/>
                            <input type="hidden" name="old_pic[<?php echo ($vol["id"]); ?>]" value="<?php echo ($vol["id"]); ?>"/>
                            <input type="button" onclick="$(this).parent().remove();" value="删除"/>
                        </td><?php endforeach; endif; else: echo "" ;endif; ?>
                </tr>
                <tr><td><hr /></td></tr>
                <tr>
                <td>
                    <input id="btn_add_pic" type="button" value="添加一张" />
                    <hr />
                    <ul id="ul_pic_list"></ul>
                </td>
                </tr>
            </table>
            <div class="button-div">
                <input type="hidden" name="id" value="<?php echo ($goods_detail["id"]); ?>"/>
                <input type="submit" value=" 确 定 " class="button" onmouseover="this.style.cursor='pointer'"/>
                <input style="width:63px;height:20px" type="bubtton" value=" 返 回 " class="button" onclick="location='/Admin/Goods/goodsList/from/goodsEdit'" onmouseover="this.style.cursor='pointer'"/>
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
var form = document.getElementById('goodsEdit');
form.onsubmit = function(evt){
    //收集表单域信息
    var data = new FormData(this);
    loadXMLDoc(data,"/Admin/Goods/goodsEdit",function(){
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
                    layer.alert('商品信息更新成功！',function(){
                        window.location.href = "/Admin/Goods/goodsList/from/goodsEdit";
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
}
UM.getEditor('goods_desc',{
    initialFrameWidth:'100%', //初始化编辑器宽度
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
$('#btn_add_cat').click(function(){add_cat_ids()});
$("#btn_add_pic").click(function(){add_pic_ids()});
// 添加一个扩展分类
function add_cat_ids(){
    //每按一次按钮，将第一个select标签复制一个放到最后
    $('#ext_cat').append($('#ext_cat').find('li').eq(0).clone());
    //定义一个input按钮用于删除添加的扩展分类
    var input = $('<input type="button" value="删除"/>');
    input.click(function(){
        $(this).parent().remove()
    });
    $('#ext_cat').children().last().append(input);
}
// 添加一张相片
function add_pic_ids(){
    var file = '<li><input type="file" name="pic[]" /></li>';
    $("#ul_pic_list").append(file);
    var input = $('<input type="button" value="删除"/>');
    input.click(function(){
        $(this).parent().remove();
    });
    $('#ul_pic_list').children().last().append(input);
}
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
function addNewAttr(a){
    // $(a)  --> 把a转换成jquery中的对象，然后才能调用jquery中的方法
    // 先获取所在的li
    var li = $(a).parent();
    if($(a).text() == '[+]'){
        var newLi = li.clone();
        //去掉选中状态
        newLi.find('option:selected').removeAttr('selected');
        //清空隐藏域
        newLi.find("input[name='goods_attr_id[]']").val('');
        // +变-
        newLi.find("a").text('[-]');
        // 新的放在li后面
        li.after(newLi);
    }else{
        // 先获取这个属性值的id
        var gaid = li.find("input[name='goods_attr_id[]']").val();
        // 如果没有ID就直接删除，如果有ID说明是旧的属性值需要AJAX删除
        if(gaid == ''){
            li.remove();
        }else{
            if(confirm('如果删除了这个属性，那么相关的库存量数据也会被一起删除，确定要删除吗？'))
            {
                $.ajax({
                    type : "GET",
                    url : "<?php echo U('ajaxDelAttr?goods_id='.$data['id'], '', FALSE); ?>/gaid/"+gaid,
                    success : function(data)
                    {
                        // 再把页面中的记录删除
                        li.remove();
                        layer.msg('删除成功！');
                    }
                });
            }
        }
    }
}
//渲染默认被选择的单选框和复选框
window.onload=function(){
    if("<?php echo ($goods_detail["is_on_sale"]); ?>"=='是'){
        $('#is_on_sale_1').attr('checked','true');
    }else if("<?php echo ($goods_detail["is_on_sale"]); ?>"=='否'){
        $('#is_on_sale_0').attr('checked','true');
    }
    if("<?php echo ($goods_detail["is_best"]); ?>"=='是'){
        $('#is_best').attr('checked','true');
    }
    if("<?php echo ($goods_detail["is_new"]); ?>"=='是'){
        $('#is_new').attr('checked','true');
    }
    if("<?php echo ($goods_detail["is_hot"]); ?>"=='是'){
        $('#is_hot').attr('checked','true');
    }
    $('#brand_id').val("<?php echo ($goods_detail["brand_id"]); ?>");
    $('#cat_id').val("<?php echo ($goods_detail["cat_id"]); ?>");
    //这里选择将select的value值暂放在父类元素ul上，然后再赋值
    $('._ext_cat_id').each(function(){
        $(this).val($(this).parent().val());
    });
    //展示指定商品的属性
    $('#type_id').val("<?php echo ($goods_detail["type_id"]); ?>");
}
</script>

<div id="footer">
版权所有 &copy; 2017-2017 ThinkPHP ZY 学习。</div>
</body>
</html>