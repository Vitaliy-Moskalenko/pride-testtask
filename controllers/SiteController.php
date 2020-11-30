<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

use app\models\Client;
use app\models\ClientSearch;
use app\models\City;
use app\models\Phone;

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
     * Displays Clients list from DB.
     */
    public function actionIndex() {
		
		$searchModel = new ClientSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
		
    }

	 /**
     * Updates Clients data from XML file.
     */
	public function actionUpdate() {		
		
		$xmlData = simplexml_load_file(\Yii::getAlias('@webroot') . '/clients.xml');		
		
		foreach($xmlData as $key => $item) {
			// $id = $this->bchexdec($item['id']);			
			
			// City 
			$modelCity = City::find()->where(['c_name' => $item->city])->one();		
			if(!$modelCity) {  
				$modelCity = new City();				
				$modelCity->c_name = (string)$item->city;				
				if(!$modelCity->save())
					exit(var_dump($modelCity->errors));				
			} 
			
			// Client
			$modelClient = Client::find()->where(['cl_hexid'=>(string)$item['id']])->one();
			// If client not exist - add new record in DB
			if(!$modelClient) {				
				
				$modelClient = new Client();			
			
				$modelClient->cl_hexid           = (string)$item['id'];
				$modelClient->cl_name            = (string)$item->name;
				$modelClient->cl_membership_date = (string)$item->membership_date;
				$modelClient->cl_age             = (int)$item->age;
				$modelClient->cl_city            = (int)$modelCity->c_id; 

				if(!$modelClient->save())
					exit(var_dump($modelClient->errors));
			}
			else {
				$modelClient->cl_age             = (int)$item->age;
				$modelClient->cl_city            = (int)$modelCity->c_id; 

				if(!$modelClient->save())
					exit(var_dump($modelClient->errors));	
				
				$phones = Phone::find()->where(['p_clientId'=>$modelClient->cl_id])->all();
				foreach ($phones as $phone) 
					$phone->delete();					
			}
			
			// Phone				
			foreach($item->numbers->number as $n) {
				$modelPhone = new Phone();
			
				$modelPhone->p_clientId = (int)$modelClient->cl_id;
				$modelPhone->p_number   = (string)$n;
					
				if(!$modelPhone->save())
					exit(var_dump($modelPhone->errors));					
			}			
			
		} // foreach client
		
		// Redirect home with flash message	
		Yii::$app->session->setFlash('success', "<p style='color:green;'>Данные сохранены успешно!</p>");
		return $this->goHome();
			
	}			

	public function bchexdec($hex) {
        if(strlen($hex) == 1) {
            return hexdec($hex);
        } else {
            $remain = substr($hex, 0, -1);
            $last = substr($hex, -1);
            return bcadd(bcmul(16, $this->bchexdec($remain)), hexdec($last));
        }
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
	
	
	
	
}
