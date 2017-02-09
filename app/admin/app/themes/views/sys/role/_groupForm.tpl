{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{literal}
    <style type="text/css">html, body, .gray-bg {  background-color: #fff;  }</style>
{/literal}
{Html::beginForm($url, 'Post', ['id' => 'commentForm', 'class' => 'form-horizontal m-t'])}
<div class="ibox-content">
    <div class="form-group">
        <div class="col-sm-12">
            <table class="table table-striped table-bordered table-hover dataTables-example">
                {foreach $plist as $list}
                    <tr>
                        <td width="30"><input type="checkbox" class="plist" name="plist[]" {if in_array($list.url, $powerinfo)}checked="true"{/if} value="{$list.id}">  </td>
                        <td>{$list.title}</td>
                        <td>&nbsp;</td>
                    </tr>
                    {if !empty($list.parentid)}
                        {foreach  from=$list.parentid key=k item=l name=name}
                            <tr>
                                <td>
                                    <input type="checkbox" class="plist-{$list.id}" name="plist[]" {if in_array($l.url, $powerinfo)}checked="true"{/if} value="{$l.id}"/>
                                </td>
                                <td width=150>{$l.title}</td>
                                <td>
                                    {if !empty($l.parentid)}
                                        {foreach  from=$l.parentid item=lp}
                                            <input type="checkbox" class="plist-{$list.id}" name="childlist[{$l.id}][{$lp.url}]" {if in_array($lp.url, $powerinfo)}checked="true"{/if} value="{$lp.title}"/> {$lp.title} &nbsp;
                                        {/foreach}
                                    {else}
                                        &nbsp;
                                    {/if}
                                </td>
                            </tr>
                        {/foreach}
                    {/if}
                {/foreach}

            </table>
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
<script>
    var index = parent.layer.getFrameIndex(window.name);
    // 关闭layer
    $("#close").click(function () {
        parent.layer.close(index);
    });

    //以下为官方示例
    $().ready(function () {
        // 全选
        $(".plist").bind('click', function(){
            var cla = '.plist-' + $(this).attr("value");
            var checked = $(this)[0].checked;
            $(cla).each(function(){
                $(this)[0].checked = checked;
            })
        });
        // validate the comment form when it is submitted
        $("#commentForm").validate({
            submitHandler: function (form) {
                $(form).ajaxSubmit({
                    dataType: "json", //数据类型
                    success: function (data) { //提交成功的回调函数
                        // parent.layer.alert(data.msg);
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