{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox">
                <div class="ibox-title">
                    {if in_array('/act/act/add', Yii::$app->params['powers'])}
                        <button class="btn btn-success" data-toggle="modal" onclick="layers.frame('{Url::toRoute(['/act/act/add'])}', '创建活动', 800, 830)"><i class="fa fa-plus-circle"></i> 添加活动</button>
                    {/if}
                    <button class="btn btn-warning" type="reset" onclick="window.location.href='{Url::toRoute(['/act/act/index'])}'"><i class="fa fa-undo"></i> 刷新</button>
                </div>
                <div class="ibox-content">

                    <div class="table-tools clearfix">
                        <div class="float-left">
                            <form action="{Url::toRoute(['act/index'])}" method="get">
                                <div class="form-inline">
                                    <div class="form-group"><span class="search_span">搜索：</span></div>
                                    <div class="form-group">
                                        <select class="form-control m-b" name="search[type]" id="class_id">
                                            <option value="">请选择</option>
                                            <option value="name" {if isset($smarty.get.search) and $smarty.get.search.type eq "name"}selected='selected'{/if}>活动名称</option>
                                            <option value="addname" {if isset($smarty.get.search) and  $smarty.get.search.type eq "addname"}selected='selected'{/if}>添加人</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control m-b" id="keyword" name="search[keyword]" size="15" {if isset($smarty.get.search) and $smarty.get.search.keyword}value="{$smarty.get.search.keyword}"{/if} placeholder="关键词">
                                    </div>
                                    <div class="form-group">
                                        <div class="field">
                                            <input type="text" class="form-control m-b layer-date" id="stime" name="search[stime]" size="15" {if isset($smarty.get.search) and $smarty.get.search.stime}value="{$smarty.get.search.stime}"{/if} placeholder="开始时间">
                                            <input type="text" class="form-control m-b layer-date" id="etime" name="search[etime]" size="15" {if isset($smarty.get.search) and $smarty.get.search.etime}value="{$smarty.get.search.etime}"{/if} placeholder="结束时间">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary m-b" type="submit">查询</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <table class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>缩略图</th>
                            <th>活动标题</th>
                            <th>链接地址</th>
                            <th>开始时间</th>
                            <th>结束时间</th>
                            <th>访问量</th>
                            <th>站点</th>
                            <th>是否显示</th>
                            <th>是否启用</th>
                            <th>是否推荐</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach from=$act_list key=k item=value name=name}
                            <tr>
                                <td>{$value.id}</td>
                                <td><img src="{Yii::$app->params.setting.uploadUrl}{$value.image}" width="64"/></td>
                                <td>{$value.name}</td>
                                <td>{$value.url}</td>
                                <td>{date('Y-m-d H:i:s',$value.start)}</td>
                                <td>{date('Y-m-d H:i:s',$value.end)}</td>
                                <td>{$value.hits}</td>
                                <td>
                                    {if $value.sitetype eq "1"}
                                        <span class="label label-primary">电脑端</span>
                                    {else}
                                        <span class="label label-success">手机端</span>
                                    {/if}
                                </td>
                                <td>
                                    {if $value.isshow eq "1"}
                                        <span class="label label-primary">显示</span>
                                    {else}
                                        <span class="label label-danger">隐藏</span>
                                    {/if}
                                </td>
                                <td>
                                    {if $value.status eq "1"}
                                        <span class="label label-primary">启用</span>
                                    {else}
                                        <span class="label label-danger">关闭</span>
                                    {/if}
                                </td>
                                <td>
                                    {if $value.recommend eq "1"}
                                        <span class="label label-primary">推荐</span>
                                    {else}
                                        <span class="label label-success">不推荐</span>
                                    {/if}
                                </td>
                                <td>
                                    {if in_array('/act/act/edit', Yii::$app->params['powers'])}
                                        <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" onclick="layers.frame('{Url::toRoute(["/act/act/edit","id" => $value.id])}', '编辑活动', 800, 820)"><i class="fa fa-edit"> 编辑</i></button>
                                    {/if}
                                    {if in_array('/act/act/del', Yii::$app->params['powers'])}
                                        <button type="button" class="btn btn-danger btn-xs removecat" onclick="layers.del('{Url::toRoute(["/act/act/del"])}', 'id={$value.id}&_csrf={yii::$app->request->csrfToken}')"><i class="fa fa-trash-o"> 删除</i></button>
                                    {/if}
                                </td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                    {$this->render('../_page.tpl', ['page' => $page, 'count' => $count])}
                </div>

            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="/js/time/jquery.datetimepicker.css"/ >
<script src="/js/time/jquery.datetimepicker.js"></script>
<script type="text/javascript">
    $(function () {
        $('#stime').datetimepicker.ShowCheckBox = true;
        $('#stime').datetimepicker({
            lang: 'ch',
            validateOnBlur: false,
        });
        $('#etime').datetimepicker({
            lang: 'ch',
            validateOnBlur: false,
        });
    });
</script>