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
	if (!Yii::app()->user->isGuest && Yii::app()->user->checkAccess('playerWorks'))
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
<div class="comment">
	<?php if($model->commentCount>=1): ?>
		<h4 class="title">
			<?php echo $model->commentCount>1 ? $model->commentCount . ' comments' : 'One comment'; ?>
		</h4>

		<?php $this->renderPartial('_comments',array(
			'post'=>$model,
			'comments'=>$model->comments,
		)); ?>
	<?php endif; ?>

	<div class="bottom"/>

	<?php if( !Yii::app()->user->isGuest ): ?>
		<?php if(Yii::app()->user->hasFlash('commentSubmitted')): ?>
			<div class="flash-success">
				<?php echo Yii::app()->user->getFlash('commentSubmitted'); ?>
			</div>
		<?php else: ?>
			<?php $this->renderPartial('/comment/_form',array(
				'model'=>$comment,
			)); ?>
		<?php endif; ?>
	<?php endif; ?>

</div>

<!--
<div id="disqus_thread"></div>
<script type="text/javascript">
    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
    var disqus_shortname = 'gamestage'; // required: replace example with your forum shortname

    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function() {
        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
</script>
<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
<a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
-->
