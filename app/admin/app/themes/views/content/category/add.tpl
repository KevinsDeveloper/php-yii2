{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{$this->render('_form.tpl', [
    'parentid' => $parentid,
    'title' => '创建栏目',
    'url' => Url::toRoute(['/content/category/add']),
    'model' => $model,
    'tmp' => $tmp,
    'attributeLabels' => $attributeLabels
])}