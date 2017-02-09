{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{literal}<style type="text/css">html,body,.gray-bg{background-color: #fff;}</style>{/literal}
{Html::beginForm($url, 'Post', ['id' => 'commentForm', 'class' => 'form-horizontal m-t','options' => ['enctype' => 'multipart/form-data']])}
	<div class="ibox-content">
        <div class="form-group">
            <label class="col-sm-3 control-label">{$attributeLabels.recommend}：</label>
            <div class="col-sm-4">
                {Html::activeRadioList($model, 'recommend', ['1' => '推荐', '0' => '不推荐'], ['unselect' => 0])}
            </div>
        </div>
	</div>
<div class="footer-div"></div>
<div class="form-footer">
    <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i> 提交 </button>
    <button class="btn btn-danger " type="button" id="close"><i class="fa fa-times-circle"></i> 取消</button>
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
		var icon = "<i class='fa fa-times-circle'></i> ";
		// validate the comment form when it is submitted
		 $("#close").click(function(){
            parent.location.reload();
	        parent.layer.close(index); 
        });
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
    {/literal}
</script>