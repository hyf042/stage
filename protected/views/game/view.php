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
	if (!User::model()->findByPK(Yii::app()->user->id)->hasOwnedGame($model->game_id))
		echo CHtml::submitButton('Get it'); 
?>

<?php $this->endWidget(); ?>
