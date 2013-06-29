<?php

class DevelopController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index', 'view'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('publish','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function getActionParams() { return array_merge($_GET, $_POST); }

	public function actionView($id)
	{
		$this->redirect(array('game/view','id'=>$id));
	}

	function mkdirs($dir)  
	{  
		if(!is_dir($dir))  
		{  
			if(!$this->mkdirs(dirname($dir))){  
				return false;  
			}  
			if(!mkdir($dir)){  
				return false;  
			}  
		}  
		return true;  
	}  

	private function saveThumbAndData($model)
	{
		$data = CUploadedFile::getInstance($model, 'gameData');  
		$gameBasePath = Yii::app()->basePath.'/../uploads/games/'.$model->id;
		$gameBaseUrl = Yii::app()->baseUrl.'/uploads/games/'.$model->id;

		if ( is_object($data) && get_class($data) === 'CUploadedFile' ){  
		    $model->deploy_url = $gameBaseUrl.'/data.zip';  
		} 
		$thumb = CUploadedFile::getInstance($model, 'thumbData');  

		if ( is_object($thumb) && get_class($thumb) === 'CUploadedFile' ){  
		    $model->thumb = $gameBaseUrl.'/thumb.'.$thumb->getExtensionName();  
		} 

		if($model->save()) {
			if (!file_exists($gameBasePath))
				$this->mkdirs($gameBasePath);
			if(is_object($data) && get_class($data) === 'CUploadedFile'){  
		        $data->saveAs($gameBasePath.'/data.zip');  
		    }  
		    if(is_object($thumb) && get_class($thumb) === 'CUploadedFile'){  
		        $thumb->saveAs($gameBasePath.'/thumb.'.$thumb->getExtensionName());  
		    } 

			$this->redirect(array('game/view','id'=>$model->game_id));

			return true;
		}

		return false;
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionPublish()
	{
		if(!Yii::app()->user->checkAccess('publishWorks'))
		{
			$this->redirect(Yii::app()->createUrl('site/noauth', 
									array('returnUrl'=>Yii::app()->request->urlReferrer)));
			return;
		}

		$model=new Game;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Game']))
		{
			$model->attributes=$_POST['Game'];
			$model->user_id = Yii::app()->user->id;

			$this->saveThumbAndData($model);
		}

		$this->render('publish',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		if(!Yii::app()->user->checkAccess('publishWorks'))
		{
			$this->redirect(Yii::app()->createUrl('site/noauth', 
									array('returnUrl'=>Yii::app()->request->urlReferrer)));
			return;
		}

		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Game']))
		{
			$model->attributes=$_POST['Game'];

			$this->saveThumbAndData($model);
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(!Yii::app()->user->checkAccess('publishWorks'))
		{
			$this->redirect(Yii::app()->createUrl('site/noauth', 
									array('returnUrl'=>Yii::app()->request->urlReferrer)));
			return;
		}

		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		if(!Yii::app()->user->checkAccess('publishWorks'))
		{
			$this->redirect(Yii::app()->createUrl('site/noauth', 
									array('returnUrl'=>Yii::app()->request->urlReferrer)));
			return;
		}

		$userid = Yii::app()->user->id;
		$dataProvider=new CActiveDataProvider('Game', array(
		    'criteria'=>array(
		        'condition'=>"user_id=$userid",
		    ))
		);
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		if(!Yii::app()->user->checkAccess('publishWorks'))
		{
			$this->redirect(Yii::app()->createUrl('site/noauth', 
									array('returnUrl'=>Yii::app()->request->urlReferrer)));
			return;
		}
		
		$model=new Game('search');
		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['Game']))
			$model->attributes=$_GET['Game'];

		$model->user_id = Yii::app()->user->id;

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Game the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Game::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Game $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='game-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
