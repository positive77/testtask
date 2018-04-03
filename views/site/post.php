<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use app\models\CategoryType;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $category->meta_title;
$this->registerMetaTag([
	'name' => 'description',
	'content' => $category->meta_description
	]);
$this->registerMetaTag([
	'name' => 'keywords',
	'content' => $category->meta_keywords
	]);
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => Url::toRoute(['site/category'])];
$this->params['breadcrumbs'][] = $category->name;
?>
<div class="post-index">

    <h1><?= Html::encode($category->name) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
				'attribute'=>'name',
				'format' => 'raw',
				'value' => function($data){
					return Html::a(
						$data->name,
						Url::toRoute(['site/index', 'slugCategory' => $data->category->slug,'slugPost' => $data->slug])
					);
				}
			],
			[
				'attribute'=>'text',
				'format' => 'raw',
				'value' => function($data){
					if ($data->category->type_id == CategoryType::CAT_TYPE_DYNAMIC){
					  return $data->text;
					} else {
					  return $this->renderFile('@app/views/staticPages/'.$data->slug.'.php',[]);
					}
				}			
			],
            'slug',
            [
				'attribute'=>'category_id',
				'format' => 'raw',
				'value' => function($data){
					return $data->category->name;
				}			
			],
        ],
    ]); ?>
</div>
