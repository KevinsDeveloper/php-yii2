{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{$this->render('_remform.tpl', [
    'title' => '推荐文章',
    'url' => Url::toRoute(['/content/news/rem', 'id' => $model->id]),
    'model' => $model,
    'attributeLabels' => $attributeLabels
])}