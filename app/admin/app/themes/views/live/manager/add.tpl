{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{$this->render('_form.tpl', [
'title' => '添加房间管理员',
'url' => Url::toRoute(['/live/manager/add']),
'model' => $model,
'attributeLabels' => $attributeLabels,
'groups' => $groups
])}