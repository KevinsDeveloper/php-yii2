{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{$this->render('_form.tpl', [
'title' => '编辑广告',
'url' => Url::toRoute(['/ads/ads/edit']),
'model' => $model,
'attributeLabels' => $attributeLabels
])}