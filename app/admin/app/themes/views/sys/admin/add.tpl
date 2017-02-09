{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{$this->render('_form.tpl', [
'title' => '添加管理员',
'url' => Url::toRoute(['/sys/admin/add']),
'model' => $model,
'attributeLabels' => $attributeLabels,
'groups' => $groups
])}