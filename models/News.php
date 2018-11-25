<?php

namespace app\models;

use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;
use yii\db\Expression;
use Yii;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property int $category_id
 * @property string $created_at
 * @property bool $is_active
 * @property string $slug
 * @property string $title
 * @property string $announcement
 * @property string $content
 *
 * @property Comment[] $comments
 * @property Category $category
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'slug', 'title', 'announcement', 'content'], 'required'],
            [['category_id'], 'default', 'value' => null],
            [['category_id'], 'integer'],
            [['created_at'], 'safe'],
            [['is_active'], 'default', 'value' => true],
            [['is_active'], 'boolean'],
            [['announcement', 'content'], 'string'],
            [['slug', 'title'], 'string', 'max' => 255],
            [['slug'], 'unique'],
            [['title'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'sluggable' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
            ],
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ],
        ];   
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category',
            'created_at' => 'Date',
            'is_active' => 'Active',
            'slug' => 'Slug',
            'title' => 'Title',
            'announcement' => 'Announcement',
            'content' => 'Content',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['news_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return Url::toRoute(['news/view', 'slug' => $this->slug]);
    }
}
