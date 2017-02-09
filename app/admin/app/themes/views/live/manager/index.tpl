{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        <button class="btn btn-success" data-toggle="modal" onclick="layers.open('{Url::toRoute(['/live/manager/add'])}', '添加管理员', 600, 600)"><i class="fa fa-plus"></i> 添加房间管理员
        </button>
        <button class="btn btn-warning" type="reset" onclick="location.reload();"><i class="fa fa-undo"></i> 刷新</button>
    </div>
    <div class="ibox-content">
        <div class="ibox">
            <div class="ibox-content">
                <table class="table table-striped table-bordered table-hover dataTables-example">
                    <thead>
                    <tr>
                        <th>用户ID</th>
                        <th>用户组</th>
                        <th>用户名</th>
                        <th>真实姓名</th>
                        <th>昵称</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach $list as $r}
                        <tr>
                            <td>{$r.user_id}</td>
                            <td>{$groups[$r.group_id]}</td>
                            <td>{$r.user_name}</td>
                            <td>{$r.real_name}</td>
                            <td>{$r.nickname}</td>
                            <td>
                                {*{if $admin.group.is_admin == 1}*}
                                    {*<button class="btn btn-warning bg-primary btn-xs" disabled="disabled">禁止操作</button>*}
                                {*{else}*}
                                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" onclick="layers.open('{Url::toRoute(["/live/manager/edit","id" => $r.user_id])}', '编辑', 600, 600)"><i class="fa fa-edit"> 编辑</i></button>
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
