<?php

use yii\db\Migration;
use app\models\CategoryType;

/**
 * Handles the creation of table `category_type`.
 */
class m180403_021121_create_category_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('category_type', [
            'id' => $this->primaryKey(),
			'name' => $this->string(12)->notNull()
        ]);
		
		$this->insert('category_type', [
            'id' => CategoryType::CAT_TYPE_DYNAMIC,
            'name' => 'dynamic',
        ]);
		$this->insert('category_type', [
            'id' => CategoryType::CAT_TYPE_STATIC,
            'name' => 'static',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('category_type');
    }
}
