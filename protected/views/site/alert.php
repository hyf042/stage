<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Alert';
$this->breadcrumbs=array(
	'Alert',
);
?>

<h2><?php echo $title; ?></h2>

<div class="error">
<?php echo CHtml::encode($message); ?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'back-form',
	'action'=>Yii::app()->createUrl('site/return', array('returnUrl'=>$returnUrl)),
)); ?>

<?php echo CHtml::submitButton('Back'); ?>

<?php $this->endWidget(); ?>

</div>