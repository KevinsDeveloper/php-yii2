{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{$this->render('_form.tpl', [
    'title' => '编辑文章',
    'url' => Url::toRoute(['/content/news/edit', 'id' => $model->id]),
    'model' => $model,
    'attributeLabels' => $attributeLabels,
    'groups' => $groups
])}