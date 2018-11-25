<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'News';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create News', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'title',
            'slug',
            [
                'attribute' => 'category_id',
                'value' => 'category.name',
                'enableSorting' => false,
            ],
            'created_at:datetime',
            'is_active:boolean',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
