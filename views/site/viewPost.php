<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use app\models\CategoryType;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = $model->meta_title;
$this->registerMetaTag([
	'name' => 'description',
	'content' => $model->meta_description
	]);
$this->registerMetaTag([
	'name' => 'keywords',
	'content' => $model->meta_keywords
	]);
$this->params['breadcrumbs'][] = ['label' => $model->category->name, 'url' => Url::toRoute(['site/index', 'slugCategory' => $model->category->slug])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">

    <h1><?= Html::encode($model->name) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [            
            'name',
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
    ]) ?>

</div>
