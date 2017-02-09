{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <button class="btn btn-warning" type="reset" onclick="window.location.href='{Url::toRoute(['/trade/out/index'])}'"><i class="fa fa-undo"></i> 刷新</button>
                </div>
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="table-tools clearfix">
                            <div class="float-left">
                                <form action="{Url::toRoute(['out/index'])}" method="get">
                                    <div class="form-inline">
                                        <div class="form-group"><span class="search_span">搜索：</span></div>
                                        <div class="form-group">
                                            <select class="form-control m-b" name="search[tp]" id="class_id">
                                                <option value="3" {if isset($smarty.get.search) and $smarty.get.search.tp eq "3"}selected='selected'{/if}>全部</option>
                                                <option value="1" {if isset($smarty.get.search) and $smarty.get.search.tp eq "1"}selected='selected'{/if}>未处理</option>
                                                <option value="2" {if isset($smarty.get.search) and $smarty.get.search.tp eq "2"}selected='selected'{/if}>已处理</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control m-b" name="search[type]" id="class_id">
                                                <option value="">请选择</option>
                                                <option value="real_name" {if isset($smarty.get.search) and $smarty.get.search.type eq "real_name"}selected='selected'{/if}>用户名</option>
                                                <option value="order_id" {if isset($smarty.get.search) and $smarty.get.search.type eq "order_id"}selected='selected'{/if}>订单号</option>
                                                <option value="account_name" {if isset($smarty.get.search) and $smarty.get.search.type eq "account_name"}selected='selected'{/if}>MT4账号</option>
                                                <option value="remarks" {if isset($smarty.get.search) and $smarty.get.search.type eq "remarks"}selected='selected'{/if}>MT4备注</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control m-b" name="search[typeStatus]" id="class_id">
                                                <option value="">请选择</option>
                                                <option value="all" {if isset($smarty.get.search) and $smarty.get.search.typeStatus eq "all"}selected='selected'{/if}>全部</option>
                                                <option value="1" {if isset($smarty.get.search) and $smarty.get.search.typeStatus eq "1"}selected='selected'{/if}>未审核</option>
                                                <option value="unusual" {if isset($smarty.get.search) and $smarty.get.search.typeStatus eq "unusual"}selected='selected'{/if}>未审核[审核超时]</option>
                                                <option value="9" {if isset($smarty.get.search) and $smarty.get.search.typeStatus eq "9"}selected='selected'{/if}>审核中[风控]</option>
                                                <option value="2" {if isset($smarty.get.search) and $smarty.get.search.typeStatus eq "2"}selected='selected'{/if}>审核通过</option>
                                                <option value="10" {if isset($smarty.get.search) and $smarty.get.search.typeStatus eq "10"}selected='selected'{/if}>审核通过[风控]</option>
                                                <option value="5" {if isset($smarty.get.search) and $smarty.get.search.typeStatus eq "5"}selected='selected'{/if}>取消交易</option>
                                                <option value="11" {if isset($smarty.get.search) and $smarty.get.search.typeStatus eq "11"}selected='selected'{/if}>取消交易[风控]</option>
                                                <option value="4" {if isset($smarty.get.search) and $smarty.get.search.typeStatus eq "4"}selected='selected'{/if}>交易失败</option>
                                                <option value="3" {if isset($smarty.get.search) and $smarty.get.search.typeStatus eq "3"}selected='selected'{/if}>交易成功</option>
                                                <option value="12" {if isset($smarty.get.search) and $smarty.get.search.typeStatus eq "12"}selected='selected'{/if}>客服审核</option>
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
                    </div>
                    <div class="ibox-content">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                            <tr>
                                <th width="4%">交易ID</th>
                                <th width="5%">MT4账号</th>
                                <th width="4%">姓名</th>
                                <th width="6%">联系电话</th>
                                <th width="12%">银行卡号码</th>
                                <th width="5%">申请金额</th>
                                <th width="5%">出金金额</th>
                                <th width="6%">申请时间</th>
                                <th width="6%">审核时间</th>
                                <th width="10%">风控备注</th>
                                <th width="10%">客服备注</th>
                                <th width="10%">财务备注</th>
                                <th width="6%">交易状态</th>
                                <th width="6%">MT4处理状态</th>
                                <th>MT4操作时间</th>
                            </tr>
                            </thead>
                            <tbody>
                            {foreach from=$trade_list key=k item=value name=name}
                                <tr>
                                    <td>{$value.t_id}</td>
                                    <td>{$value.account_name}</td>
                                    <td>{$value.real_name}</td>
                                    <td>
                                        {if in_array('/trade/out/mobile', Yii::$app->params['powers'])}
                                            {$value.mobile}
                                        {else}
                                            <span class="text-warning">无权查看</span>
                                        {/if}
                                    </td>
                                    <td>{$value.bank_name}<br />{$value.bank_address}<br />{$value.account_num}</td>
                                    <td>{$value.money}</td>
                                    <td>{$value.realmoney}</td>
                                    <td>{$value.transaction_time}</td>
                                    <td>{$value.sh_time}</td>
                                    <td>{$value.fk_remark}</td>
                                    <td>{$value.sh_remark}</td>
                                    <td>{$value.money_remark}{$value.remarks}</td>
                                    <td>
                                        {if $value.status eq "2"}
                                            <span class="text-success">审核通过<br />[客服]</span>
                                        {elseif $value.status eq "3"}
                                            <span class="text-success">交易成功</span>
                                        {elseif $value.status eq "4"}
                                            <span class="text-danger">交易失败</span>
                                        {elseif $value.status eq "5"}
                                            <span class="text-warning">取消交易[客服]</span>
                                        {elseif $value.status eq "6"}
                                            <span class="text-warning">客户已确认</span>
                                        {elseif $value.status eq "9"}
                                            <span class="text-info">审核中<br />[风控]</span>
                                        {elseif $value.status eq "10"}
                                            <span class="text-success">审核通过<br />[风控]</span>
                                        {elseif $value.status eq "11"}
                                            <span class="text-warning">取消交易<br />[风控]</span>
                                        {elseif $value.status eq "12"}
                                            <span class="text-info">客服审核</span>
                                        {else}
                                            <span class="text-danger">未审核</span>
                                        {/if}
                                        {if $value.unusual eq "1"}<br /><span class="text-danger">(审核超时)</span>{/if}
                                    </td>
                                    <td>
                                        {if $value.mt_status eq "1"}
                                            <a class="text-primary">[自动] <br /> 出金中</a>
                                        {elseif $value.mt_status eq "2"}
                                            <a class="text-success">[手动] <br /> 出金成功</a>
                                        {elseif $value.mt_status eq "3"}
                                            <a class="text-success">[自动] <br /> 出金成功</a>
                                        {elseif $value.mt_status eq "4"}
                                            <a class="text-danger">[自动] <br /> 出金失败</a>
                                        {else}
                                            <a class="text-info">未处理</a>
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