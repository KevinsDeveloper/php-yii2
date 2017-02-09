{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{literal}<style type="text/css">html,body,.gray-bg{background-color: #fff;}</style>{/literal}
{Html::beginForm($url, 'post', ['id' => 'commentForm', 'class' => 'form-horizontal m-t'])}
	<div class="ibox-content">

			<div class="form-group">
				<label class="col-sm-3 text-right control-label">父栏目：</label>
				<div class="col-sm-5">
					{Html::activeDropDownList($model, 'pid', $res, ['select' => '0', 'class' => 'form-control'])}
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 text-right control-label">{$attributeLabels.title}：</label>
				<div class="col-sm-8">
					{Html::activeTextInput($model, 'title', ['class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 20])}
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 text-right control-label">{$attributeLabels.url}：</label>
				<div class="col-sm-8">
					{Html::activeTextInput($model, 'url', ['class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 20])}
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 text-right control-label">{$attributeLabels.icon}：</label>
				<div class="col-sm-8">
					{Html::activeTextInput($model, 'icon', ['class' => 'form-control', 'size' => 20])}
				</div>
			</div>

            <div class="form-group">
				<label class="col-sm-3 text-right control-label">{$attributeLabels.orderby}：</label>
				<div class="col-sm-3">
					{Html::activeTextInput($model, 'orderby', ['class' => 'form-control', 'size' => 20])}
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 text-right control-label">是否显示：</label>
				<div class="col-sm-8">
					{Html::activeRadioList($model, 'status', ['1' => '显示', '0' => '隐藏'], ['select' => '1'])}
                </div>
			</div>

			{*<div class="form-group">*}
				{*<label class="col-sm-3 text-right control-label">是否为菜单：</label>*}
				{*<div class="col-sm-8">*}
					{*{Html::activeRadioList($model, 'isshow', ['1' => '是', '0' => '否'], ['select' => '1'])}*}
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
<script>
	var index = parent.layer.getFrameIndex(window.name);
	// 关闭layer
    $("#close").click(function(){
        parent.layer.close(index);
    });

	//以下为官方示例
	$().ready(function () {
		// validate the comment form when it is submitted
		$("#commentForm").validate({
			submitHandler: function(form) {
				$(form).ajaxSubmit({
	                dataType:"json", //数据类型
	                success:function(data){ //提交成功的回调函数
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