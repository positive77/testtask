<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Category;
use app\models\CategoryType;
use app\models\Post;
use yii\data\ActiveDataProvider;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays all Pages.
     *
     * @return string
     */
    public function actionIndex($slugCategory = null,$slugPost = null)
    {
		if ($slugCategory == null && $slugPost == null){			
            return $this->render('index');
		} elseif ($slugCategory != null && $slugPost == null){
			$category = $this->CatBySlug($slugCategory);
            if ($category->type_id != CategoryType::CAT_TYPE_DYNAMIC){
				throw new NotFoundHttpException;('Post not found');
			}			
			$dataProvider = new ActiveDataProvider([
			 'query' => Post::find()->where(['category_id' => $category->id]),
			 'pagination' => [
					'pageSize' => 3
				]
			]);

			return $this->render('post', [
				'dataProvider' => $dataProvider,
				'category' => $category
			]);
		} elseif ($slugCategory != null && $slugPost != null){
			$category = $this->CatBySlug($slugCategory);
			$post = $this->PostBySlug($slugPost);
			if ($post->category_id != $category->id){
				throw new NotFoundHttpException;('Post not found');
			}
			return $this->render('viewPost', [
				'model' => $post,
			]);
			
		}
    }
	
	/**
     * Finds category by slug.
     * @param string $slug
     * @return mixed
     * @throws HttpException if the model cannot be found
     */
	public function CatBySlug($slug){
		$category = Category::find()->where(['LIKE BINARY','slug',$slug])->one();
		if ($category == null){
			throw new NotFoundHttpException;('Category not found');
		}
		return $category;
	}
	
	/**
     * Finds post by slug.
     * @param string $slug
     * @return mixed
     * @throws HttpException if the model cannot be found
     */
	public function PostBySlug($slug){
		$post = Post::find()->where(['LIKE BINARY','slug',$slug])->one();
		if ($post == null){
			throw new NotFoundHttpException;('Post not found');
		}
		return $post;
	}
	
	/**
     * Lists all Category models.
     * @return mixed
     */
    public function actionCategory()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Category::find(),
			'pagination' => [
				'pageSize' => 3
			]
        ]);

        return $this->render('category', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }    
}
