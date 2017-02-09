{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{$this->render('_setting_form.tpl', [
'title' => '房间设置',
'url' => Url::toRoute(['/live/room/setting', 'id' => $model->room_id]),
'model' => $model,
'attributeLabels' => $attributeLabels,
'groups' => $groups
])}