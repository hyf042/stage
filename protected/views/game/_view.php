<?php
/* @var $this DeveloperController */
/* @var $data Game */
?>

<div class="develop">
	<div class="name">
		<?php echo CHtml::link(CHtml::encode($data->name), $data->url); ?>
	</div>
	<div class="developer">
		published by <?php echo $data->developer->nickname; ?>
	</div>
	<div class="summary">
		<?php
			echo '<p/>'.$data->summary.'<p/>';
		?>
	</div>
	<div class="description">
		<?php
			$this->beginWidget('CMarkdown', array('purifyOutput'=>true));
			echo $data->description;
			$this->endWidget();
		?>
	</div>
</div>