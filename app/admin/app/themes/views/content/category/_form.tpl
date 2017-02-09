{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{literal}<style type="text/css">html,body,.gray-bg{background-color: #fff;}.control-label{text-align: right;}</style>{/literal}
{Html::beginForm($url, 'Post', ['id' => 'commentForm', 'class' => 'form-horizontal m-t', 'options' => ['enctype' => 'multipart/form-data']])}
<div class="ibox-content">
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.catname}：</label>
        <div class="col-sm-8">
            {Html::activeTextInput($model, 'catname', ['class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 20])}
            {Html::hiddenInput('catid', $model.catid)}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.moduleid}：</label>
        <div class="col-sm-8">
            {Html::activeRadioList($model, 'moduleid', Yii::$app->params['categorytype'], ['select' => 0])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.template}：</label>
        <div class="col-sm-5">
            {Html::activeDropDownList($model, 'template', $tmp['tpl'], ['unselect' => '0', 'class' => 'form-control'])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.parentid}：</label>
        <div class="col-sm-5">
            {Html::activeDropDownList($model, 'parentid', $parentid, ['unselect' => '0', 'class' => 'form-control'])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.sitetype}：</label>
        <div class="col-sm-8">
            {Html::activeRadioList($model, 'sitetype', ['0' => '默认', '1' => 'PC隐藏', '2' => 'WAP隐藏'], ['select' => '0'])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.style}：</label>
        <div class="col-sm-8">
            {Html::activeRadioList($model, 'style', ['none' => '无', 'strong' => '加粗'], ['unselect' => 'none'])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.image}：</label>
        <div class="col-sm-4">
            {Html::activeTextInput($model, 'image', ['readonly' => 'readonly', 'class' => 'form-control', 'aria-required' => 'true'])}
        </div>
        <div class="col-sm-3" id="col-input">
            <span class="btn btn-primary file-btn">选择图片 <input type="file" id="file" name="file"></span>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.description}：</label>
        <div class="col-sm-8">
            {Html::activeTextarea($model, 'description', ['class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 20, 'rows' => 4])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.url}：</label>
        <div class="col-sm-8">
            {Html::activeTextInput($model, 'url', ['class' => 'form-control', 'aria-required' => 'true', 'size' => 20])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.link_url}：</label>
        <div class="col-sm-8">
            {Html::activeTextInput($model, 'link_url', ['class' => 'form-control', 'size' => 20])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.hits}：</label>
        <div class="col-sm-3">
            {Html::activeTextInput($model, 'hits', ['class' => 'form-control', 'size' => 20])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.seo_title}：</label>
        <div class="col-sm-8">
            {Html::activeTextInput($model, 'seo_title', ['class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 20])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.seo_keywords}：</label>
        <div class="col-sm-8">
            {Html::activeTextInput($model, 'seo_keywords', ['class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 20])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.seo_description}：</label>
        <div class="col-sm-8">
            {Html::activeTextarea($model, 'seo_description', ['class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 20, 'rows' => 4])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.listorder}：</label>
        <div class="col-sm-3">
            {Html::activeTextInput($model, 'listorder', ['class' => 'form-control', 'digits' => true, 'aria-required' => 'true', 'size' => 20])}
        </div>
    </div>
    
    {*<div class="form-group">*}
        {*<label class="col-sm-3 control-label">{$attributeLabels.target}：</label>*}
        {*<div class="col-sm-8">*}
            {*{Html::activeRadioList($model, 'target', ['0' => '正常打开', '1' => '新窗口打开'], ['unselect' => 0])}*}
        {*</div>*}
    {*</div>*}
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.ismenu}：</label>
        <div class="col-sm-8">
            {Html::activeRadioList($model, 'ismenu', ['1' => '显示', '0' => '不显示'], ['unselect' => 0])}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.isshow}：</label>
        <div class="col-sm-8">
            {Html::activeRadioList($model, 'isshow', ['1' => '显示', '0' => '隐藏'], ['unselect' => 1])}
        </div>
    </div>
    {*<div class="form-group">*}
        {*<label class="col-sm-3 control-label">{$attributeLabels.nofollow}：</label>*}
        {*<div class="col-sm-8">*}
            {*{Html::activeRadioList($model, 'nofollow', ['1' => 'nofollow', '0' => '无'], ['unselect' => 1])}*}
        {*</div>*}
    {*</div>*}
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
<script type="text/javascript" src="/js/ajaxfileupload.js"></script>
<script>
    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.iframeAuto(index);
    // parent.layer.full(index);
    //以下为官方示例
    $().ready(function () {
        // validate the comment form when it is submitted
        $("#close").click(function(){
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
<script>
    var UPLOAD_URL = '{Url::toRoute(["/content/uploader/index"])}';
    var uploadJson = '{Url::toRoute(["/content/uploader/editer"])}';
    var fileManagerJson = '{Url::toRoute(["/content/uploader/filejson"])}';
    {*var LIST_URL = "{Url::toRoute(['/act/lists/index'])}";*}
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
                                $("#category-image").val(data.url);
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