{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{$this->render('_form.tpl', [
'title' => '编辑菜单',
'url' => Url::toRoute(['/sys/menu/edit','id'=>$model.id]),
'model' => $model,
'attributeLabels' => $attributeLabels,
'res'=>$res
])}