<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model admin\models\DbAdmin */
/* @var $form ActiveForm */
?>
<div class="login">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'group_id') ?>
        <?= $form->field($model, 'account') ?>
        <?= $form->field($model, 'passwd') ?>
        <?= $form->field($model, 'status') ?>
        <?= $form->field($model, 'adtime') ?>
        <?= $form->field($model, 'uptime') ?>
        <?= $form->field($model, 'phone') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'nickname') ?>
        <?= $form->field($model, 'codes') ?>
        <?= $form->field($model, 'jobs') ?>
        <?= $form->field($model, 'token') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- login -->
