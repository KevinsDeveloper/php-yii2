{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{literal}<style type="text/css">html,body,.gray-bg{background-color: #fff;}</style>{/literal}
{Html::beginForm($url, 'Post', ['id' => 'commentForm', 'class' => 'form-horizontal m-t'])}
<div class="ibox-content">

    <div class="form-group">
        <label class="col-sm-3 text-right control-label">{$attributeLabels.room_name}：</label>
        <div class="col-sm-8">
            {Html::activeTextInput($model, 'room_name', ['class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 20])}
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 text-right control-label">{$attributeLabels.room_title}：</label>
        <div class="col-sm-8">
            {Html::activeTextInput($model, 'room_title', [ 'class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 30])}
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 text-right control-label">{$attributeLabels.room_image}：</label>
        <div class="col-sm-8">
            {Html::activeTextInput($model, 'room_image', ['class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 20])}
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 text-right control-label">{$attributeLabels.room_desc}：</label>
        <div class="col-sm-8">
            {Html::activeTextarea($model, 'room_desc', [ 'class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 200, 'style'])}
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
                room_name: {
                    required: true,
                    maxlength: 20
                },
                room_title: {
                    required: true
                }
            },
            messages: {
                room_name: {
                    required: icon + "请输入房间名称",
                    minlength: icon + "房间名称20个字符内"
                },
                room_title: icon + "请输入房间标题"
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