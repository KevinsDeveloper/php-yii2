{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{literal}
    <style type="text/css">html, body, .gray-bg {
            background-color: #fff;
        }</style>
{/literal}
{Html::beginForm($url, 'Post', ['id' => 'commentForm', 'class' => 'form-horizontal m-t', 'options' => ['enctype' => 'multipart/form-data']])}
<div class="ibox-content">
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.type}：</label>
        <div class="col-sm-8">
            {Html::activeRadioList($model, 'type', Yii::$app->params['adstype'], ['unselect' => 0])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.name}：</label>
        <div class="col-sm-4">
            {Html::activeTextInput($model, 'name', ['class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 20])}
            {Html::hiddenInput('id', $model.id)}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.orderby}：</label>
        <div class="col-sm-4">
            {Html::activeTextInput($model, 'orderby', ['class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 20])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.image}：</label>
        <div class="col-sm-4">
            {Html::activeTextInput($model, 'image', ['class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'readonly' => 'readonly '])}
        </div>
        <div class="col-sm-3" id="col-input">
            <span class="btn btn-primary file-btn">选择图片 <input type="file" id="file" name="file"></span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.url}：</label>
        <div class="col-sm-4">
            {Html::activeTextInput($model, 'url', ['class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 20])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.start}：</label>
        <div class="col-sm-4">
            {if !empty($model->start)}{$start = $model->start}{else}{$start = time()}{/if}
            {Html::activeTextInput($model, 'start', ['value' => date('Y-m-d H:i:s',$start),'id' => 'stime', 'class' => 'form-control layer-date', 'required' => true, 'aria-required' => 'true', 'size' => 20])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.end}：</label>
        <div class="col-sm-4">
            {if !empty($model->end)}{$end = $model->end}{else}{$end = time()}{/if}
            {Html::activeTextInput($model, 'end', ['value' => date('Y-m-d H:i:s',$end),'id' => 'etime', 'class' => 'form-control layer-date', 'required' => true, 'aria-required' => 'true', 'size' => 20])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.sitetype}：</label>
        <div class="col-sm-8">
            {Html::activeRadioList($model, 'sitetype', ['1' => 'PC'], ['unselect' => 1])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.isshow}：</label>
        <div class="col-sm-8">
            {Html::activeRadioList($model, 'isshow', ['1' => '显示', '0' => '隐藏'], ['unselect' => 1])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.status}：</label>
        <div class="col-sm-8">
            {Html::activeRadioList($model, 'status', ['1' => '开启', '0' => '关闭'], ['unselect' => 1])}
        </div>
    </div>
</div>
<div class="footer-div"></div>
<div class="form-footer">
    <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i> 提交</button>
    <button class="btn btn-danger" type="button" id="close"><i class="fa fa-times-circle"></i> 取消</button>
</div>
{Html::endForm()}
<!-- jQuery Validation plugin javascript-->
<script src="/js/plugins/validate/jquery.form.min.js"></script>
<script src="/js/plugins/validate/jquery.validate.min.js"></script>
<script src="/js/plugins/validate/messages_zh.min.js"></script>
<script type="text/javascript" src="/js/ajaxfileupload.js"></script>
<link rel="stylesheet" type="text/css" href="/js/time/jquery.datetimepicker.css"/ >
<script src="/js/time/jquery.datetimepicker.js"></script>
<script type="text/javascript">
    $(function () {
        $('#stime').datetimepicker.ShowCheckBox = true;
        $('#stime').datetimepicker({
            lang: 'ch',
            validateOnBlur: false,
        });
        $('#etime').datetimepicker({
            lang: 'ch',
            validateOnBlur: false,
        });
    });
</script>
<script>
    var UPLOAD_URL = '{Url::toRoute(["/content/uploader/index"])}';
    var uploadJson = '{Url::toRoute(["/content/uploader/editer"])}';
    var fileManagerJson = '{Url::toRoute(["/content/uploader/filejson"])}';
    var LIST_URL = "{Url::toRoute(['/content/ads/index'])}";
    {literal}
    function uploadImage() {
        var _this = this;
        return function () {
            $.ajaxFileUpload
            (
                    {
                        url: UPLOAD_URL, //用于文件上传的服务器端请求地址
                        secureuri: false, //一般设置为false
                        fileElementId: 'file', //文件上传空间的id属性  <input type="file" id="file" name="file" />
                        dataType: 'json', //返回值类型 一般设置为json
                        success: function (data, status)  //服务器成功响应处理函数
                        {
                            if (data.status === 1) {
                                $("#ads-image").val(data.url);
                                layer.msg('上传成功', {icon: 1});
                                return true;
                            } else {
                                layer.alert(data.info);
                                return false;
                            }
                        },
                        error: function (data, status, e)//服务器响应失败处理函数
                        {
                            layer.alert('抱歉，上传失败');
                            return false;
                        }
                    }
            );
            $("#file").on('change', uploadImage());
        };
    }
    $("#file").on('change', uploadImage());
    {/literal}
</script>
{literal}
    <script>
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.iframeAuto(index);
        // parent.layer.full(index);
        //以下为官方示例
        $().ready(function () {
            // validate the comment form when it is submitted
            $("#close").click(function () {
                parent.layer.close(index);
            });
            $("#commentForm").validate({
                submitHandler: function (form) {
                    $(form).ajaxSubmit({
                        dataType: "json", //数据类型
                        success: function (data) { //提交成功的回调函数
                            if (data.status == 1) {
                                parent.location.reload();
                                parent.layer.close(index);
                            } else {
                                parent.layer.alert(data.msg);
                            }
                        },
                        error: function () {
                            parent.layer.alert('抱歉，提交失败');
                        }
                    });
                }
            });
        });
    </script>
{/literal}