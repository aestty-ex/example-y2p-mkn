<?php

use app\models\Category;
use yii\helpers\Html;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\models\News */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'announcement')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'category_id')->begin(); ?>
    <?= Html::activeLabel($model,'category_id'); ?>
    <?= Html::activeHiddenInput($model, 'category_id'); ?>
    <?= AutoComplete::widget([
            'value' => !empty($model->category) ? $model->category->name : '',
            'clientOptions' => [
                'source' => Category::getAutocomplete(),
                'select' => new JsExpression("function(event, ui) {
                    $('#news-category_id').val(ui.item.value);
                    this.value = ui.item.label;
                    return false;
                }"),
            ],
            'options'=>[
                'class'=>'form-control'
            ]
        ]);
    ?>
    <?= Html::error($model,'category_id', ['class' => 'help-block']); ?>
    <?= $form->field($model, 'category_id')->end(); ?>

    <?= $form->field($model, 'is_active')->checkbox(['checked' => $model->is_active]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
