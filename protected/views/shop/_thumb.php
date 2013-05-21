<li class="develop">
    <div class="name">
		<?php echo CHtml::link(CHtml::encode($data->name), $data->url); ?>
	</div>
	<div class="developer">
		published by <?php echo $data->developer->nickname; ?>
	</div>
	
	<?php
	$url = $data->url;
	$name = CHtml::encode($data->name);
	echo "<a href=\"$url\" class=\"thumbnail\" rel=\"tooltip\" data-title=\"$name\">";
	if ($data->thumb == null || $data->thumb == '')
		$thumb = Yii::app()->baseUrl . '/images/default_thumb';
	else
		$thumb = $data->thumb;
	?>
        <img src=<?php echo $thumb.' '; ?> alt="" width="280px" height="180px"/>
    </a>

    <div class="summary">
		<?php
			echo $data->summary;
		?>
	</div>
</li>