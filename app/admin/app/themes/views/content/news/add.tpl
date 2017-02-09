{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{$this->render('_form.tpl', [
    'title' => '添加文章',
    'url' => Url::toRoute(['/content/news/add']),
    'model' => $model,
    'attributeLabels' => $attributeLabels,
    'groups' => $groups
])}