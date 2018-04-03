<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category_type".
 *
 * @property int $id
 * @property string $name
 *
 * @property Category[] $categories
 */
class CategoryType extends \yii\db\ActiveRecord
{
	const CAT_TYPE_DYNAMIC = 1;
	const CAT_TYPE_STATIC = 2;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['type_id' => 'id'])->inverseOf('type');
    }
}
