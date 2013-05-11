<?php

class GameController extends Controller
{
	public function actions()
	{
		return array(
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
			array('allow',  // deny all users
				'users'=>array('@'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/*
	 * API Region Begin
	 */
	public function japiGet_Info($id)
	{
		$model = $this->loadModel($id);
		if ($model == null)
			return array('ret'=>'failed', 'reason'=>'no such game');

		return array('ret'=>'ok', 'info'=>$model->attributes);
	}
	public function japiGet_All()
	{
		$games = Game::model()->findAll();
		$games_info = array();
		foreach ($games as $game)	
			array_push($games_info, $game->attributes);
		return array('ret'=>'ok', 'list'=>$games_info);
	}
	/*
	 * API Region End
	 */

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
}
