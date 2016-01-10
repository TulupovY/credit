<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Credit;

class SiteController extends Controller
{
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

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionCredit()
    {   
        $model= new Credit();
        $credit_date=''; 
        $post_date=  array(
            
                'term'=>'',
                'rate'=>'',
                'rate'=>'',
                'tstartmonth'=>'',
                'startyear'=>'',

            );
        if(Yii::$app->request->isPost)
        {
            $credit_date =$model->credit_calculate(Yii::$app->request->post('Credit')['term'], Yii::$app->request->post('Credit')['rate'], Yii::$app->request->post('Credit')['amount'], Yii::$app->request->post('startmonth'), Yii::$app->request->post('startyear'));
            $post_date=  [
            
                'term'=>Yii::$app->request->post('Credit')['term'],
                'rate'=>Yii::$app->request->post('Credit')['rate'],
                'amount'=>Yii::$app->request->post('Credit')['amount'],
                'startmonth'=>Yii::$app->request->post('startmonth'),
                'startyear'=>Yii::$app->request->post('startyear'),

            ];

        }
        return $this->render('credit', [
            'model' => $model,
            'credit_date'=>$credit_date,
            'post_date'=>$post_date,
        ]);

    }
}
