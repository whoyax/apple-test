<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Apple */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="apple-form">

    <?php $form = ActiveForm::begin([
            'id' => 'apple-form',
            'enableAjaxValidation' => true,
            'method' => 'post',
    ]); ?>

    <?= $form->field($model, 'size', ['enableAjaxValidation' => true])->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
