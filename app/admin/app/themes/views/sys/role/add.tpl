{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{$this->render('_form.tpl', [
'title' => '添加权限组',
'url' => Url::toRoute(['/sys/role/add']),
'model' => $model,
'attributeLabels' => $attributeLabels
])}