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
    <span class="action-span"><a href="/Admin/Goods/<?php echo ($_URL_); ?>.html"><?php echo ($_btn_name); ?></a></span>
    <span class="action-span1"><a href="/Admin">商城后台 管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo ($_page_title); ?></span>
    <div style="clear:both"></div>
</h1>


    <form method="post" action="" name="listForm" id="goodsNum">
        <div class="list-div" id="listDiv">
            <table cellpadding="3" cellspacing="1" id="tableList">
                <tr>
                    <?php if(is_array($gaData)): $i = 0; $__LIST__ = $gaData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><th><?php echo ($key); ?></th><?php endforeach; endif; else: echo "" ;endif; ?>
                    <th>库存量</th>
                    <th>操作</th>
                </tr>
                <?php $gnnum = count($gnData); ?>
                <?php if($gnnum!=0): if(is_array($gnData)): $k = 0; $__LIST__ = $gnData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sd): $mod = ($k % 2 );++$k;?><tr class="tron">
                            <?php if(is_array($gaData)): $i = 0; $__LIST__ = $gaData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><td>
                                    <select name="goods_attr_id[]">
                                        <option value="">请选择--</option>
                                        <?php if(is_array($val)): $i = 0; $__LIST__ = $val;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vul): $mod = ($i % 2 );++$i; $_attr = explode(',', $sd['goods_attr_id']); if(in_array($vul['id'], $_attr)) $select = 'selected="selected"'; else $select = ''; ?>
                                            <option <?php echo ($select); ?> value="<?php echo ($vul["id"]); ?>"><?php echo ($vul['attr_value']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                </td><?php endforeach; endif; else: echo "" ;endif; ?>
                            <td><input type="text" name="goods_number[]" value="<?php echo ($sd["goods_number"]); ?>"/></td>
                            <?php $mrk = $k==1?'+':'-'; ?>
                            <td><input onclick="addNewTr(this)" type="button" value="<?php echo ($mrk); ?>"/></td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                <?php else: ?>
                    <tr class="tron">
                        <?php if(is_array($gaData)): $i = 0; $__LIST__ = $gaData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><td>
                                <select name="goods_attr_id[]">
                                    <option value="">请选择--</option>
                                    <?php if(is_array($val)): $i = 0; $__LIST__ = $val;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vul): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vul["id"]); ?>"><?php echo ($vul['attr_value']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </td><?php endforeach; endif; else: echo "" ;endif; ?>
                        <td><input type="text" name="goods_number[]" value="<?php echo ($sd["goods_number"]); ?>"/></td>
                        <td><input onclick="addNewTr(this)" type="button" value="+"/></td>
                    </tr><?php endif; ?>
                <tr id="submit">
                    <?php $num = count($gaData)+2; ?>
                    <td style="text-align: center" colspan="<?php echo ($num); ?>"><input type="submit" value="提交"/></td>
                </tr>
            </table>
        </div>
    </form>

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
    var form = document.getElementById('goodsNum');
    form.onsubmit = function(evt){
        //收集表单域信息
        var data = new FormData(this);
        loadXMLDoc(data,"/Admin/Goods/goodsNum/id/<?php echo ($goods_id); ?>",function(){
            if(xhr.readyState!=4){
                //layer加载层
                layer.load(2);
                // layer.msg('请稍等！正在努力加载中！', {icon: 4});
            }
            if(xhr.readyState==4 && xhr.status==200){
                layer.closeAll('loading');
                var object=JSON.parse(xhr.responseText,function(key,value){
                    console.log(key,value);
                    if (value=='success') {
                        layer.alert('商品库存信息更新成功！',function(){
                            window.location.href = "/Admin/Goods/goodsList/from/goodsEdit";
                            icon: 6;
                        });
                    }else if(key!=''){
                        layer.tips(value, '#'+key, {tipsMore: true});
                    }
                });
            }
        });
        evt.preventDefault();
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
        loadXMLDoc("id/"+delete_id,"/Admin/Goods/goodsNumDelete/",function(){
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
                            window.location.href = "/Admin/Goods/goodsNum/from/goodsNumEdit";
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
    function addNewTr(btn){
        var tr = $(btn).parent().parent();
        if($(btn).val() == "+"){
            var newTr = tr.clone();
            newTr.find(":button").val("-");
            $("#submit").before(newTr);
        }else{
            tr.remove();
        }
    }
</script>

<div id="footer">
版权所有 &copy; 2017-2017 ThinkPHP ZY 学习。</div>
</body>
</html>