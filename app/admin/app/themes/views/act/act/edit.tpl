{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{$this->render('_form.tpl', [
'title' => '编辑栏目',
'url' => Url::toRoute(['/act/act/edit']),
'model' => $model,
'attributeLabels' => $attributeLabels,
'act_list' => $act_list,
'act_list_select' => $act_list_select
])}