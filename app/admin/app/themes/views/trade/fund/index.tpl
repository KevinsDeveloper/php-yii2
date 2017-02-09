{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <button class="btn btn-warning" type="reset" onclick="window.location.href='{Url::toRoute(['/trade/fund/index'])}'"><i class="fa fa-undo"></i> 刷新</button>
                </div>
                <div class="ibox-content">

                    <div class="table-tools clearfix">
                        <div class="float-left">
                            <form action="{Url::toRoute(['fund/index'])}" method="get">
                                <div class="form-inline">
                                    <div class="form-group"><span class="search_span">搜索：</span></div>
                                    <div class="form-group">
                                        <select class="form-control m-b" name="search[status]" id="class_id">
                                            <option value="" {if isset($smarty.get.search) and $smarty.get.search.status eq ""}selected='selected'{/if}>全部</option>
                                            <option value="1" {if isset($smarty.get.search) and $smarty.get.search.status eq "1"}selected='selected'{/if}>未处理</option>
                                            <option value="3" {if isset($smarty.get.search) and $smarty.get.search.status eq "3"}selected='selected'{/if}>注资成功</option>
                                            <option value="4" {if isset($smarty.get.search) and $smarty.get.search.status eq "4"}selected='selected'{/if}>注资失败</option>
                                            <option value="10" {if isset($smarty.get.search) and  $smarty.get.search.status eq "10"}selected='selected'{/if}>MT4已入金</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control m-b" name="search[type]" id="class_id">
                                            <option value="">请选择</option>
                                            <option value="m.real_name" {if isset($smarty.get.search) and $smarty.get.search.type eq "m.real_name"}selected='selected'{/if}>用户名</option>
                                            <option value="order_id" {if isset($smarty.get.search) and $smarty.get.search.type eq "order_id"}selected='selected'{/if}>订单号</option>
                                            <option value="account_name" {if isset($smarty.get.search) and $smarty.get.search.type eq "account_name"}selected='selected'{/if}>MT4账号</option>
                                            <option value="remarks" {if isset($smarty.get.search) and $smarty.get.search.type eq "remarks"}selected='selected'{/if}>MT4备注</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control m-b" id="keyword" name="search[keyword]" size="15" {if isset($smarty.get.search) and $smarty.get.search.keyword}value="{$smarty.get.search.keyword}"{/if} placeholder="关键词">
                                    </div>
                                    <div class="form-group">
                                        <div class="field">
                                            <input type="text" class="form-control m-b layer-date" id="stime" name="search[start]" size="15" {if isset($smarty.get.search) and $smarty.get.search.start}value="{$smarty.get.search.start}"{/if} placeholder="开始时间">
                                            <input type="text" class="form-control m-b layer-date" id="etime" name="search[end]" size="15" {if isset($smarty.get.search) and $smarty.get.search.end}value="{$smarty.get.search.end}"{/if} placeholder="结束时间">
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
                            <th>交易ID</th>
                            <th>MT4账号</th>
                            <th>姓名</th>
                            <th>联系电话</th>
                            <th>人民币</th>
                            <th>美元</th>
                            <th>实际人民币</th>
                            <th>实际美元</th>
                            <th>订单号</th>
                            <th>交易状态</th>
                            <th>处理状态</th>
                            <th>入金时间</th>
                            <th>处理时间</th>
                            <th>备注</th>
                            <th>MT4状态</th>
                            <th>MT4处理时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach from=$trade_list key=k item=value name=name}
                            <tr>
                                <td>{$value.t_id}</td>
                                <td>{$value.account_name}</td>
                                <td>{$value.real_name}</td>
                                <td>
                                    {if in_array('/trade/fund/mobile', Yii::$app->params['powers'])}
                                        {$value.mobile}
                                    {else}
                                        <span class="text-warning">无权查看</span>
                                    {/if}
                                </td>
                                <td>{$value.money}</td>
                                <td>{$value.dollar}</td>
                                <td>{$value.realmoney}</td>
                                <td>{$value.realdollar}</td>
                                <td>{$value.order_id}</td>
                                <td>
                                    {if $value.pay_status eq "1"}
                                        <a class="text-primary">已支付</a>
                                    {else}
                                        <a class="text-danger btn-xs">未支付</a>
                                    {/if}
                                </td>
                                <td>
                                    {if $value.status eq "1"}
                                        <a class="text-primary">未处理</>
                                    {elseif $value.status eq "3"}
                                        <a class="text-success">注资成功</a>
                                    {elseif $value.status eq "4"}
                                        <a class="text-danger">注资失败</a>
                                    {elseif $value.status eq "10" || $value.status eq "11"}
                                        <a class="text-success">MT4已入金</a>
                                    {elseif $value.status eq "12"}
                                        <a class="text-danger">MT4入金失败</a>
                                    {/if}
                                </td>
                                <td>{$value.transaction_time}</td>
                                <td>{$value.finish_time}</td>
                                <td>{$value.remarks}</td>
                                <td>
                                    {if $value.mt_status eq "1"}
                                        <a class="text-primary">[自动] 入金中</a>
                                    {elseif $value.mt_status eq "2"}
                                        <a class="text-success">[手动] 入金成功</a>
                                    {elseif $value.mt_status eq "3"}
                                        <a class="text-success">[自动] 入金成功</a>
                                    {elseif $value.mt_status eq "4"}
                                        <a class="text-danger">[自动] 入金失败</a>
                                    {else}
                                        <a class="text-danger">未处理</a>
                                    {/if}
                                </td>
                                <td>{if $value.mt_time }{date("Y-m-d H:i:s", $value.mt_time)}{else}{/if}</td>
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