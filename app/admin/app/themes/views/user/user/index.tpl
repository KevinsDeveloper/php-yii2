{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        {if in_array('/sys/menu/add', Yii::$app->params['powers'])}
            <button class="btn btn-success" data-toggle="modal" onclick="layers.full('{Url::toRoute(['/user/user/add'])}', '添加用户', 600, 450)"><i class="fa fa-plus"></i> 添加用户</button>
        {/if}
        <button class="btn btn-warning" type="reset" onclick="location.reload();"><i class="fa fa-undo"></i> 刷新</button>
    </div>

    <div class="ibox-content">
        <div class="table-tools clearfix">
            <div class="float-left">
                <form action="{Url::toRoute(['user/index'])}" method="get">
                    <div class="form-inline">
                        <div class="form-group"><span class="search_span">注册平台：</span></div>
                        <div class="form-group">
                            <select class="form-control m-b" name="search[source]" id="class_id">
                                <option value="" {if isset($smarty.get.search) and $smarty.get.search.source eq ""}selected='selected'{/if}>全部</option>
                                <option value="100" {if isset($smarty.get.search) and $smarty.get.search.source eq "100"}selected='selected'{/if}>官网</option>
                                <option value="wap" {if isset($smarty.get.search) and $smarty.get.search.source eq "wap"}selected='selected'{/if}>微网站</option>
                                <option value="handan" {if isset($smarty.get.search) and $smarty.get.search.source eq "handan"}selected='selected'{/if}>喊单</option>
                                <option value="app" {if isset($smarty.get.search) and  $smarty.get.search.source eq "app"}selected='selected'{/if}>APP</option>
                                <option value="hbweb" {if isset($smarty.get.search) and $smarty.get.search.source eq "hbweb"}selected='selected'{/if}>WEB过年红包</option>
                                <option value="hbwap" {if isset($smarty.get.search) and $smarty.get.search.source eq "hbwap"}selected='selected'{/if}>WAP过年红包</option>
                                <option value="web-送1200活动" {if isset($smarty.get.search) and $smarty.get.search.source eq "web-送1200活动"}selected='selected'{/if}>WEB-送1200活动</option>
                                <option value="wap-送1200活动" {if isset($smarty.get.search) and $smarty.get.search.source eq "wap-送1200活动"}selected='selected'{/if}>WAP-送1200活动</option>
                            </select>
                        </div>
                        <div class="form-group"><span class="search_span">激活状态：</span></div>
                        <div class="form-group">
                            <select class="form-control m-b" name="search[user_status]" id="class_id">
                                <option value="">全部</option>
                                <option value="1" {if isset($smarty.get.search) and $smarty.get.search.user_status eq "1"}selected='selected'{/if}>激活</option>
                                <option value="100" {if isset($smarty.get.search) and $smarty.get.search.user_status eq "100"}selected='selected'{/if}>非激活</option>
                                <option value="3" {if isset($smarty.get.search) and $smarty.get.search.user_status eq "3"}selected='selected'{/if}>注销</option>
                                <option value="2" {if isset($smarty.get.search) and $smarty.get.search.user_status eq "2"}selected='selected'{/if}>冻结</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <select class="form-control m-b" name="search[type]" id="class_id">
                                <option value="">全部</option>
                                <option value="real_name" {if isset($smarty.get.search) and $smarty.get.search.type eq "real_name"}selected='selected'{/if}>姓名</option>
                                {if in_array('/user/user/mobile', Yii::$app->params['powers'])}
                                    <option value="mobile" {if isset($smarty.get.search) and $smarty.get.search.type eq "mobile"}selected='selected'{/if}>手机号码</option>
                                {/if}
                                <option value="evidence_num" {if isset($smarty.get.search) and $smarty.get.search.type eq "evidence_num"}selected='selected'{/if}>身份证号码</option>
                                <option value="account_name" {if isset($smarty.get.search) and $smarty.get.search.type eq "account_name"}selected='selected'{/if}>MT4账号</option>
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
                <th>ID</th>
                <th>姓名<br />平台账号</th>
                <th>昵称</th>
                <th>证件号码</th>
                <th>邮箱</th>
                <th>国籍</th>
                <th>手机号</th>
                <th>银行信息</th>
                <th>状态</th>
                <th>注册时间</th>
                <th>邀请人</th>
                <th>推荐人</th>
                <th>注册平台</th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$userInfo key=k item=value name=name}
                <tr>
                    <td>{$value.user_id}</td>
                    <td>{$value.real_name}<br />{$value.account_name}</td>
                    <td>{$value.nickname}</td>
                    <td>
                        {$value.evidence_type}<br />
                        {if in_array('/user/user/idcard', Yii::$app->params['powers'])}
                            {$value.evidence_num}
                        {else}
                            <span class="text-warning">无权查看</span>
                        {/if}
                    </td>
                    <td>{$value.email}</td>
                    <td>{$value.country}</td>
                    <td>
                        {if in_array('/user/user/mobile', Yii::$app->params['powers'])}
                            {$value.mobile}
                        {else}
                            <span class="text-warning"> 无权查看</span>
                        {/if}
                    </td>
                    <td>{$value.bank_name} | {$value.bank_address}<br />{$value.account_num}</td>
                    <td>
                        {if $value.status == 1}
                            <span class="text-info">激活</span>
                        {elseif $value.status == 2}
                            <span class="text-warning">冻结</span>
                        {elseif $value.status == 3}
                            <span class="text-default">注销</span>
                        {else}
                            <span class="text-danger">未激活</span>
                        {/if}
                    </td>
                    <td>{$value.register_time}</td>
                    <td>{$value.a_name}<br />{$value.parent_id}</td>
                    <td>{$value.b_name}<br />{$value.recomend_id}</td>
                    <td>
                        {if $value.register_source == 'wap'}
                            微网站
                        {elseif $value.register_source == 'handan'}
                            PC直播间
                        {elseif $value.register_source == 'wap_handan'}
                            手机直播间
                        {elseif $value.register_source == 'app'}
                            APP
                        {elseif $value.register_source != ''}
                            {$value.register_source}
                        {else}
                            官网
                        {/if}
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
        {$this->render('../_page.tpl', ['page' => $page, 'count' => $count])}
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