{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{$this->render('_simplewapform.tpl', [
    'title' => '编辑栏目',
    'url' => Url::toRoute(['/content/page/editwap', 'id' => $model->id]),
    'model' => $model,
    'attributeLabels' => $attributeLabels
])}