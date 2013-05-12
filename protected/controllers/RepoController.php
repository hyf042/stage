<?php

class RepoController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index', 'api'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function getActionParams() { return array_merge($_GET, $_POST); }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$games=User::model()->findByPk(Yii::app()->user->id)->own_games;
		$dataProvider = new CArrayDataProvider($games);
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/*
	 * API Region Begin
	 */
	public function japiGet_All()
	{
		if (Yii::app()->user->isGuest)
			return array('ret'=>'failed', 'reason'=>'not login');

		$games=User::model()->findByPk(Yii::app()->user->id)->own_games;
		$games_info = array();
		foreach ($games as $game)	
			array_push($games_info, $game->attributes);
		return array('ret'=>'ok', 'list'=>$games_info);
	}
	public function japiGet_Status($game_id)
	{
		if (Yii::app()->user->isGuest)
			return array('ret'=>'failed', 'reason'=>'not login');

		$pair = UserAndGame::findPair(Yii::app()->user->id, $game_id);
		if ($pair == null)
			return array('ret'=>'ok', 'status'=>'not own');
		else
			return array('ret'=>'ok', 'status'=>'owned', 'info'=>$pair->attributes);
	}
	/*
	 * API Region End
	 */
}
