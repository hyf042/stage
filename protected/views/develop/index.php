<?php
/* @var $this DeveloperController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Develop',
);

$this->menu=array(
	array('label'=>'Publish Game', 'url'=>array('Publish')),
	array('label'=>'Manage Game', 'url'=>array('admin')),
);
?>

<h1>Your Games</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'gamelist_view',
)); ?>
