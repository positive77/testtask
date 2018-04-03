<?php

use yii\db\Migration;
use app\models\Category;
use app\models\CategoryType;

/**
 * Handles the creation of table `post`.
 */
class m180403_025621_create_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('post', [
            'id' => $this->primaryKey(),
			'name' => $this->string(255)->notNull(),			
			'slug' => $this->string(255)->notNull(),
			'category_id' => $this->integer()->notNull(),
			'text' => $this->text(),
			'meta_title' => $this->string(255),
			'meta_keywords' => $this->string(255),
			'meta_description' => $this->string(255),
        ]);
		
		$this->addForeignKey(
            'fk-post_category_id',
            'post',
            'category_id',
            'category',
            'id',
            'CASCADE'
        );
		
		$cats = Category::find()->all();
		foreach ($cats as $cat){
			for ($i = 1;$i < 5;$i++){
				if ($cat->type_id == CategoryType::CAT_TYPE_DYNAMIC){
					$text = 'Post text - '.$cat->id.'-'.$i.' Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.';
				} else {
					$text = '';
				}
				$this->insert('post', [				
					'name' => 'Post number '.$cat->id.'-'.$i,
					'category_id' => $cat->id,
					'slug' => 'post'.$cat->id.'-'.$i,
					'text' => $text,
					'meta_title' => 'title for post number '.$cat->id.'-'.$i,
					'meta_keywords' => 'keywords for post number '.$cat->id.'-'.$i,
					'meta_description' => 'description for post number '.$cat->id.'-'.$i,
				]);
			}
		}
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('post');
    }
}
