{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{$this->render('_groupForm.tpl', [
'title' => '添加权限组',
'url' => Url::toRoute(['/sys/role/groupadd','id'=>$model.id]),
'model' => $model,
'attributeLabels' => $attributeLabels,
'plist'=>$plist,
'powerinfo' =>$powerinfo
])}