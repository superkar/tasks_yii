<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\SignupForm;
use app\models\User;
use app\models\Task;

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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $total_active_users = User::find()->where(['active' => User::STATUS_ACTIVE])->count();
        $total_inactive_users = User::find()->where(['active' => User::STATUS_INACTIVE])->count();
        $total_users = User::find()->count();
        
        $total_inwork_tasks = Yii::$app->user->isGuest ?
            Task::find()->where(['status' => Task::STATUS_IN_WORK])->count() :
            Task::find()->where(['status' => Task::STATUS_IN_WORK, 'user_id' => Yii::$app->user->identity->id])->count();
        $total_completed_tasks = Yii::$app->user->isGuest ?
            Task::find()->where(['status' => Task::STATUS_COMPLETED])->count() :
            Task::find()->where(['status' => Task::STATUS_COMPLETED, 'user_id' => Yii::$app->user->identity->id])->count();
        $total_tasks = Yii::$app->user->isGuest ?
            Task::find()->count() :
            Task::find()->where(['user_id' => Yii::$app->user->identity->id])->count();
        
        $total_high_tasks = Yii::$app->user->isGuest ?
            Task::find()->where(['priority' => Task::PRIORITY_HIGH])->count() :
            Task::find()->where(['priority' => Task::PRIORITY_HIGH, 'user_id' => Yii::$app->user->identity->id])->count();
        $total_mid_tasks = Yii::$app->user->isGuest ?
            Task::find()->where(['priority' => Task::PRIORITY_MID])->count() :
            Task::find()->where(['priority' => Task::PRIORITY_MID, 'user_id' => Yii::$app->user->identity->id])->count();
        $total_low_tasks = Yii::$app->user->isGuest ?
            Task::find()->where(['priority' => Task::PRIORITY_LOW])->count() :
            Task::find()->where(['priority' => Task::PRIORITY_LOW, 'user_id' => Yii::$app->user->identity->id])->count();
        
        return $this->render('index', [
            'total_active_users' => $total_active_users,
            'total_inactive_users' => $total_inactive_users,
            'total_users' => $total_users,
            'total_inwork_tasks' => $total_inwork_tasks,
            'total_completed_tasks' => $total_completed_tasks,
            'total_tasks' => $total_tasks,
            'total_high_tasks' => $total_high_tasks,
            'total_mid_tasks' => $total_mid_tasks,
            'total_low_tasks' => $total_low_tasks,
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

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
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

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    
    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Спасибо за регистрацию! Вы можете войти в систему, используя указанные имя пользователя и пароль.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }
    
    public function afterAction($action, $result)
    {
        if (Yii::$app->request->isAjax && !empty(Yii::$app->session->getAllFlashes())) {
            echo Alert::widget();
        }
        return parent::afterAction($action, $result);
    }
}
