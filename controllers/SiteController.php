<?php

namespace app\controllers;

use \Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\SignUpForm;
use app\models\User;
use yii\web\Cookie;


class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
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
                'class' => VerbFilter::class,
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

    

    public function actionLogout()
    {
        Yii::$app->response->cookies->remove('authKey');
        Yii::$app->user->logout();
        
        return $this->goHome();
    }
    
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        

        $cookies = Yii::$app->response->cookies;

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if ($auth = Yii::$app->user->identity->getAuthKey()){
                $cookies->add(new Cookie([
                    'name'=>'authKey',
                    'value'=>"{$auth}",
                    'expire'=> (time() + 86400)*30,
                ]));
                    return $this->goHome();
                }};
                
                
        
        
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    
    public function actionIndex()
    {
        $cookies = Yii::$app->request->cookies;
        $key = $cookies->getValue('authKey');
        $user = User::find()->where(['authKey'=>$key])->one();
        // Yii::$app->getUser()->login($user);

        if ($user != null){
            return $this->render('index',['name'=>$user->userName,]);
        }
        return $this->render('index',['name'=>'che to ne tak',]);
    }

    public function actionSignUp()
    {
        $model = new SignUpForm();
        $cookies = Yii::$app->response->cookies;

        if($model->load(Yii::$app->request->post()) && $user = $model->createUser()){
            if(Yii::$app->getUser()->login($user)){
                if ($auth = Yii::$app->user->identity->getAuthKey()){
                    $cookies->add(new Cookie([
                    'name'=>'authKey',
                    'value'=>"{$auth}",
                    'expire'=> (time() + 86400)*30,
                ]));
                return $this->goHome();
                }
            }
        }


        return $this->render('signUp', ['model'=>$model]);
    }


}
