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
	<div class="description">
		<?php
			echo $data->summary;
		?>
	</div>
</div>