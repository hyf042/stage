<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class RegisterForm extends CFormModel
{
	public $username;
	public $password;
	public $password2;
	public $nickname;
	public $email;
	public $verifyCode;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username, password, password2, nickname, email, verifyCode', 'required'),
			array('nickname', 'length', 'max'=>20, 'min'=>4),
			array('username', 'length', 'max'=>20, 'min'=>5),
			array('email', 'length', 'max'=>128),
			array('email', 'email'),
			array('password', 'length'),
			array('username', 'match', 'pattern'=>'/^[\w\d\s,]+$/', 'message'=>'Tags can only contain word characters and digits.'),
			array('username, email', 'uniqueCheck'),
			array('password2', 'compare', 'compareAttribute'=>'password'),
			// verifyCode needs to be entered correctly
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'username' => 'Username',
			'password' => 'Password',
			'password2' => 'Password Again',
			'nickname' => 'Nickname',
			'verifyCode'=>'Verification Code',
		);
	}

	public function uniqueCheck()
	{
		$user=User::model()->find('LOWER(username)=?',array(strtolower($this->username)));
		if($user != null)
			$this->addError('username', 'username already exists.');
		$user=User::model()->find('email=?',array($this->email));
		if($user != null)
			$this->addError('email', 'email already exists.');
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function register()
	{
		$model = new User;
		$model->username = $this->username;
		$model->password = $model->hashPassword($this->password);
		$model->email = $this->email;
		$model->nickname = $this->nickname;
		$model->wallet = 0.0;
		if ($model->save())
			return true;
		return false;
	}
}
