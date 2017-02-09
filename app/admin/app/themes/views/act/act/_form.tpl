{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{literal}
    <style type="text/css">html, body, .gray-bg {
            background-color: #fff;
        }
        .control-label{text-align: right;}
    </style>
{/literal}
{Html::beginForm($url, 'Post', ['id' => 'commentForm', 'class' => 'form-horizontal m-t', 'options' => ['enctype' => 'multipart/form-data']])}
<div class="ibox-content">
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.name}：</label>
        <div class="col-sm-4">
            {Html::activeTextInput($model, 'name', ['class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 20])}
            {Html::hiddenInput('id', $model.id)}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.sitetype}：</label>
        <div class="col-sm-8">
            {Html::activeRadioList($model, 'sitetype', ['1' => 'PC', '2' => 'WAP'], ['unselect' => 1])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.image}：</label>
        <div class="col-sm-4">
            {Html::activeTextInput($model, 'image', ['class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'readonly' => 'readonly'])}
        </div>
        <div class="col-sm-3" id="col-input">
            <span class="btn btn-primary file-btn">选择图片 <input type="file" class="file" id="image" name="file"></span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.url}：</label>
        <div class="col-sm-4">
            {Html::activeTextInput($model, 'url', ['class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 20])}
        </div>
        {*<div class="col-sm-1 control-label">*}
            {*<h3 class="text-danger">/****.html</h3>*}
        {*</div>*}
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.router}：</label>
        <div class="col-sm-4">
            {Html::activeTextInput($model, 'router', ['class' => 'form-control', 'aria-required' => 'true', 'size' => 20])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.hits}：</label>
        <div class="col-sm-4">
            {Html::activeTextInput($model, 'hits', ['value' => 0, 'class' => 'form-control', 'aria-required' => 'true', 'size' => 20])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.seo_title}：</label>
        <div class="col-sm-8">
            {Html::activeTextInput($model, 'seo_title', ['class' => 'form-control', 'aria-required' => 'true', 'size' => 20])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.seo_keywords}：</label>
        <div class="col-sm-8">
            {Html::activeTextInput($model, 'seo_keywords', ['class' => 'form-control', 'aria-required' => 'true', 'size' => 20])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.seo_description}：</label>
        <div class="col-sm-8">
            {Html::activeTextarea($model, 'seo_description', ['class' => 'form-control', 'aria-required' => 'true', 'size' => 20, 'rows' => '3'])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.start}：</label>
        <div class="col-sm-4">
            {Html::activeTextInput($model, 'start', ['value' => date('Y-m-d H:i:s',$model->start),'id' => 'stime', 'class' => 'form-control layer-date', 'required' => true, 'aria-required' => 'true', 'size' => 20])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.end}：</label>
        <div class="col-sm-4">
            {Html::activeTextInput($model, 'end', ['value' => date('Y-m-d H:i:s',$model->end),'id' => 'etime', 'class' => 'form-control layer-date', 'required' => true, 'aria-required' => 'true', 'size' => 20])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.subname}：</label>
        <div class="col-sm-4">
            {Html::activeTextInput($model, 'subname', ['class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 20])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.subtype}：</label>
        <div class="col-sm-8">
            {Html::activeRadioList($model, 'subtype', Yii::$app->params['subtype'], ['unselect' => 1])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.recommend}：</label>
        <div class="col-sm-8">
            {Html::activeRadioList($model, 'recommend', ['1' => '不推荐', '0' => '不推荐'], ['unselect' => 0])}
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
            {Html::activeRadioList($model, 'status', ['1' => '启用', '0' => '关闭'], ['unselect' => 1])}
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
<script charset="utf-8" src="/js/plugins/kindeditor/kindeditor-min.js"></script>
<script charset="utf-8" src="/js/plugins/kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript">
    var UPLOAD_URL = '{Url::toRoute(["/content/uploader/index"])}';
    var uploadJson = '{Url::toRoute(["/content/uploader/editer"])}';
    var fileManagerJson = '{Url::toRoute(["/content/uploader/filejson"])}';
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
        // 编辑器
        var editor;
        KindEditor.ready(function (K) {
            editor = K.create("#template", {
                width: '100%',
                height: '400px;',
                allowFileManager: true,
                uploadJson: uploadJson,
                fileManagerJson: fileManagerJson,
                afterBlur: function () {
                    this.sync();
                }
            });
        });
        $("#act-is_tmp input").click(function () {
            console.log($(this).val())
            if ($(this).val() == 0) {
                $(".is_tmp").hide();
            } else {
                $(".is_tmp").show();
            }
        });
    });
</script>
<script>
    {literal}
    function uploadImage(file) {
        $.ajaxFileUpload
        (
                {
                    url: UPLOAD_URL, //用于文件上传的服务器端请求地址
                    secureuri: false, //一般设置为false
                    fileElementId: file.children("input").attr("id"), //文件上传空间的id属性  <input type="file" id="file" name="file" />
                    dataType: 'json', //返回值类型 一般设置为json
                    success: function (data, status)  //服务器成功响应处理函数
                    {
                        if (data.status === 1) {
                            $("#" + file.parent("div").siblings("div").children("input").attr("id")).val(data.url);
                            layer.msg('上传成功', {icon: 1});
                            return true;
                        } else {
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
        $(".file").change(function () {
            uploadImage($(this).parent("span"));
        });
    }
    $(".file").change(function () {
        uploadImage($(this).parent("span"));
    });
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