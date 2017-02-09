{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{if !empty($adminMenu)}
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <tr>
                                <th>ID</th>
                                <th>名称</th>
                                <th>URL</th>
                                <th>是否可用</th>
                                <th>操作</th>
                            </tr>
                            <tbody>
                            {foreach from=$adminMenu key=k item=v}
                                <tr>
                                    <td><a class="a-btn icon-plus-square" href="javascript:void(0);">{$v.id}</a></td>
                                    <td>{$v.title}</td>
                                    <td>{$v.url}</td>
                                    <td>
                                        {if $v.status == 1}
                                            <a class="btn btn-primary btn-xs">可用</a>
                                        {else}
                                            <a class="btn btn-danger btn-xs">不可用</a>
                                        {/if}
                                    </td>
                                    <td>
                                        {*{if in_array('/sys/menu/edit', Yii::$app->params['powers'])}*}
                                            <button type="button" class="btn btn-primary btn-xs" onclick="layers.open('{Url::toRoute(["/sys/menu/edit","id" => $v.id])}', '编辑动作', 500, 400)"><i class="fa fa-edit"> 编辑</i></button>
                                        {*{/if}*}
                                        {*{if in_array('/sys/menu/del', Yii::$app->params['powers'])}*}
                                            <button type="button" class="btn btn-danger btn-xs" onclick="layers.del('{Url::toRoute(["/sys/menu/del",'id' => $v.id])}', '_csrf={yii::$app->request->csrfToken}')"><i class="fa fa-trash-o"> 删除</i></button>
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
    </div>
{else}
    <div class="ibox-content">
        <div class="alert alert-danger">抱歉，暂无动作信息</div>
    </div>
{/if}