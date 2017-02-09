{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{use class="yii\widgets\LinkPager"}
<nav>
    <!-- 每页{Yii::$app->params['pageSize']}条&nbsp;&nbsp;共{$count}条 -->
    {LinkPager::widget(['pagination' => $page, 'nextPageLabel' => '下一页', 'prevPageLabel' => '上一页','firstPageLabel' => '首页', 'lastPageLabel'=>'尾页'])}
</nav>