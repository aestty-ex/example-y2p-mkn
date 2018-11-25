<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider /*
/* @var $model app\models\News */
/* @var $path array */
/* @var $comment app\models\Comment */
/* @var $form yii\widgets\ActiveForm */

$this->title = $model->title;
foreach ($path as $category) {
    $this->params['breadcrumbs'][] = ['label' => $category['name'], 'url' => ['category/view', 'id' => $category['id']]];
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-view">

    <div class="row">
        <div class="col-lg-12">
            <h2><?= Html::encode($this->title) ?></h2>

            <h6><?= Yii::$app->formatter->asDate($model->created_at) ?></h6>

            <p><?= Html::encode($model->content) ?></p>
        </div>
    </div>

    <hr>

    <h4>Comments</h4>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '/comment/_list',
        'layout' => "{items}\n{pager}",
        'emptyText' => false
    ]); ?>

    <div class="comment-form">

        <?php $form = ActiveForm::begin(); ?>
        <?php $form->action = Url::toRoute('comment/create'); ?>
        <?= $form->field($comment, 'news_id')->hiddenInput(['value' => $model->id])->label(false) ?>

        <?= $form->field($comment, 'content')->textarea(['rows' => 6]) ?>

        <div class="form-group">
            <?= Html::submitButton('Add Comment', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
