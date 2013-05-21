<?php
/* @var $this DeveloperController */
/* @var $model Game */

$this->breadcrumbs=array(
	$model->name,
);
$this->pageTitle=$model->name;
?>

<?php $this->renderPartial('_view', array(
	'data'=>$model,
)); ?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'buy-form',
	'action'=>Yii::app()->createUrl('shop/buy', array('game_id'=>$model->game_id)),
	'method'=>'get',
)); ?>
<?php
	if (!Yii::app()->user->isGuest)
	{
		echo '<p/> <div align="center">';
		$this->beginWidget('bootstrap.widgets.TbHeroUnit');
		if(!User::model()->findByPK(Yii::app()->user->id)->hasOwnedGame($model->game_id))
		{
			$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
	        'type'=>'primary',
	        'size'=>'large',
	        'label'=>'Get it',
	        ));
			//echo CHtml::submitButton('Get it');
		}
		else
		{
			echo 'You already own this game.';
		}
		$this->endWidget();
		echo '</div>'; 
	}
?>

<?php $this->endWidget(); ?>
