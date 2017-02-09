{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{literal}<style type="text/css">html,body,.gray-bg{background-color: #fff;}</style>{/literal}
{Html::beginForm($url, 'Post', ['id' => 'commentForm', 'class' => 'form-horizontal m-t'])}
<div class="ibox-content">
    <div class="form-group">
        <label class="col-sm-3 text-right control-label">{$attributeLabels.group_id}：</label>
        <div class="col-sm-3">
            {Html::activeDropDownList($model, 'group_id', $groups, ['class' => 'form-control'])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 text-right control-label">{$attributeLabels.user_name}：</label>
        <div class="col-sm-8">
            {Html::activeTextInput($model, 'user_name', ['class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 20])}
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 text-right control-label">{$attributeLabels.real_name}：</label>
        <div class="col-sm-8">
            {Html::activeTextInput($model, 'real_name', [ 'class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 20])}
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 text-right control-label">{$attributeLabels.nickname}：</label>
        <div class="col-sm-8">
            {Html::activeTextInput($model, 'nickname', ['class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 20])}
        </div>
    </div>
    
    <div class="form-group">
        <label class="col-sm-3 text-right control-label">{$attributeLabels.sex}：</label>
        <div class="col-sm-8">
            {Html::activeRadioList($model, 'sex', ['1' => '男', '0' => '女'], ['select' => '1'])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 text-right control-label">{$attributeLabels.mobile}：</label>
        <div class="col-sm-8">
            {Html::activeTextInput($model, 'mobile', ['class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 11])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 text-right control-label">{$attributeLabels.email}：</label>
        <div class="col-sm-8">
            {Html::activeTextInput($model, 'email', ['class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 100])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 text-right control-label">{$attributeLabels.birthday}：</label>
        <div class="col-sm-8">
            {Html::activeTextInput($model, 'birthday', ['type' => 'password','class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 20])}
        </div>
    </div>
</div>
<div class="footer-div"></div>
<div class="form-footer">
    <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i> 提交 </button>
    <button class="btn btn-danger" type="button" id="close"><i class="fa fa-times-circle"></i> 取消</button>
</div>
{Html::endForm()}
<!-- jQuery Validation plugin javascript-->
<script src="/js/plugins/validate/jquery.form.min.js"></script>
<script src="/js/plugins/validate/jquery.validate.min.js"></script>
<script src="/js/plugins/validate/messages_zh.min.js"></script>
<script>
    var index = parent.layer.getFrameIndex(window.name);
    $("#pass").keydown(function (event) {
        if (event.keyCode == 8) {
            return $(this).val('');
        }
    });
    // 关闭layer
    $("#close").click(function(){
        parent.layer.close(index);
    });

    //以下为官方示例
    $().ready(function () {
        var icon = "<i class='fa fa-times-circle'></i> ";
        // validate the comment form when it is submitted
        $("#commentForm").validate({
            rules: {
                user_name: {
                    required: true,
                    maxlength: 20
                },
                real_name: {
                    required: true,maxlength: 20
                },
                mobile: {
                    required: true,minlength: 11,maxlength: 11
                },
                birthday: {
                    required: true,
                    minlength: 6,
                    maxlength: 20
                },
            },
            messages: {
                user_name: {
                    required: icon + "请输入用户名",
                    minlength: icon + "用户名20个字符内"
                },
                real_name: {
                    required: icon + "请输入真实姓名",
                    minlength: icon + "用户名20个字符内"
                },
                mobile: {
                    required: icon + "请输入11位手机号码",
                    minlength: icon + "请输入11位手机号码"
                },
                birthday: {
                    required: icon + "请输入6-20位登录密码",
                    minlength: icon + "请输入6-20位登录密码"
                }
            },
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    dataType:"json", //数据类型
                    success:function(data){ //提交成功的回调函数
                        // parent.layer.alert(data.msg);
                        if (data.status == 1) {
                            parent.location.reload();
                            parent.layer.close(index);
                        } else {
                            parent.layer.alert(data.msg);
                        }
                    },
                    error: function() {
                        parent.layer.alert('抱歉，提交失败');
                    }
                });
            }
        });
    });
</script>