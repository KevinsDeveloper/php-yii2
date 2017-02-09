{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    {if in_array('/sys/pay/add',Yii::$app->params['powers'])}
                        <button class="btn btn-success" data-toggle="modal"  onclick="layers.open('{Url::toRoute(['/sys/pay/add'])}', '添加', 600, 450)"><i class="fa fa-plus"></i> 添加</button>
                    {/if}
                    <button class="btn btn-warning" type="reset" onclick="location.reload();"><i class="fa fa-undo"></i> 刷新</button>
                </div>
                <div class="ibox-content">
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>最小金额</th>
                            <th>最大金额(包括等于)</th>
                            <th>商户代码</th>
                            <th>站点类型</th>
                            <th>添加时间</th>
                            <th>更新时间</th>
                            <th>操作者</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach from=$data key=k item=v}
                            <tr>
                                <td><a class="a-btn icon-plus-square" href="javascript:void(0);">{$v.pid}</a></td>
                                <td>{$v.min_money}</td>
                                <td>{$v.max_money}</td>
                                <td>{$v.pay_code}</td>
                                <td>{if $v.sitetype === 1}WAP{elseif $v.sitetype === 0}WEB{else}其他{/if}</td>
                                <td>{if $v.addtime != 0 }{date("Y-m-d H:i:s", $v.addtime)}{/if}</td>
                                <td>{if $v.uptime != 0 }{date("Y-m-d H:i:s", $v.uptime)}{/if}</td>
                                <td>{$v.admin}</td>
                                <td>
                                    {if in_array('/sys/pay/edit', Yii::$app->params['powers'])}
                                        <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" onclick="layers.open('{Url::toRoute(["/sys/pay/edit","pid" => $v.pid])}', '编辑', 600, 600)"><i class="fa fa-edit"> 编辑</i></button>
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
