<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="span-19">
	<div id="content">
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<div class="span-8 last">
	<div id="sidebar">
	<div class="well" style="padding: 8px">
	<?php
		$this->widget('bootstrap.widgets.TbMenu', array(
		    'type'=>'list',
		    'items'=>$this->menu,
		));
	?>
	</div>
	</div><!-- sidebar -->
</div>
<?php $this->endContent(); ?>