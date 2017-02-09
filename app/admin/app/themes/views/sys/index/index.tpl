{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        <button class="btn btn-success" data-toggle="modal" onclick="layers.open('{Url::toRoute(['/system/admin/add'])}', '添加管理员', 600, 600)"><i class="fa fa-plus"></i> 添加管理员
        </button>
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
                        <th>邮箱</th>
                        <th>联系电话</th>
                        <th>时间</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
