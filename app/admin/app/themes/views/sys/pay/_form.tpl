{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{literal}<style type="text/css">html,body,.gray-bg{background-color: #fff;}</style>{/literal}
{Html::beginForm($url, 'post', ['id' => 'commentForm', 'class' => 'form-horizontal m-t'])}
	<div class="ibox-content">

			<div class="form-group">
				<label class="col-sm-3 text-right control-label">支付类型：</label>
				<div class="col-sm-5">
					{Html::activeDropDownList($model, 'sitetype', [ 0 => 'web支付', 1 => 'wap支付'], ['prompt' => '请选择支付类型', 'select' => '0', 'class' => 'form-control'])}
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 text-right control-label">最小金额：</label>
				<div class="col-sm-8">
					{Html::activeTextInput($model, 'min_money', ['class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 20])}
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 text-right control-label">最大金额：</label>
				<div class="col-sm-8">
					{Html::activeTextInput($model, 'max_money', ['class' => 'form-control', 'required' => true, 'aria-required' => 'true', 'size' => 20])}
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 text-right control-label">支付商户：</label>
				<div class="col-sm-8">
					{Html::activeDropDownList($model, 'pay_code', $psetting, ['prompt' => '请选择支付商户', 'class' => 'form-control'])}
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