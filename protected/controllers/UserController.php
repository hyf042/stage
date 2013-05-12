<?php

class UserController extends Controller
{
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			'api'=>array(
				'class'=>'JApi',
			)
		);
	}
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', 
				'actions'=>array('login', 'register', 'logout'),
				'users'=>array('*'),
			),
			array('allow',  // allow all login user
				'users'=>array('@'),
			),
		);
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	public function actionRegister()
	{
	    $model=new RegisterForm;

	    // uncomment the following code to enable ajax-based validation
	    if(isset($_POST['ajax']) && $_POST['ajax']==='register-form')
	    {
	        echo CActiveForm::validate($model);
	        Yii::app()->end();
	    }

	    if(isset($_POST['RegisterForm']))
	    {
	        $model->attributes=$_POST['RegisterForm'];
	        if($model->validate() && $model->register())
	        {
	            // form inputs are valid, do something here
	            $this->redirect(array('login'));
	            return;
	        }
	    }
	    $this->render('register',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	/*
	 * API Region Begin
	 */
	public function japiLogin($username, $password)
	{
		if (!Yii::app()->user->isGuest)
			return array('ret'=>'failed', 'reason'=>'already login');

		$model=new LoginForm;

		$model->attributes=array('username'=>$username, 'password'=>$password, 'rememberMe'=>false);
		// validate user input and redirect to the previous page if valid
		if($model->validate() && $model->login())
			return array('ret'=>'ok');
		else
		{
			if ($model->identity->errorCode == UserIdentity::ERROR_USERNAME_INVALID)
				return array('ret'=>'failed', 'reason'=>'username invalid');
			else if ($model->identity->errorCode == UserIdentity::ERROR_PASSWORD_INVALID)
				return array('ret'=>'failed', 'reason'=>'password invalid');
			else
				return array('ret'=>'failed', 'reason'=>'unknown');
		}
	}
	public function japiLogout()
	{
		if (Yii::app()->user->isGuest)
			return array('ret'=>'failed', 'reason'=>'not login');

		Yii::app()->user->logout();
		return array('ret'=>'ok');
	}
	public function japiGet_Info()
	{
		if (Yii::app()->user->isGuest)
			return array('ret'=>'failed', 'reason'=>'not login');

		return array('ret'=>'ok',
			'info'=>User::model()->findByPk(Yii::app()->user->id)->attributes);
	}
	public function japiTick()
	{
		if (Yii::app()->user->isGuest)
			return array('ret'=>'failed');
		return array('ret'=>'ok');
	}
	/*
	 * API Region End
	 */

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
