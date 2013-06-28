<?php

/**
 * This is the model class for table "{{Game}}".
 *
 * The followings are the available columns in table '{{Game}}':
 * @property integer $game_id
 * @property integer $user_id
 * @property string $name
 * @property string $alias
 * @property double $price
 * @property string $deploy_url
 * @property string $tags
 * @property string $summary
 * @property string $description
 * @property string $thumb
 * @property integer $create_time
 * @property integer $update_time
 * @property string $params
 *
 * The followings are the available model relations:
 * @property Comment[] $comments
 * @property User $user
 * @property User[] $staUsers
 */
class Game extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Game the static model class
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
		return '{{game}}';
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
			array('name, deploy_url', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			//array('deploy_url', 'url'),
			array('name, alias', 'length', 'max'=>128),
			array('deploy_url, tags', 'length', 'max'=>256),
			array('summary, params', 'length', 'max'=>1024),
			array('description', 'length', 'max'=>4096),
			array('thumb', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('game_id, user_id, name, alias, price, deploy_url, tags, summary, description, params', 'safe', 'on'=>'search'),
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
			'comments' => array(self::HAS_MANY, 'Comment', 'game_id'),
			'developer' => array(self::BELONGS_TO, 'User', 'user_id'),
			'owner_users' => array(self::MANY_MANY, 'User', '{{UserAndGame}}(game_id, user_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'game_id' => 'ID',
			'user_id' => 'User',
			'name' => 'Name',
			'alias' => 'Alias',
			'price' => 'Price',
			'deploy_url' => 'Deploy Url',
			'tags' => 'Tags',
			'summary' => 'Summary',
			'description' => 'Description',
			'thumb' => 'Thumb',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
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

		$criteria->compare('game_id',$this->game_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('deploy_url',$this->deploy_url,true);
		$criteria->compare('tags',$this->tags,true);
		$criteria->compare('summary',$this->summary,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('params',$this->params,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function beforeSave()
	{
		if (parent::beforeSave())
		{
			if ($this->price == null)
				$this->price = 0;
			if ($this->alias == null || $this->alias == "")
				$this->alias = "";
			if($this->isNewRecord) {
				$this->create_time=$this->update_time=time();
				$this->update_time=$this->create_time;
			}
			else
				$this->update_time=time();
			return true;
		}
		else
			return false;
	}

	public function getId()
	{
		return $this->game_id;
	}
	/**
	 * @return string the URL that shows the detail of the post
	 */
	public function getUrl()
	{
		return Yii::app()->createUrl('game/view', array(
			'id'=>$this->game_id,
			'name'=>$this->name,
		));
	}
	public function hasOwnerUser($user_id)
	{
		$user = User::model()->findByPk($user_id);
		$owners = $this->owner_users;
		foreach ($owners as $owner)
			if ($owner->user_id == $user_id)
				return true;
		return false;
	}
}