<?php

use yii\helpers\Html;
use yii\widgets\LinkSorter;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider /*
/* @var $sort yii\data\Sort */

$this->title = 'Home';
?>
<div class="site-index">

    <div class="row">
        <div class="col-lg-12">
            Sort by <?= $sort->link('created_at') ?>
        </div>
    </div>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '/news/_list',
        'layout' => "{items}\n{pager}",
    ]); ?>
</div>
