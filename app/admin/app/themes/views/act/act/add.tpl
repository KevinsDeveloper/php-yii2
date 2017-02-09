{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{$this->render('_form.tpl', [
    'title' => '添加活动',
    'url' => Url::toRoute(['/act/act/add']),
    'model' => $model,
    'attributeLabels' => $attributeLabels,
    'act_list' => $act_list,
    'act_list_select' => $act_list_select
])}