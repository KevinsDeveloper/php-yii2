{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{use class="yii\helpers\Json"}
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">        
        <button class="btn btn-warning" type="reset" onclick="window.location.href='{Url::toRoute(['/content/page/index'])}'"> <i class="fa fa-undo"></i>
            刷新
        </button>
    </div>
    <div class="ibox-content">
        <div class="ibox">
            <div class="table-tools clearfix">
                <div class="float-left">
                    <form action="{Url::toRoute(['page/index'])}" method="get">
                        <div class="form-inline">
                            <div class="form-group"><span class="search_span">搜索：</span></div>
                            <div class="form-group" style="margin-left: 10px;">
                                <div class="">
                                    <input type="text" class="form-control m-b" id="keyword" name="search[keyword]" size="30" {if isset($smarty.get.search) and $smarty.get.search.keyword}value="{$smarty.get.search.keyword}"{/if}  placeholder="栏目名称"></div>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary m-b" type="submit">查询</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="ibox-content">
                <table class="table table-striped table-bordered table-hover dataTables-example">
                    <thead>
                        <tr>
                            <th width="5%">序号</th>
                            <th width="10%">栏目ID</th>
                            <th width="10%">栏目上级ID</th>
                            <th width="20%">栏目名称</th>
                            <th width="25%">URL</th>
                            <th width="10%">更新时间</th>
                            <th width="20%">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach $pagelist as $data}
                        <tr>
                            <td>{$data.id}</td>
                            <td>{$data.category.catid}</td>
                            <td>{$data.category.parentid}</td>
                            <td>{$data.category.catname}</td>
                            <td>{$data.category.url}</td>
                            <td>{$data.updatetime|date_format:"%Y-%m-%d %H:%M:%S"}</td>
                            <td>
                                {if in_array('/content/page/edit', Yii::$app->params['powers'])}
                                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" onclick="layers.full('{Url::toRoute(["/content/page/edit","id" =>$data.id])}', '编辑单页面', 800, 600)">
                                    <i class="fa fa-edit">WEB站</i>
                                </button>
                                {/if}
                                {if in_array('/content/page/editwap', Yii::$app->params['powers'])}
                                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" onclick="layers.full('{Url::toRoute(["/content/page/editwap","id" =>$data.id])}', '编辑单页面', 800, 800)">
                                    <i class="fa fa-edit">WAP站</i>
                                </button>
                                {/if}                              
                            </td>
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
<!-- jQuery Validation plugin javascript-->
<script src="/js/plugins/validate/jquery.form.min.js"></script>
<script src="/js/plugins/validate/jquery.validate.min.js"></script>
<script src="/js/plugins/validate/messages_zh.min.js"></script>
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