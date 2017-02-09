{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{$this->render('_form.tpl', [
'title' => '添加菜单',
'url' => Url::toRoute(['/sys/pay/add']),
'model' => $model,
'attributeLabels' => $attributeLabels,
'psetting'=>$psetting
])}