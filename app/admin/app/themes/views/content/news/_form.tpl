{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{literal}
	<style type="text/css">html, body, .gray-bg {
			background-color: #fff;
		}
		.control-label{text-align:right;}
	</style>
{/literal}
<link rel="stylesheet" href="/js/plugins/kindeditor/themes/default/default.css"/>
<link rel="stylesheet" type="text/css" href="/js/time/jquery.datetimepicker.css"/ >
<div class="ibox-title">
	<a class="btn btn-success" href="{Url::toRoute(['/content/news/index'])}"><i class="fa fa-bars "></i> 返回</a>
	<button class="btn btn-warning" type="reset" onclick="location.reload();"><i class="fa fa-undo"></i> 刷新</button>
</div>
{Html::beginForm($url, 'Post', ['id' => 'commentForm', 'class' => 'form-horizontal m-t','options' => ['enctype' => 'multipart/form-data']])}
<div class="ibox-content">
	<div class="form-group">
		<label class="col-sm-3 control-label">{$attributeLabels.catname}：</label>
		<div class="col-sm-2">
			{Html::activeDropDownList($model,'catid', $groups, ['prompt'=>'请选择','class' => 'form-control'])}
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">{$attributeLabels.title}：</label>
		<div class="col-sm-5">
			{Html::activeTextInput($model, 'title', ['class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 30])}
		</div>
	</div>
	{*<div class="form-group">
		<label class="col-sm-3 control-label">{$attributeLabels.style}：</label>
		<div class="col-sm-5">
			{Html::activeTextInput($model, 'style', ['class' => 'form-control', 'aria-required' => 'true', 'size' => 20])}
		</div>
	</div>*}
	<div class="form-group">
		<label class="col-sm-3 control-label">{$attributeLabels.picture}：</label>
		<div class="col-sm-6">
			<div class="col-sm-8" style="padding-left: 0px;">{Html::activeTextInput($model, 'thumb', ['readonly' => 'readonly', 'class' => 'form-control', 'aria-required' => 'true'])}</div>
			<div class="col-sm-4" id="col-input">
				<span class="btn btn-primary file-btn">选择图片 <input type="file" id="file" name="file"></span>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">{$attributeLabels.link}：</label>
		<div class="col-sm-4">
			{Html::activeTextInput($model, 'link', ['class' => 'form-control', 'aria-required' => 'true', 'size' => 30])}
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">{$attributeLabels.source}：</label>
		<div class="col-sm-4">
			{Html::activeTextInput($model, 'source', ['class' => 'form-control', 'aria-required' => 'true', 'size' => 30])}
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">{$attributeLabels.keywords}：</label>
		<div class="col-sm-5">
			{Html::activeTextInput($model, 'keywords', ['class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 20])}
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">{$attributeLabels.description}：</label>
		<div class="col-sm-5">
			{Html::activeTextarea($model, 'description', ['class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 20])}
		</div>
	</div>

    <div class="form-group">
        <label class="col-sm-3 control-label">{$attributeLabels.tags}：</label>
        <div class="col-sm-4">
            {Html::activeTextInput($model, 'tags', ['class' => 'form-control', 'aria-required' => 'true', 'size' => 20])}
        </div>
    </div>
	<div class="form-group">
		<label class="col-sm-3 control-label">{$attributeLabels.hits}：</label>
		<div class="col-sm-1">
			{Html::activeTextInput($model, 'hits', ['class' => 'form-control', 'aria-required' => 'true'])}
		</div>
	</div>
	{*<div class="form-group">
		<label class="col-sm-3 control-label">{$attributeLabels.listorder}：</label>
		<div class="col-sm-1">
			{Html::activeTextInput($model, 'listorder', ['class' => 'form-control', 'required' => true, 'aria-required' => 'true'])}
		</div>
	</div>*}
	<div class="form-group">
		<label class="col-sm-3 control-label">{$attributeLabels.sitetype}：</label>
		<div class="col-sm-8">
			{Html::activeRadioList($model, 'sitetype', ['1' => 'PC显示', '2' => 'WAP显示' , '0' => '全部'], ['unselect' => '0'])}
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">{$attributeLabels.recommend}：</label>
		<div class="col-sm-4">
			{Html::activeRadioList($model, 'recommend', ['1' => '首页推荐', '0' => '不推荐'], ['unselect' => 0])}
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">{$attributeLabels.content}：</label>
		<div class="col-sm-8">
			{Html::activeTextarea($model, 'content', ['class' => 'form-control', 'id' => 'content', 'style' => 'width:100%;height:600px;','required' => true])}

		</div>
	</div>


</div>
<div class="footer-div"></div>
<div class="form-footer">
	<button class="btn btn-primary" type="submit"><i class="fa fa-check"></i> 提交</button>
	<a class="btn btn-danger" href="{Url::toRoute(['/content/news/index'])}"><i class="fa fa-bars "></i> 取消</a>
</div>
{Html::endForm()}
<!-- jQuery Validation plugin javascript-->
<script src="/js/plugins/validate/jquery.form.min.js"></script>
<script src="/js/plugins/validate/jquery.validate.min.js"></script>
<script src="/js/plugins/validate/messages_zh.min.js"></script>
<script charset="utf-8" src="/js/plugins/kindeditor/kindeditor-min.js"></script>
<script charset="utf-8" src="/js/plugins/kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript" src="/js/ajaxfileupload.js"></script>
<script src="/js/time/jquery.datetimepicker.js"></script>
<script>
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
		editor = K.create("#content", {
			allowFileManager: true,
			uploadJson: uploadJson,
			fileManagerJson: fileManagerJson,
			afterBlur: function () {
				this.sync();
			}
		});
	});

	//时间插件
	$(function () {
		$('.layer-date').datetimepicker({
			lang: 'ch'
		});
	});

	//以下为官方示例
	$().ready(function () {
		var icon = "<i class='fa fa-times-circle'></i> ";
		// validate the comment form when it is submitted
		$("#close").click(function () {
			parent.location.reload();
			parent.layer.close(index);
		});
		$("#commentForm").validate({
			submitHandler: function (form) {
				$(form).ajaxSubmit({
					dataType: "json", //数据类型
					success: function (data) { //提交成功的回调函数
						if (data.status == 1) {
							layer.confirm(data.msg, {
								btn: ['继续操作', '返回'] //按钮
							}, function () {
								//layer.alert(data.msg);
								location.href = LIST_URL;
							}, function () {
								location.href = LIST_URL;
							});
						} else {
							layer.alert(data.msg);
						}
					},
					error: function () {
						layer.alert('抱歉，提交失败');
					}
				});
			}
		});
	});
	{/literal}
</script>