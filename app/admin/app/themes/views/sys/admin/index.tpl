{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        {if in_array('/sys/admin/add',Yii::$app->params['powers'])}
        <button class="btn btn-success" data-toggle="modal" onclick="layers.open('{Url::toRoute(['/sys/admin/add'])}', '添加管理员', 600, 600)"><i class="fa fa-plus"></i> 添加管理员</button>
        {/if}
        <button class="btn btn-warning" type="reset" onclick="location.reload();"><i class="fa fa-undo"></i> 刷新</button>
    </div>
    <div class="ibox-content">
        <div class="ibox">
            <div class="ibox-content">
                <table class="table table-striped table-bordered table-hover dataTables-example">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>管理员账号</th>
                        <th>权限组</th>
                        <th>管理员昵称</th>
                        <th>职位</th>
                        <th>邮箱</th>
                        <th>联系电话</th>
                        <th>时间</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach $adminList as $admin}
                        <tr>
                            <td>{$admin.id}</td>
                            <td>{$admin.account}</td>
                            <td>{if !empty($admin.role)}{$admin.role.role_name}{else}--{/if}</td>
                            <td>{$admin.nickname}</td>
                            <td>{$admin.jobs}</td>
                            <td>{$admin.email}</td>
                            <td>{$admin.phone}</td>
                            <td>{$admin.uptime|date_format:"%Y-%m-%d %H:%M:%S"}</td>
                            {if $admin.status == '1'}
                                <td><span class="label label-primary">启用</span></td>
                            {else}
                                <td><span class="label label-danger">禁用</span></td>
                            {/if}
                            <td>
                                {*{if $admin.group.is_admin == 1}*}
                                    {*<button class="btn btn-warning bg-primary btn-xs" disabled="disabled">禁止操作</button>*}
                                {*{else}*}
                                {if in_array('/sys/admin/edit',Yii::$app->params['powers'])}
                                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" onclick="layers.open('{Url::toRoute(["/sys/admin/edit","id" => $admin.id])}', '编辑管理员', 600, 600)"><i class="fa fa-edit"> 编辑</i></button>
                                {/if}
                                {if in_array('/sys/admin/del',Yii::$app->params['powers'])}
                                    <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" onclick="layers.del('{Url::toRoute(["/sys/admin/del"])}','id={$admin.id}&_csrf={yii::$app->request->csrfToken}')"><i class="fa fa-trash-o"> 删除</i></button>
                                {/if}
                                {*{/if}*}
                            </td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
