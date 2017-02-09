{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{literal}
<style type="text/css">html,body,.gray-bg{background-color: #fff;}</style>
{/literal}
{Html::beginForm($url, 'Post', ['id' => 'commentForm', 'class' => 'form-horizontal m-t'])}
<div class="ibox-content">
    {Html::activeTextarea($model, 'wap_content', ['class' => 'form-control', 'id' => 'wap_content', 'style' => 'width:100%;height:600px;','required' => true])}
</div>
<div class="footer-div"></div>
<div class="form-footer">
    <button class="btn btn-primary" type="submit"> <i class="fa fa-check"></i>
        提交
    </button>
    <button class="btn btn-danger" type="button" id="close"> <i class="fa fa-times-circle"></i>
        取消
    </button>
</div>
{Html::endForm()}
<!-- jQuery Validation plugin javascript-->
<script src="/js/plugins/validate/jquery.form.min.js"></script>
<script src="/js/plugins/validate/jquery.validate.min.js"></script>
<script src="/js/plugins/validate/messages_zh.min.js"></script>

<script charset="utf-8" src="/js/plugins/kindeditor/kindeditor-min.js"></script>
<script charset="utf-8" src="/js/plugins/kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript" src="/js/ajaxfileupload.js"></script>

<script>
    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.iframeAuto(index);

    var UPLOAD_URL = '{Url::toRoute(["/content/uploader/index"])}';
    var uploadJson = '{Url::toRoute(["/content/uploader/editer"])}';
    var fileManagerJson = '{Url::toRoute(["/content/uploader/filejson"])}';
    var LIST_URL = "{Url::toRoute(['/content/news/index'])}";
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
                                $("#news-thumb").val(data.url);
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

    // 编辑器
    var editor;
    KindEditor.ready(function (K) {
        editor = K.create("#wap_content", {
            allowFileManager: true,
            uploadJson: uploadJson,
            fileManagerJson: fileManagerJson,
            afterBlur: function () {
                this.sync();
            }
        });
    });

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
{/literal}