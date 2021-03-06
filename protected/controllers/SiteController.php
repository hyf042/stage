<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
			'api'=>array(
				'class'=>'JApi',
			)
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionAbout()
	{
		//$this->auth_build();
		//return;

		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('about',array('model'=>$model));
	}

	public function actionNoauth($returnUrl)
	{
		$this->render('alert',array('title'=>'No Authorization',
								 'message'=>'You have no authorization to do this operation!',
								 'returnUrl'=>$returnUrl));
	}

	public function actionReturn($returnUrl)
	{
		$this->redirect($returnUrl);
	}

	public function japiPing()
	{
		return array('ret'=>'ok');
	}

	public function auth_build()
	{
		$auth=Yii::app()->authManager;

		$auth->createOperation('publishWorks','publish operations');
		$auth->createOperation('viewWorks','view shop and games');
		$auth->createOperation('playerWorks','player operations');
		$auth->createOperation('adminWorks','admin operations');

		$bizRule='return Yii::app()->user->id=="admin";';
		$task=$auth->createTask('adminTask','admin all',$bizRule);
		$task->addChild('adminWorks');

		$bizRule='return !Yii::app()->user->isGuest;';
		$task=$auth->createTask('playerTask','player task',$bizRule);
		$task->addChild('playerWorks');

		$role=$auth->createRole('player');
		$role->addChild('viewWorks');
		$role->addChild('playerTask');

		$role=$auth->createRole('developer');
		$role->addChild('player');
		$role->addChild('publishWorks');

		$role=$auth->createRole('administrator');
		$role->addChild('adminTask');

		$role=$auth->createRole('guest');
		$role->addChild('viewWorks');
	}
}