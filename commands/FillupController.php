<?php

namespace app\commands;

use app\models\Category;
use app\models\Comment;
use app\models\News;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\Expression;

class FillupController extends Controller
{
    /**
     * @param int $amount
     * @return int Exit code
     */
    public function actionAddCategory($amount = 1)
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < $amount; $i++) {
            $category = new Category();
            $category->name = $faker->sentence(4, true);
            if (rand(0, 10) <= 9) {
                $parent = Category::find()->orderBy(new Expression('random()'))->one();
                if ($parent instanceof Category) {
                    $category->parent_id = $parent->id;
                }
            }
            $category->save();
        }

        return ExitCode::OK;
    }

    /**
     * @param int $amount
     * @return int Exit code
     */
    public function actionAddNews($amount = 1)
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < $amount; $i++) {
            $news = new News();
            $news->detachBehavior('timestamp');
            $news->title = $faker->sentence(10, true);
            $category = Category::find()->orderBy(new Expression('random()'))->one();
            if ($category instanceof Category) {
                $news->category_id = $category->id;
            }
            $news->created_at = $faker->dateTime()->format('Y-m-d H:i:s');
            $news->is_active = $faker->boolean();
            $news->announcement = $faker->paragraph(5, true);
            $news->content = $news->announcement . "\n" . $faker->text(2000);
            $news->save();
        }

        return ExitCode::OK;
    }

    /**
     * @param int $amount
     * @return int Exit code
     */
    public function actionAddComment($amount = 1)
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < $amount; $i++) {
            $comment = new Comment();
            $news = News::find()->orderBy(new Expression('random()'))->one();
            if ($news instanceof News) {
                $comment->news_id = $news->id;
            }
            $comment->content = $faker->paragraph(5, true);
            $comment->save();
        }

        return ExitCode::OK;
    }
}
