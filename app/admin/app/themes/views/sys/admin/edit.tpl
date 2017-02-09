{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{$this->render('_form.tpl', [
'title' => '编辑管理员',
'url' => Url::toRoute(['/sys/admin/edit', 'id' => $model->id]),
'model' => $model,
'attributeLabels' => $attributeLabels,
'groups' => $groups
])}