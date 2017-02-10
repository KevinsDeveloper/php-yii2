<?php /* Smarty version Smarty-3.1.20, created on 2017-02-09 09:54:28
         compiled from "/app/yii-giant/app/admin/app/themes/views/site/login/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:239612775589c1b5a217099-01857695%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0946cab7c583c69ce929d0ca8c8c171a6ced7183' => 
    array (
      0 => '/app/yii-giant/app/admin/app/themes/views/site/login/index.tpl',
      1 => 1486634065,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '239612775589c1b5a217099-01857695',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.20',
  'unifunc' => 'content_589c1b5a23fee2_95928036',
  'variables' => 
  array (
    'redirect' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_589c1b5a23fee2_95928036')) {function content_589c1b5a23fee2_95928036($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>YiiGiant-Admin</title>
<link href="/themes/css/login.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="login">
    <div>
        <h1 class="logo-name">YiiGiant</h1>
    </div>
    <form class="m-t" id="login-form" role="form" method="post" action="/site/login/do">
        <input name="_csrf" type="hidden" id="_csrf" value="<?php echo Yii::$app->request->csrfToken;?>
">
        <input name="redirect" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['redirect']->value;?>
"/>
        <div class="form-group clearfix">
            <input type="text" name="account" id="account" class="form-control" placeholder="帐号" size="30" required>
        </div>
        <div class="form-group clearfix">
            <input type="password" name="passwd" id="pass" class="form-control" placeholder="密码" size="30" required>
        </div>
        <div class="form-group clearfix">
            <input type="input" name="captcha" class="form-control" placeholder="验证码" size="6" maxlength="6" required style="width:40%; float:left;">    
            <img class="captcha" src="/site/login/captcha" onclick="this.src='/site/login/captcha?t=' + Math.random();" title="看不清楚？点击切换">
        </div>
        <br/>
        <button type="button" class="btn btn-primary">登 录</button>
        <div class="alert alert-danger alert-dismissable login-error"></div>
    </form>
</div>
<!-- jQuery Validation plugin javascript-->
<script src="/plugins/validate/jquery-2.1.1.min.js"></script>
<script src="/plugins/validate/jquery.validate.min.js"></script>
<script src="/plugins/validate/messages_zh.min.js"></script>
<script type="text/javascript">
    var button = $(".btn"), form = $("#login-form"), captcha = $(".captcha"), account = $("#account"), pass = $("#pass"), swalalert = $(".alert");
    var divalert = function (msg) {
        swalalert.html(msg).fadeIn();
        setTimeout(function () {
                    swalalert.fadeOut();
                },
                2000);
        button.removeClass("btn-default").addClass("btn-primary").html('登 录');
        button.attr("disabled", false);
        return true;
    };
    // 执行登录ajax
    function loginin() {
        // 登陆按钮
        button.removeClass("btn-primary").addClass("btn-default").html('正在登陆...');
        button.attr("disabled", true);

        if ($.trim(account.val()) == '' || $.trim(pass.val()) == '') {
            return divalert('抱歉，请输入正确的登录信息');
        }
        $.ajax({
            url: form.attr("action"),
            type: "post",
            dataType: "json",
            data: form.serialize(),
            success: function (ret) {
                if (ret.status == 1) {
                    location.href = ret.data.tourl;
                } else {
                    captcha.click();
                    return divalert(ret.msg);
                }
            },
            error: function (error) {
                captcha.click();
                return divalert('抱歉，请求登录异常');
            }
        });
    }
    $(function () {
        $("#login-form").validate();
        // 表单回车事件
        form.keydown(function (event) {
            if (event.keyCode == 13) {
                return loginin();
            }
        });
        // 登录按钮事件
        button.on("click", function () {
            return loginin();
        });
    });
</script>
</body>
</html><?php }} ?>
