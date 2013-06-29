<?php
/* @var $this CommentController */
/* @var $model Comment */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comment-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

<div class="comment">
	<div class="row">
		<?php echo $form->textField($model,'content',array('size'=>60,'maxlength'=>1024,'value'=>'Leave a message', 'id'=>'msgbox')); ?>
		<?php echo $form->error($model,'content'); ?>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
		    'label'=>($model->isNewRecord ? 'Create' : 'Save'),
		    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
		    'size'=>'small', // null, 'large', 'small' or 'mini'
		    'htmlOptions'=>array('class'=>'submit')
		)); ?>
	</div>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script language="javascript">
    var s=document.getElementById("msgbox");
    s.onfocus=function(){if(this.value==this.defaultValue)this.value=''};
    s.onblur=function (){if(/^\s*$/.test(this.value)){this.value=this.defaultValue;this.style.color='#aaa'}}
    s.onkeydown=function(){this.style.color='#333'}
</script>