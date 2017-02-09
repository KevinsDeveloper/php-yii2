{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{$this->render('_form.tpl', [
'title' => '添加房间',
'url' => Url::toRoute(['/live/room/add']),
'model' => $model,
'attributeLabels' => $attributeLabels,
'groups' => $groups
])}