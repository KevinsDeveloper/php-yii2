{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{use class="yii\helpers\Json"}
{use class="lib\Common"}
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        <button class="btn btn-warning" type="reset" onclick="location.reload();"><i class="fa fa-undo"></i> 刷新</button>
    </div>
    <div class="ibox">
        <div class="table-tools clearfix">
            <div class="float-left">
                <form action="{Url::toRoute(['log/index'])}" method="get">
                    <div class="form-inline">
                        <div class="form-group"><span class="search_span">搜索：</span> </div>
                        <div class="form-group">
                            <select class="form-control m-b" name="search[type]" id="class_id">
                                <option value="admin_id" {if isset($smarty.get.search) and  $smarty.get.search.type eq "admin_id"}selected='selected'{/if}>管理员ID</option>
                                <option value="account" {if isset($smarty.get.search) and  $smarty.get.search.type eq "account"}selected='selected'{/if}>管理员账号</option>
                            </select>
                        </div>
                        <div class="form-group" style="margin-left: 10px;">
                            <input type="text" class="form-control m-b" id="keyword" name="search[keyword]" size="15" {if isset($smarty.get.search) and $smarty.get.search.keyword}value="{$smarty.get.search.keyword}"{/if} placeholder="关键词">
                        </div>
                        <div class="form-group"><span class="search_span">起止时间：</span></div>
                        <div class="form-group">
                            <div class="field">
                                <input type="text" class="form-control m-b layer-date" id="stime" name="search[stime]" size="15" {if isset($smarty.get.search) and $smarty.get.search.stime}value="{$smarty.get.search.stime}"{/if} placeholder="开始时间">
                                <input type="text" class="form-control m-b layer-date" id="etime" name="search[etime]" size="15" {if isset($smarty.get.search) and $smarty.get.search.etime}value="{$smarty.get.search.etime}"{/if} placeholder="结束时间">
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary m-b" type="submit">查询</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <div class="ibox-content">
        <div class="ibox">
            <div class="ibox-content">
                <table class="table table-striped table-bordered table-hover dataTables-example">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>管理员ID</th>
                        <th>登录账号</th>
                        <th>昵称</th>
                        <th>登录IP</th>
                        <th>登录时间</th>
                        <th>退出时间</th>
                        <th>登录信息</th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach $logInfo as $admin}
                        <tr>
                            <td>{$admin.id}</td>
                            <td>{$admin.admin_id}</td>
                            <td>{$admin.account}</td>
                            <td>{$admin.nickname}</td>
                            <td>{$admin.login_ip}</td>
                            <td>{$admin.login_time|date_format:"%Y-%m-%d %H:%M:%S"}</td>
                            <td>{$admin.login_out|date_format:"%Y-%m-%d %H:%M:%S"}</td>
                            <td>{Common::arrayToString(Json::decode($admin.login_info))}</td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
                {$this->render('../_page.tpl', ['page' => $page, 'count' => $count])}
            </div>
        </div>
    </div>
</div>

    <link rel="stylesheet" type="text/css" href="/js/time/jquery.datetimepicker.css"/ >
    <script src="/js/time/jquery.datetimepicker.js"></script>
    <script type="text/javascript">
        $(function () {
            $('#stime').datetimepicker({
                lang:'ch'
            });
            $('#etime').datetimepicker({
                lang:'ch'
            });
        });
    </script>