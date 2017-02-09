{use class="yii\helpers\Html"}
{use class="yii\helpers\Url"}
{$this->render('_form.tpl', [
    'title' => '添加用户',
    'url' => Url::toRoute(['/user/user/add']),
    'model' => $model,
    'attributeLabels' => $attributeLabels
])}