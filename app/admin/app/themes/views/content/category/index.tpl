{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
<div class="wrapper wrapper-content" style="position: fixed;top: 0px;z-index: 99999999;width: 100%;background-color: #f3f3f4;padding: 0px 10px;">
    <div style="padding:12px;background-color: #ffffff;border-bottom: 1px #e7eaec solid;">
        {if in_array('/content/category/add', Yii::$app->params['powers'])}
            <button class="btn btn-success" data-toggle="modal" onclick="layers.full('{Url::toRoute(['/content/category/add'])}', '创建栏目', 800, 830)"><i class="fa fa-plus-circle"></i> 创建栏目</button>
        {/if}
        <button class="btn btn-primary" id="refreshGat"><i class="fa fa-refresh"></i> 刷新栏目</button>
        <button class="btn btn-warning" type="reset" onclick="window.location.href='{Url::toRoute(['/content/category/index'])}'"><i class="fa fa-undo"></i> 刷新</button>

        {*<div class="pull-right">*}
            {*<form action="{Url::toRoute(['category/index'])}" method="get">*}
                {*<div class="form-inline">*}
                    {*<div class="form-group"><span class="search_span">搜索：</span></div>*}
                    {*<div class="form-group">*}
                        {*<input type="text" class="form-control m-b" id="keyword" name="catname" size="15" placeholder="栏目名称">*}
                    {*</div>*}
                    {*<div class="form-group" style="margin-left: 10px;">*}
                        {*<button class="btn btn-primary m-b" type="submit">查询</button>*}
                        {*<input class="btn btn-primary m-b" type="button" value="定位" id="cat-pos"/>*}
                    {*</div>*}
                {*</div>*}
            {*</form>*}
        {*</div>*}
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight" style="margin-top: 50px;">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    {if count($catList) > 0}
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>栏目类型</th>
                                <th>栏目名称</th>
                                <th>栏目链接</th>
                                <th>排序</th>
                                <th>导航状态</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            {foreach from=$catList key=k item=value name=name}
                                <tr>
                                    <td>{$value.catid}</td>
                                    <td>
                                        <span class="label label-default">{Yii::$app->params['categorytype'][$value.moduleid]}</span>
                                    </td>
                                    <td catname="{$value.catname}">{$value.catname}</td>
                                    <td>{if !empty($value.url)}{$value.url}{else}{$value.link_url}{/if}</td>
                                    <td>{$value.listorder}</td>
                                    <td>
                                        {if $value.ismenu eq "1"}
                                            <span class="label label-primary">导航显示</span>
                                        {else}
                                            <span class="label label-danger">不显示</span>
                                        {/if}
                                    </td>
                                    <td>
                                        {if $value.isshow eq "1"}
                                            <span class="label label-primary">显示</span>
                                        {else}
                                            <span class="label label-danger">不显示</span>
                                        {/if}
                                    </td>
                                    <td>
                                        {if in_array('/content/category/edit', Yii::$app->params['powers'])}
                                            <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" onclick="layers.full('{Url::toRoute(["/content/category/edit","catid" => $value.catid])}', '编辑栏目', 800, 800)"><i class="fa fa-edit"> 编辑</i></button>
                                        {/if}
                                        {if in_array('/content/category/del', Yii::$app->params['powers'])}
                                            <button type="button" class="btn btn-danger btn-xs removecat" onclick="layers.del('{Url::toRoute(["/content/category/del"])}', 'catid={$value.catid}&_csrf={yii::$app->request->csrfToken}')"><i class="fa fa-trash-o"> 删除</i></button>
                                        {/if}
                                    </td>
                                </tr>
                            {/foreach}
                            {else}
                            无数据!
                            </tbody>
                        </table>
                    {/if}
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var refreshurl = "{yii::$app->urlManager->createUrl(['content/category/refresh'])}";
    {literal}
    $(function ($) {
        //定位栏目
        $("#cat-pos").click(function () {
            $(".bg-success").each(function () {
                $(this).removeClass("bg-success");
                $(this).removeAttr("style");
            });
            $("td[catname]").each(function (index, element) {
                if ($(this).attr("catname").match($("#keyword").val())) {
                    $(document).scrollTop($(this).offset().top - $(document.body).height() / 2);
                    $(this).parent("tr").addClass("bg-success");
                    $(this).parent("tr").css("backgroundColor", "#dff0d8");
                    return false;
                }
            });
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
    {/literal}
</script>