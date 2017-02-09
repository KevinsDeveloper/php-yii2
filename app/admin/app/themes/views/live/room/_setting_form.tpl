{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{literal}<style type="text/css">html,body,.gray-bg{background-color: #fff;}</style>{/literal}
{Html::beginForm($url, 'Post', ['id' => 'commentForm', 'class' => 'form-horizontal m-t'])}
<div class="ibox-content">
    <div class="form-group">
        <label class="col-sm-3 text-right control-label">房间状态：</label>
        <div class="col-sm-8">
            {Html::activeRadioList($model, 'status', ['1' => '开启', '0' => '关闭'], ['select' => '1'])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 text-right control-label">关闭提示：</label>
        <div class="col-sm-8">
            {Html::activeTextInput($model, 'room_shutup_msg', ['class' => 'form-control', 'required' => false, 'aria-required' => 'false', 'size' => 60])}
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 text-right control-label">{$attributeLabels.site_title}：</label>
        <div class="col-sm-8">
            {Html::activeTextInput($model, 'site_title', [ 'class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 100])}
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 text-right control-label">{$attributeLabels.site_keyword}：</label>
        <div class="col-sm-8">
            {Html::activeTextInput($model, 'site_keyword', ['class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 100])}
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 text-right control-label">{$attributeLabels.site_desc}：</label>
        <div class="col-sm-8">
            {Html::activeTextInput($model, 'site_desc', [ 'class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 100])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 text-right control-label">{$attributeLabels.site_notice}：</label>
        <div class="col-sm-8">
            {Html::activeTextInput($model, 'site_notice', [ 'class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 100])}
        </div>
    </div>
     <div class="form-group">
        <label class="col-sm-3 text-right control-label">游客限制：</label>
        <div class="col-sm-8">
            {Html::activeRadioList($model, 'guest_limit', ['1' => '游客不准进入', '0' => '不限制'], ['select' => '0'])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 text-right control-label">用户限制：</label>
        <div class="col-sm-8">
            {Html::activeRadioList($model, 'user_limit', ['1' => '激活用户可进入', '0' => '不限制'], ['select' => '0'])}
            用户净值：{Html::activeTextInput($model, 'user_limit_networth', [ 'class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 15])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 text-right control-label">{$attributeLabels.rtmp}：</label>
        <div class="col-sm-8">
            {Html::activeTextInput($model, 'rtmp', [ 'class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 100])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 text-right control-label">{$attributeLabels.hls}：</label>
        <div class="col-sm-8">
            {Html::activeTextInput($model, 'hls', [ 'class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 100])}
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