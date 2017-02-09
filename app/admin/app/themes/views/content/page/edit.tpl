{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{$this->render('_simpleform.tpl', [
    'title' => '编辑栏目',
    'url' => Url::toRoute(['/content/page/edit', 'id' => $model->id]),
    'model' => $model,
    'attributeLabels' => $attributeLabels
])}