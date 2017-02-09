{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{literal}<style type="text/css">.control-label{text-align:right;}</style>{/literal}
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        {*<button class="btn btn-info " type="button" onclick="layers.post('{Url::toRoute(['/sys/setting/update'])}','_csrf={yii::$app->request->csrfToken}');"><i class="fa fa-refresh"></i> 系统设置更新</button>*}
        <button class="btn btn-primary" id="refreshGat"><i class="fa fa-refresh"></i> 系统设置更新</button>
        <button class="btn btn-warning" type="reset" onclick="location.reload();"><i class="fa fa-undo"></i> 刷新</button>
    </div>
    <div class="ibox-content"> 
        <form id="form_config" role="form" class="form-horizontal m-t" action="{Url::toRoute(['/sys/setting/save'])}" method="POST">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    {foreach from=$settingData item=v key=k}
                    <li class="{if $k==0}active{/if}"><a data-toggle="tab" href="#tab-{$k}" aria-expanded="{if k == 0}true{else}false{/if}">{$v.name}</a></li>
                    {/foreach}
                </ul>
                <div class="tab-content">
                    {foreach from=$settingData item=v key=k}
                    <div id="tab-{$k}" class="tab-pane {if $k == 0}active{/if}" style="padding-top: 20px;">
                        {if $k == 2}
                            {foreach $v.data as $value}
                                <div class="form-group"><label class="col-sm-3 control-label">{$value.title}</label></div>
                                {foreach $value.data as $set}
                                    <div class="form-group">
                                        <p class="col-sm-3 control-label">{$set.name}</p>
                                        <div class="col-sm-6">
                                            {if $set.input_type == '0'}
                                                <input type="text" name="system[{$set.key}]" class="form-control" value="{$set.value}" />
                                            {else}
                                                <textarea name="system[{$set.key}]" class="form-control" style="height: 80px;">{$set.value}</textarea>
                                            {/if}
                                        </div>
                                    </div>
                                {/foreach}
                            {/foreach}
                        {else}
                            {foreach $v.data as $set}
                                <div class="form-group">
                                    <p class="col-sm-3 control-label">{$set.name}</p>
                                    <div class="col-sm-6">
                                        {if $set.input_type == '0'}
                                            <input type="text" name="system[{$set.key}]" class="form-control" value="{$set.value}" />
                                        {else}
                                            <textarea name="system[{$set.key}]" class="form-control" style="height: 80px;">{$set.value}</textarea>
                                        {/if}
                                    </div>
                                </div>
                            {/foreach}
                        {/if}
                    </div>
                    {/foreach}
                </div>
            </div>

            <div class="hr-line-dashed"></div>
            <div class="form-group draggable ui-draggable">
                <div class="col-sm-12 col-sm-offset-3">
                    <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i> 提交 </button>
                    <input type="hidden" value="{yii::$app->request->csrfToken}" name="_csrf"/>
                </div>
            </div>
        </form>
        <div class="clearfix"></div>
    </div>
</div>

<!-- jQuery Validation plugin javascript-->
<script src="/js/plugins/validate/jquery.form.min.js"></script>
<script src="/js/plugins/validate/jquery.validate.min.js"></script>
<script src="/js/plugins/validate/messages_zh.min.js"></script>
<script>
    //以下为官方示例
    var refreshurl = "{Url::toRoute(['/sys/setting/update'])}";
    $().ready(function () {
        // validate the comment form when it is submitted
        $("#form_config").validate({
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    dataType:"json", //数据类型
                    success:function(data){ //提交成功的回调函数
                        layer.alert(data.msg);
                    },
                    error: function() {
                        layer.alert('抱歉，提交失败');
                    }
                });
            }
        });

        //刷新栏目
        $("#refreshGat").click(function () {
            $.getJSON(refreshurl, function (json) {
                if (json.status == 1) {
                    parent.layer.alert('刷新成功');
                } else {
                    parent.layer.alert('刷新失败');
                }
            });
        });
    });
</script>