{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{use class="yii\helpers\Json"}
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        {if in_array('/content/news/add', Yii::$app->params['powers'])}
        <button class="btn btn-success" data-toggle="modal" onclick="window.location.href='{Url::toRoute(['/content/news/add'])}'" ><i class="fa fa-plus"></i> 添加文章
		</button>
        {/if}        
        <button class="btn btn-warning" type="reset" onclick="window.location.href='{Url::toRoute(['/content/news/index'])}'"> <i class="fa fa-undo"></i>
            刷新
        </button>
        
    </div>
    <div class="ibox-content">
        <div class="ibox">
            <div class="table-tools clearfix">
                <div class="float-left">
                    <form action="{Url::toRoute(['news/index'])}" method="get">
                        <div class="form-inline">
                            <div class="form-group"><span class="search_span">搜索：</span></div>
                            <div class="form-group">
                                <select class="form-control m-b" name="search[catid]" id="class_id">
                                    <option value="">请选择</option>
                                    {foreach $moduleid as $key =>$val}
                                    <option value="{$key}" {if isset($smarty.get.search) and  $smarty.get.search.catid eq $key}selected='selected'{/if}>{$val}</option>
                                    {/foreach}
                                </select>
                            </div>
                            <div class="form-group"><span class="search_span">搜索类型：</span></div>
                            <div class="form-group">
                                <select class="form-control m-b" name="search[type]" id="class_id">
                                  <option value="">请选择</option>
                                  <option value="alticle_id" {if isset($smarty.get.search) and  $smarty.get.search.type eq "alticle_id"}selected='selected'{/if}>文章ID</option>
                                  <option value="alticle_title" {if isset($smarty.get.search) and $smarty.get.search.type eq "alticle_title"}selected='selected'{/if}>文章标题</option>
                                </select>
                            </div>

                            <div class="form-group" style="margin-left: 10px;">
                                <div class="">
                                    <input type="text" class="form-control m-b" id="keyword" name="search[keyword]" size="15" {if isset($smarty.get.search) and $smarty.get.search.keyword}value="{$smarty.get.search.keyword}"{/if} placeholder="关键词"></div>
                            </div>
                            <div class="form-group"><span class="search_span">发布时间：</span></div>
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
                <table class="table table-striped table-bordered table-hover dataTables-example">
                    <thead>
                        <tr>
                            <th width="5%">ID</th>
                            <th width="10%">栏目</th>
                            <th width="30%">标题</th>
                            <th width="10%">发布时间</th>
                            <th width="15%">更新时间</th>
                            <th width="10%">推荐</th>
                            <th width="20%">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach $pagelist as $data}
                        <tr>
                            <td>{$data.id}</td>
                            <td>{$data.category.catname}</td>
                            <td>{$data.title}</td>
                            <td>{$data.inputtime|date_format:"%Y-%m-%d %H:%M:%S"}</td>
                            <td>{$data.updatetime|date_format:"%Y-%m-%d %H:%M:%S"}</td>
                            {if $data.recommend == '1'}
                                <td><span class="label label-info">推荐</span></td>
                            {else}
                                <td><span class="label label-danger">不推荐</span></td>
                            {/if}
                            <td>
                                {if in_array('/content/news/rem', Yii::$app->params['powers'])}
                                <button type="button" class="btn btn-info btn-xs" data-toggle="modal" onclick="layers.open('{Url::toRoute(["/content/news/rem","id" =>$data.id])}', '推荐', 300, 300)">
                                    <i class="fa fa-edit">推荐</i>
                                </button>
                                {/if} 
                                {if in_array('/content/news/edit', Yii::$app->params['powers'])}
                                {*<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" onclick="javascript:window.location.href='/content/news/edit.html?id={$data.id}'">*}
                                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" onclick="window.location.href='{Url::toRoute(['/content/news/edit','id'=>$data.id])}'">
                                    <i class="fa fa-edit">修改</i>
                                </button>   
                                {/if} 
                                {if in_array('/content/news/del', Yii::$app->params['powers'])}                          
                                <button type="button" class="btn btn-danger btn-xs removecat" onclick="layers.del('{Url::toRoute(["/content/news/del"])}', 'id={$data.id}&_csrf={yii::$app->request->csrfToken}')">
                                    <i class="fa fa-trash-o">删除</i>
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