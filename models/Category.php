<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $name
 *
 * @property Category $parent
 * @property Category[] $categories
 * @property News[] $news
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id'], 'default', 'value' => null],
            [['parent_id'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent Category',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Category::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasMany(News::className(), ['category_id' => 'id']);
    }

    /**
     * @param int $id
     * @return array
     */
    public static function getPath($id)
    {
        $path = Yii::$app->db->createCommand('
                WITH RECURSIVE c1 AS ( 
                    SELECT id, parent_id, name 
                    FROM category 
                    WHERE id = :id 
                    UNION ALL 
                    SELECT c2.id, c2.parent_id, c2.name 
                    FROM c1 
                    JOIN category c2 
                    ON c1.parent_id = c2.id 
                ) SELECT id, name FROM c1 
            ',
            [':id' => $id])->queryAll();
        return array_reverse($path);
    }

    /**
     * @return array
     */
    public static function getAutocomplete()
    {
        return Category::find()
            ->select(['id AS value', 'name AS label'])
            ->asArray()
            ->all();
    }
}
