<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories list';
$this->registerMetaTag([
	'name' => 'description',
	'content' => 'Default static desc'
	]);
$this->registerMetaTag([
	'name' => 'keywords',
	'content' => 'Default static keys'
	]);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>    

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
						Url::toRoute(['site/index', 'slugCategory' => $data->slug])
					);
				}
			],            
            'text',
            'slug',
			[
				'attribute'=>'type_id',
				'format' => 'raw',
				'value' => function($data){
					return $data->type->name;
				}			
			],             
        ],
    ]); ?>
</div>
