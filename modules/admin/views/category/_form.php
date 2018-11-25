<?php

use app\models\Category;
use yii\helpers\Html;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\models\Category */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parent_id')->begin(); ?>
    <?= Html::activeLabel($model,'parent_id'); ?>
    <?= Html::activeHiddenInput($model, 'parent_id'); ?>
    <?= AutoComplete::widget([
            'value' => !empty($model->category) ? $model->category->name : '',
            'clientOptions' => [
                'source' => Category::getAutocomplete(),
                'select' => new JsExpression("function(event, ui) {
                    $('#category-parent_id').val(ui.item.value);
                    this.value = ui.item.label;
                    return false;
                }"),
            ],
            'options'=>[
                'class'=>'form-control'
            ]
        ]);
    ?>
    <?= Html::error($model,'parent_id', ['class' => 'help-block']); ?>
    <?= $form->field($model, 'parent_id')->end(); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
