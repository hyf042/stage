<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $user_id
 * @property string $username
 * @property string $password
 * @property string $nickname
 * @property string $email
 * @property double $wallet
 * @property string $params
 *
 * The followings are the available model relations:
 * @property Comment[] $comments
 * @property Game[] $games
 * @property UnderVerifiedGame[] $underVerifiedGames
 * @property Game[] $staGames
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user}}';
	}

	public function behaviors(){
		return array( 'CAdvancedArBehavior' => array(
			'class' => 'application.extensions.CAdvancedArBehavior'));
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, nickname, email, wallet', 'required'),
			array('wallet', 'numerical'),
			array('username, nickname', 'length', 'max'=>20),
			array('password, email', 'length', 'max'=>128),
			array('params', 'length', 'max'=>1024),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, username, password, nickname, email, wallet, params', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'comments' => array(self::HAS_MANY, 'Comment', 'user_id'),
			'published_games' => array(self::HAS_MANY, 'Game', 'user_id'),
			'underVerifiedGames' => array(self::HAS_MANY, 'UnderVerifiedGame', 'user_id'),
			'own_games' => array(self::MANY_MANY, 'Game', '{{UserAndGame}}(user_id, game_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'ID',
			'username' => 'Username',
			'password' => 'Password',
			'nickname' => 'Nickname',
			'email' => 'Email',
			'wallet' => 'Wallet',
			'params' => 'Params',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('nickname',$this->nickname,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('wallet',$this->wallet);
		$criteria->compare('params',$this->params,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/*
	 * Interface Functions
	 */
	public function getId()
	{
		return $this->user_id;
	}
	public function validatePassword($password)
	{
		return crypt($password,$this->password)===$this->password;
	}
	public function hashPassword($password)
	{
		return crypt($password, '$1$');
	}
	public function hasOwnedGame($game_id)
	{
		$game = Game::model()->findByPk($game_id);
		$games = $this->own_games;
		foreach ($games as $game)
			if ($game->game_id == $game_id)
				return true;
		return false;
	}
	public function hasPublishedGame($game_id)
	{
		$game = Game::model()->findByPk($game_id);
		$games = $this->published_games;
		foreach ($games as $game)
			if ($game->game_id == $game_id)
				return true;
		return false;
	}
}