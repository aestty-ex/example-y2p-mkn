<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $model app\models\News */
?>
 
<div class="row">
    <div class="col-lg-12">
        <h2><?= Html::encode($model->title); ?></h2>

        <h6><?= Yii::$app->formatter->asDate($model->created_at) ?></h6>

        <p><?= Html::encode($model->announcement); ?></p>

        <p><a class="btn btn-default" href="<?= $model->getUrl(); ?>">Read &raquo;</a></p>
    </div>
</div>