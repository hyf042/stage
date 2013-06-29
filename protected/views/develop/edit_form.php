<?php
/* @var $this DeveloperController */
/* @var $model Game */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'game-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions'=>array('enctype'=>'multipart/form-data', 'class'=>'develop_form')
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'alias'); ?>
		<?php echo $form->textField($model,'alias',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'alias'); ?>
	</div>

	<!--
	<div class="row">
		<?php echo $form->labelEx($model,'deploy_url'); ?>
		<?php echo $form->textField($model,'deploy_url',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'deploy_url'); ?>
	</div>
	-->

	<div class="row">
		<?php echo $form->labelEx($model,'summary'); ?>
		<?php echo $form->textField($model,'summary',array('size'=>60,'maxlength'=>1024)); ?>
		<?php echo $form->error($model,'summary'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo CHtml::activeTextArea($model,'description',array('rows'=>10, 'cols'=>100)) ?>
		<p class="hint">You may use <a target="_blank" href="http://daringfireball.net/projects/markdown/syntax">Markdown syntax</a>.</p>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<!--
		<?php echo $form->labelEx($model,'thumb'); ?>
		<?php echo $form->textField($model,'thumb',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'thumb'); ?>
		-->
		<?php echo $form->labelEx($model,'thumb'); ?>  
    	<?php echo CHtml::activeFileField($model,'thumbData'); ?>  
    	<?php echo $form->error($model,'thumbData'); ?>  
	</div>

<!--
	<div class="row">  
        <?php echo $form->labelEx($model,'preview'); ?>  
        <?php echo '<img src="'.$model->thumb.'" style="width:200px;" />'; ?>  
    </div>  
-->

	<div class="row">
		<?php echo $form->labelEx($model,'tags'); ?>
		<?php echo $form->textField($model,'tags',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'tags'); ?>
	</div>

	<div class="row">  
    	<?php echo $form->labelEx($model,'data'); ?>  
    	<?php echo CHtml::activeFileField($model,'gameData'); ?>  
    	<?php echo $form->error($model,'gameData'); ?>  
	</div>  

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Publish' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->