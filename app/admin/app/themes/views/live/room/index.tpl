{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        <button class="btn btn-success" data-toggle="modal" onclick="layers.open('{Url::toRoute(['/live/room/add'])}', '添加房间', 600, 600)"><i class="fa fa-plus"></i> 添加房间
        </button>
        <button class="btn btn-warning" type="reset" onclick="location.reload();"><i class="fa fa-undo"></i> 刷新</button>
    </div>
    <div class="ibox-content">
        <div class="ibox">
            <div class="ibox-content">
                <table class="table table-striped table-bordered table-hover dataTables-example">
                    <thead>
                    <tr>
                        <th>房间ID</th>
                        <th>房间名称</th>
                        <th>房间地址</th>
                        <th>添加时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach $list as $r}
                        <tr>
                            <td>{$r.room_id}</td>
                            <td>{$r.room_name}</td>
                            <td>{$r.room_title}</td>
                            <td>{$r.updatetime|date_format:"%Y-%m-%d %H:%M:%S"}</td>
                            <td>
                                {*{if $admin.group.is_admin == 1}*}
                                    {*<button class="btn btn-warning bg-primary btn-xs" disabled="disabled">禁止操作</button>*}
                                {*{else}*}
                                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" onclick="layers.open('{Url::toRoute(["/live/room/edit","id" => $r.room_id])}', '编辑房间', 600, 600)"><i class="fa fa-edit"> 编辑</i></button>
                                    <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" onclick="layers.open('{Url::toRoute(["/live/room/setting","id" => $r.room_id ])}', '房间设置', 600, 600)"><i class="fa fa-trash-o"> 房间设置</i></button>
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
