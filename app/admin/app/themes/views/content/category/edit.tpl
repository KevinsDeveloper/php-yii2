{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{$this->render('_form.tpl', [
    'title' => '编辑栏目',
    'url' => Url::toRoute(['/content/category/edit']),
    'model' => $model,
    'parentid' => $parentid,
    'tmp' => $tmp,
    'attributeLabels' => $attributeLabels
])}