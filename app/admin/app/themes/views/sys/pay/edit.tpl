{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{$this->render('_form.tpl', [
'title' => '编辑菜单',
'url' => Url::toRoute(['/sys/pay/edit','pid'=>$model.pid]),
'model' => $model,
'attributeLabels' => $attributeLabels,
'psetting'=>$psetting
])}