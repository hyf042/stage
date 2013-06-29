<?php
/* @var $this ShopController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Shop',
);
?>

<div class="span-18">

	<h1>Shop</h1>

	<?php if(!empty($_GET['tag'])): ?>
	<h4>Games Tagged with <i><?php echo CHtml::encode($_GET['tag']); ?></i></h1>
	<?php endif; ?>

	<!--<?php $this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'//game/gamelist_view',
	)); ?>-->
	
	<?php $this->widget('bootstrap.widgets.TbThumbnails', array(
	    'dataProvider'=>$dataProvider,
	    'template'=>"{items}\n{pager}",
	    'itemView'=>'_thumb',
	)); ?>
</div>

<div class="span-6 last">
	<?php $this->widget('TagCloud', array(
		'maxTags'=>Yii::app()->params['tagCloudCount'],
	));?>
</div>
