<?php

namespace app\controllers;

use app\models\Category;
use app\models\Comment;
use app\models\News;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;

class NewsController extends Controller
{
    /**
     * Displays news.
     *
     * @param string $slug
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($slug)
    {
        $model = $this->findModelBySlug($slug);

        $dataProvider = new ActiveDataProvider([
            'query' => Comment::find()
                ->where(['news_id' => $model->id])
                ->orderBy(['id' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'model' => $model,
            'path' => Category::getPath($model->category_id),
            'comment' => new Comment(),
        ]);
    }

    /**
     * Finds the News model based on its slug value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $slug
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelBySlug($slug)
    {
        if (($model = News::findOne(['slug' => $slug])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException();
        }
    }
}
