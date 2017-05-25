<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/css/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/css/main.css" rel="stylesheet" type="text/css" />
<script src="/Public/Admin/js/jquery-3.2.1.min.js"></script>
<script src="/Public/Plugins/layer/layer.js"></script>
</head>
<body style="background: #278296;color:white">
<form method="post" id="loginform">
    <table cellspacing="0" cellpadding="0" style="margin-top:100px" align="center">
        <tr>
            <td>
                <img src="/Public/Admin/images/login.png" width="178" height="256" border="0" alt="ECSHOP" />
            </td>
            <td style="padding-left: 50px">
                <table>
                    <tr>
                        <td>管理员姓名：</td>
                        <td>
                            <input type="text" id="username" name="username" placeholder="请输入用户名" onblur="check(this.value,this.id)" autofocus="autofocus"/>
                        </td>
                    </tr>
                    <tr>
                        <td>管理员密码：</td>
                        <td>
                            <input type="password" id="password" name="password" placeholder="请输入密码" onblur="check(this.value,this.id)"/>
                        </td>
                    </tr>
                    <tr>
                        <td>验证码：</td>
                        <td>
                            <input type="text" id="captcha" name="captcha" class="capital" placeholder="请输入验证码" onblur="check(this.value,this.id)"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right">
                            <img src="/Admin/Manager/Verify" onclick="this.src='/Admin/Manager/Verify/'+Math.random()"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input type="checkbox" value="1" name="remember" id="remember" />
                            <label for="remember">请保存我这次的登录信息。</label>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            <input type="submit" value="进入管理中心" class="button" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
  <input type="hidden" name="act" value="signin" />
</form>
</body>
<script>
    var xmlhttp;
    function loadXMLDoc(data,cfunc){
        if(window.XMLHttpRequest){
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }else{
            // code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=cfunc;
        xmlhttp.open("get","/Admin/Manager/"+data,true);
        xmlhttp.send(null);
    }
    function check(value,id){
        if (value=='') {
            if (id=='username') {var tag='用户名';}else if(id=='captcha'){var tag='验证码';}else if(id=='password'){var tag='密码';}
            layer.tips(tag+'不能为空', '#'+id, {tips: 1});
            return;
        }
        if(id=='captcha'){
            input_value = encodeURIComponent(value);
            loadXMLDoc('check/'+id+'/'+input_value,function(){
                if(xmlhttp.readyState==4 && xmlhttp.status==200){
                    layer.tips(eval(xmlhttp.responseText), '#'+id, {tips: 2});
                }
            });
        }
    }
    var loginform = document.getElementById('loginform');
    loginform.onsubmit = function(evt){
        //收集表单域信息
        var data = new FormData(this);
        if(window.XMLHttpRequest){
            // code for IE7+, Firefox, Chrome, Opera, Safari
            var xhr = new XMLHttpRequest();
        }else{
            // code for IE6, IE5
            var xhr = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xhr.onreadystatechange=function(){
            if(xhr.readyState==4 && xhr.status==200){
                var object=JSON.parse(xhr.responseText,function(key,value){
                    if (value=='success') {
                        window.location.href = "/Admin/Index/index";
                    }else if(key!=''){
                        layer.tips(value, '#'+key, {tipsMore: true});
                    }
                });
            }
        }
        xhr.open("post","/Admin/Manager/login",true);
        // xhr.setRequestHeader("content-type","application/x-www-form-urlencode");
        xhr.send(data);
        evt.preventDefault();
    }
</script>
</html>