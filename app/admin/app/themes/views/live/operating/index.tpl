{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        <button class="btn btn-warning" type="reset" onclick="location.reload();"><i class="fa fa-undo"></i> 刷新</button>
    </div>
    <div class="ibox-content">
        <div class="ibox">
            <div class="ibox-content">
                <table class="table table-striped table-bordered table-hover dataTables-example">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>mt4账号</th>
                        <th>昵称</th>
                        <th>原因</th>
                        <th>操作类型</th>
                        <th>操作人</th>
                        <th>时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach $list as $r}
                        <tr>
                            <td>{$r.id}</td>
                            <td>{$mt4}</td>
                            <td>{$r.name}</td>
                            <td>{$r.nickname}</td>
                            <td>{$r.reason}</td>
                            <td>{$r.adminname}</td>
                            <td>{$r.dateline|date_format:"%Y-%m-%d %H:%M:%S"}</td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
