<?php

namespace app\controllers;

use app\models\News;
use yii\data\ActiveDataProvider;
use yii\data\Sort;
use yii\web\Controller;
use Yii;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $sort = new Sort([
            'attributes' => [
                'created_at' => [
                    'label' => 'Date',
                ],
            ],
            'defaultOrder' => [
                'created_at' => SORT_DESC,
            ]
        ]);

        $provider = new ActiveDataProvider([
            'query' => News::find()
                ->where(['is_active' => true])
                ->orderBy($sort->orders),
            'pagination' => [
                'pageSize' => 3,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $provider,
            'sort' => $sort,
        ]);
    }
}
