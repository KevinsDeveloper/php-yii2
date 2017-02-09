{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    {if in_array('/sys/role/add',Yii::$app->params['powers'])}
                    <button class="btn btn-success" data-toggle="modal"  onclick="layers.open('{Url::toRoute(['/sys/role/add'])}', '添加角色组', 600, 300)"><i class="fa fa-plus"></i> 添加角色组</button>
                    {/if}
                    <button class="btn btn-primary" id="refreshGat"><i class="fa fa-refresh"></i> 刷新权限</button>
                    <button class="btn btn-warning" type="reset" onclick="location.reload();"><i class="fa fa-undo"></i> 刷新</button>
                </div>
                <div class="ibox-content">
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>角色组名称</th>
                            <th>添加时间</th>
                            <th>管理员类型</th>
                            <th>是否可用</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        {if count($roles)}
                            <tbody>
                            {foreach from=$roles key=k item=v name=name}
                                <tr>
                                    <td>{$v.id}</td>
                                    <td>{$v.role_name}</td>
                                    <td>{date('Y-m-d H:i:s', $v.adtime)}</td>
                                    <td>{if $v.type==1}超级管理员{elseif $v.type==2}普通管理员{else}其他{/if}</td>
                                    <td>{if $v.status==1}
                                            <a class="btn btn-primary btn-xs">可用</a>
                                        {else}
                                            <a class="btn btn-danger btn-xs">不可用</a>
                                        {/if}
                                    </td>
                                    <td>
                                        {if in_array('/sys/role/groupadd',Yii::$app->params['powers'])}
                                            {if $v.type != 1}
                                            <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" onclick="layers.frame('{Url::toRoute(["/sys/role/groupadd","id" => $v.id])}', '分配权限', 1000, 600)"><i class="fa fa-edit"> 权限</i></button>
                                            {else}
                                            <button type="button" class="btn btn-default btn-xs" data-toggle="modal"><i class="fa fa-send-o"> 权限</i></button>
                                            {/if}
                                        {/if}
                                        {if in_array('/sys/role/edit',Yii::$app->params['powers'])}
                                        {if $v.type != 1}
                                            <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" onclick="layers.open('{Url::toRoute(["/sys/role/edit","id" => $v.id])}', '编辑角色组', 600, 300)"><i class="fa fa-edit"> 编辑</i></button>
                                        {else}
                                            <button type="button" class="btn btn-default btn-xs" data-toggle="modal"><i class="fa fa-send-o"> 编辑</i></button>
                                        {/if}
                                        {/if}
                                        {if in_array('/sys/role/del',Yii::$app->params['powers'])}
                                        {if $v.type != 1}
                                                <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" onclick="layers.del('{Url::toRoute(["/sys/role/del",'id' => $v.id])}', 'id={$v.id}&_csrf={yii::$app->request->csrfToken}')"><i class="fa fa-trash-o"> 删除</i></button>
                                        {else}
                                            <button type="button" class="btn btn-default btn-xs" data-toggle="modal"><i class="fa fa-send-o"> 删除</i></button>
                                        {/if}
                                        {/if}
                                    </td>
                                </tr>
                            {/foreach}

                            </tbody>
                        {/if}
                    </table>
                    {$this->render('../_page.tpl', ['page' => $page, 'count' => $count])}
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var refreshurl = "{yii::$app->urlManager->createUrl(['sys/role/refresh'])}";
    {literal}
    $(function ($) {
        //刷新权限
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
