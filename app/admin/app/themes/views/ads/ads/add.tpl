{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{$this->render('_form.tpl', [
    'title' => '添加广告',
    'url' => Url::toRoute(['/ads/ads/add']),
    'model' => $model,
    'attributeLabels' => $attributeLabels
])}