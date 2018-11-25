<?php

namespace app\controllers;

use app\models\Category;
use app\models\News;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;

class CategoryController extends Controller
{
    /**
     * Displays news by category.
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $dataProvider = new ActiveDataProvider([
            'query' => News::find()
                ->where([
                    'is_active' => true,
                    'category_id' => $id,
                ])
                ->orderBy(['created_at' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 3,
            ],
        ]);
        $path = Category::getPath($model->id);
        array_pop($path);

        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'model' => $model,
            'path' => $path,
        ]);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
