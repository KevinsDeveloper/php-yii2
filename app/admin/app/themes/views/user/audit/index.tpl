{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        <button class="btn btn-warning" type="reset" onclick="location.reload();"><i class="fa fa-undo"></i> 刷新</button>
    </div>

    <div class="ibox-content">
        <div class="table-tools clearfix">
            <div class="float-left">
                <form action="{Url::toRoute(['audit/index'])}" method="get">
                    <div class="form-inline">
                        <div class="form-group"><span class="search_span">身份证状态：</span></div>
                        <div class="form-group">
                            <select class="form-control m-b" name="search[idStatus]" id="class_id">
                                <option value="" {if isset($smarty.get.search) and $smarty.get.search.idStatus eq ""}selected='selected'{/if}>请选择</option>
                                <option value="100" {if isset($smarty.get.search) and $smarty.get.search.idStatus eq "100"}selected='selected'{/if}>未上传</option>
                                <option value="1" {if isset($smarty.get.search) and $smarty.get.search.idStatus eq "1"}selected='selected'{/if}>审核中</option>
                                <option value="2" {if isset($smarty.get.search) and $smarty.get.search.idStatus eq "2"}selected='selected'{/if}>审核通过</option>
                                <option value="3" {if isset($smarty.get.search) and  $smarty.get.search.idStatus eq "3"}selected='selected'{/if}>审核失败</option>
                            </select>
                        </div>
                        <div class="form-group"><span class="search_span">银行卡状态：</span></div>
                        <div class="form-group">
                            <select class="form-control m-b" name="search[bankStatus]" id="class_id">
                                <option value="">请选择</option>
                                <option value="100" {if isset($smarty.get.search) and $smarty.get.search.bankStatus eq "100"}selected='selected'{/if}>未上传</option>
                                <option value="1" {if isset($smarty.get.search) and $smarty.get.search.bankStatus eq "1"}selected='selected'{/if}>审核中</option>
                                <option value="2" {if isset($smarty.get.search) and $smarty.get.search.bankStatus eq "2"}selected='selected'{/if}>审核通过</option>
                                <option value="3" {if isset($smarty.get.search) and $smarty.get.search.bankStatus eq "3"}selected='selected'{/if}>审核失败</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <select class="form-control m-b" name="search[type]" id="class_id">
                                <option value="">全部</option>
                                <option value="real_name" {if isset($smarty.get.search) and $smarty.get.search.type eq "real_name"}selected='selected'{/if}>姓名</option>
                                {if in_array('/user/audit/mobile', Yii::$app->params['powers'])}
                                    <option value="mobile" {if isset($smarty.get.search) and $smarty.get.search.type eq "mobile"}selected='selected'{/if}>手机号码</option>
                                {/if}
                                <option value="evidence_num" {if isset($smarty.get.search) and $smarty.get.search.type eq "evidence_num"}selected='selected'{/if}>身份证号码</option>
                                <option value="account_name" {if isset($smarty.get.search) and $smarty.get.search.type eq "account_name"}selected='selected'{/if}>MT4账号</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control m-b" id="keyword" name="search[keyword]" size="30" {if isset($smarty.get.search) and $smarty.get.search.keyword}value="{$smarty.get.search.keyword}"{/if} placeholder="关键词">
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
                <th>ID</th>
                <th>姓名<br />平台账号</th>
                <th>手机号</th>
                <th>证件号码</th>
                <th>银行信息</th>
                <th>身份证正面</th>
                <th>身份证反面</th>
                <th>银行附件扫描</th>
                <th>身份证上传时间</th>
                <th>银行卡上传时间</th>
                <th>身份证状态</th>
                <th>银行卡状态</th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$userAttachInfo key=k item=value name=name}
                <tr>
                    <td>{$value.a_id}</td>
                    <td>{$value.account_name}<br />{$value.real_name}</td>
                    <td>
                        {if in_array('/user/audit/mobile', Yii::$app->params['powers'])}
                            {$value.mobile}
                        {else}
                            <span class="text-warning"> 无权查看</span>
                        {/if}
                    </td>
                    <td>
                        {$value.evidence_type}<br />
                        {if in_array('/user/audit/idcard', Yii::$app->params['powers'])}
                            {$value.evidence_num}
                        {else}
                            <span class="text-warning"> 无权查看</span>
                        {/if}
                    </td>
                    <td>{$value.bank_name}<br />{$value.account_num}</td>
                    <td>
                        {if in_array('/user/audit/idcard', Yii::$app->params['powers'])}
                        <a class="btn-sm btn-info" onclick="layers.open('{$value.id_card1}', '身份证正面', 500, 400)">
                            <i class="fa fa-picture-o"></i> 查看
                        </a>
                        {else}
                            <span class="text-warning">无权查看</span>
                        {/if}
                    </td>
                    <td>
                        {if in_array('/user/audit/idcard', Yii::$app->params['powers'])}
                        <a class="btn-sm btn-info" onclick="layers.open('{$value.id_card2}', '身份证反面', 500, 400)">
                            <i class="fa fa-picture-o"></i> 查看
                        </a>
                        {else}
                            <span class="text-warning"> 无权查看</span>
                        {/if}
                    </td>
                    <td>
                        <a class="btn-sm btn-info" onclick="layers.open('{$value.bank_scanning}', '银行卡附件扫描', 500, 400)">
                            <i class="fa fa-picture-o"></i> 查看
                        </a>
                    </td>
                    <td>{$value.idadd_time}</td>
                    <td>{$value.bankadd_time}</td>
                    <td>
                        {if $value.examine_id_ard == 1}
                            <span class="text-info">审核中</span>
                        {elseif $value.examine_id_ard == 2}
                            <span class="text-success">审核通过</span>
                        {elseif $value.examine_id_ard == 3}
                            <span class="text-danger">审核失败</span>
                        {else}
                            <span class="text-warning">未上传</span>
                        {/if}
                    </td>
                    <td>
                        {if $value.examine_bank == 1}
                            <span class="text-info">审核中</span>
                        {elseif $value.examine_bank == 2}
                            <span class="text-success">审核通过</span>
                        {elseif $value.examine_bank == 3}
                            <span class="text-danger">审核失败</span>
                        {else}
                            <span class="text-warning">未上传</span>
                        {/if}
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
        {$this->render('../_page.tpl', ['page' => $page, 'count' => $count])}
    </div>
</div>