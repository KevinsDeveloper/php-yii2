<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
        <input name="_csrf" type="hidden" id="_csrf" value="{Yii::$app->request->csrfToken}">
        <input name="redirect" type="hidden" value="{$redirect}"/>
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
</html>