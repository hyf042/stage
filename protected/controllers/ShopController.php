<?php

class ShopController extends Controller
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
				'actions'=>array('index'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('buy', 'api'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Game');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionBuy($game_id)
	{
		$user = User::model()->findByPk(Yii::app()->user->id);
		if ($user->hasOwnedGame($game_id))
		{
			$this->redirect(Yii::app()->user->returnUrl);
			return;
		}
		
		$game = Game::model()->findByPk($game_id);
		$games = $user->own_games;
		array_push($games, $game_id);
		$user->own_games = $games;
		if($user->save())
			$this->redirect(Yii::app()->createUrl('repo/index'));
	}

	public function japiGet_All()
	{
		$games = Game::model()->findAll();
		$games_info = array();
		foreach ($games as $game)	
			array_push($games_info, $game->attributes);
		return array('ret'=>'ok', 'list'=>$games_info);
	}
}
