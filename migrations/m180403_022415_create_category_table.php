<?php

use yii\db\Migration;
use app\models\CategoryType;

/**
 * Handles the creation of table `category`.
 */
class m180403_022415_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('category', [
            'id' => $this->primaryKey(),
			'name' => $this->string(255)->notNull(),
			'type_id' => $this->integer()->notNull(),
			'slug' => $this->string(255)->notNull(),
			'text' => $this->text(),
			'meta_title' => $this->string(255),
			'meta_keywords' => $this->string(255),
			'meta_description' => $this->string(255),
        ]);
		
		$this->addForeignKey(
            'fk-category_type_id',
            'category',
            'type_id',
            'category_type',
            'id',
            'CASCADE'
        );
		
		for ($i = 1;$i < 6;$i++){
			if ($i > 4){
				$type = CategoryType::CAT_TYPE_STATIC;
			} else {
				$type = CategoryType::CAT_TYPE_DYNAMIC;
			}
			$this->insert('category', [				
				'name' => 'Category number '.$i,
				'type_id' => $type,
				'slug' => 'cat'.$i,
				'text' => 'Category text description - '.$i,
				'meta_title' => 'title for category number '.$i,
				'meta_keywords' => 'keywords for category number '.$i,
				'meta_description' => 'description for category number '.$i,
			]);
		}
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('category');
    }
}
