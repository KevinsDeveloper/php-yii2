{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    {if in_array('/sys/menu/add', Yii::$app->params['powers'])}
                        <button class="btn btn-success" data-toggle="modal" onclick="layers.open('{Url::toRoute(['/sys/menu/add'])}', '添加', 600, 450)"><i class="fa fa-plus"></i> 添加</button>
                    {/if}
                    <button class="btn btn-warning" type="reset" onclick="location.reload();"><i class="fa fa-undo"></i> 刷新</button>
                </div>
                <div class="ibox-content">
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>名称</th>
                            <th>URL</th>
                            <th>模块</th>
                            <th>控制器</th>
                            <th>方法</th>
                            <th>等级</th>
                            <th>icon</th>
                            <th>是否显示</th>
                            <th>排序</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach from=$menus key=k item=v}
                            <tr>
                                <td><a class="a-btn icon-plus-square" href="javascript:void(0);">{$v.id}</a></td>
                                <td>{$v.title}</td>
                                <td>{$v.url}</td>
                                <td>{$v.module}</td>
                                <td>{$v.controller}</td>
                                <td>{$v.action}</td>
                                <td>{if $v.rank == 1}二级菜单{else}顶级菜单{/if}</td>
                                <td>{$v.icon}</td>
                                <td>
                                    {if $v.status == 1}
                                        <a class="btn btn-primary btn-xs">显示</a>
                                    {else}
                                        <a class="btn btn-danger btn-xs">隐藏</a>
                                    {/if}
                                </td>
                                <td>{$v.orderby}</td>
                                <td>
                                    {if in_array('/sys/menu/edit', Yii::$app->params['powers'])}
                                        <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" onclick="layers.open('{Url::toRoute(["/sys/menu/edit","id" => $v.id])}', '编辑菜单', 600, 600)"><i class="fa fa-edit"> 编辑</i></button>
                                    {/if}
                                    {if in_array('/sys/menu/del', Yii::$app->params['powers'])}
                                        <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" onclick="layers.del('{Url::toRoute(["/sys/menu/del",'id' => $v.id])}', '_csrf={yii::$app->request->csrfToken}')"><i class="fa fa-trash-o"> 删除</i></button>
                                    {/if}
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
