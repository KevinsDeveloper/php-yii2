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
	<a class="btn btn-success" href="{Url::toRoute(['/user/user/index'])}"><i class="fa fa-bars "></i> 返回</a>
	<button class="btn btn-warning" type="reset" onclick="location.reload();"><i class="fa fa-undo"></i> 刷新</button>
</div>
{Html::beginForm($url, 'Post', ['id' => 'commentForm', 'class' => 'form-horizontal m-t','options' => ['enctype' => 'multipart/form-data']])}
<div class="ibox-content">
	<div class="form-group">
		<label class="col-sm-3 control-label">{$attributeLabels.user_name}：</label>
		<div class="col-sm-2">
			{Html::activeTextInput($model,'user_name', ['class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 30])}
		</div>
		<div class="col-sm-1"><span class="text-danger">*</span></div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">{$attributeLabels.real_name}：</label>
		<div class="col-sm-2">
			{Html::activeTextInput($model, 'real_name', ['class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 30])}
		</div>
		<div class="col-sm-1"><span class="text-danger">*</span></div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">{$attributeLabels.sex}：</label>
		<div class="col-sm-2">
			{Html::activeRadioList($model, 'sex', ['1' => '男', '0' => '女'], ['unselect' => '1'])}
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">{$attributeLabels.country}：</label>
		<div class="col-sm-2">
			{Html::activeTextInput($model, 'country', ['class' => 'form-control', 'aria-required' => 'true', 'size' => 30])}
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">{$attributeLabels.evidence_type}：</label>
		<div class="col-sm-2">
			{Html::activeDropDownList($model,'evidence_type', ['身份证','护照','其他'], ['prompt'=>'请选择','class' => 'form-control'])}
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">{$attributeLabels.evidence_num}：</label>
		<div class="col-sm-2">
			{Html::activeTextInput($model, 'evidence_num', ['class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 30])}
		</div>
		<div class="col-sm-1"><span class="text-danger">*</span></div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">{$attributeLabels.mobile}：</label>
		<div class="col-sm-2">
			{Html::activeTextInput($model, 'mobile', ['class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 30])}
		</div>
		<div class="col-sm-1"><span class="text-danger">*</span></div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">{$attributeLabels.email}：</label>
		<div class="col-sm-2">
			{Html::activeTextInput($model, 'email', ['class' => 'form-control', 'aria-required' => 'true', 'size' => 30])}
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">{$attributeLabels.address}：</label>
		<div class="col-sm-2">
			{Html::activeTextInput($model, 'address', ['class' => 'form-control', 'aria-required' => 'true', 'size' => 30])}
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">{$attributeLabels.qq}：</label>
		<div class="col-sm-2">
			{Html::activeTextInput($model, 'qq', ['class' => 'form-control', 'aria-required' => 'true', 'size' => 30])}
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">{$attributeLabels.msn}：</label>
		<div class="col-sm-2">
			{Html::activeTextInput($model, 'msn', ['class' => 'form-control', 'aria-required' => 'true', 'size' => 30])}
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">{$attributeLabels.bank_name}：</label>
		<div class="col-sm-2">
			{Html::activeTextInput($model, 'bank_name', ['class' => 'form-control', 'aria-required' => 'true', 'size' => 30])}
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">{$attributeLabels.account_num}：</label>
		<div class="col-sm-2">
			{Html::activeTextInput($model, 'account_num', ['class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 30])}
		</div>
		<div class="col-sm-1"><span class="text-danger">*</span></div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">{$attributeLabels.bank_address}：</label>
		<div class="col-sm-4">
			{Html::activeTextInput($model, 'bank_address', ['class' => 'form-control', 'aria-required' => 'true', 'size' => 30])}
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">{$attributeLabels.user_group}：</label>
		<div class="col-sm-2">
			{Html::activeDropDownList($model,'evidence_type', ['0'=>'用户','1'=>'客服','2'=>'分析师'], ['class' => 'form-control', 'unselect'=>'0'])}
		</div>
	</div>

</div>
<div class="footer-div"></div>
<div class="form-footer">
	<button class="btn btn-primary" type="submit"><i class="fa fa-check"></i> 提交</button>
	<a class="btn btn-danger" href="{Url::toRoute(['/user/user/index'])}"><i class="fa fa-bars "></i> 取消</a>
</div>
{Html::endForm()}
<!-- jQuery Validation plugin javascript-->
<script src="/js/plugins/validate/jquery.form.min.js"></script>
<script src="/js/plugins/validate/jquery.validate.min.js"></script>
<script src="/js/plugins/validate/messages_zh.min.js"></script>
<script>
	{literal}
	//以下为官方示例
	$().ready(function () {
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