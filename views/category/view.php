<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $path array */

$this->title = $model->name;
foreach ($path as $category) {
    $this->params['breadcrumbs'][] = ['label' => $category['name'], 'url' => ['category/view', 'id' => $category['id']]];
}
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="category-view">

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '/news/_list',
        'layout' => "{items}\n{pager}",
    ]); ?>

</div>
