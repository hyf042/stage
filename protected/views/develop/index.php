<?php
/* @var $this DeveloperController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Develop',
);

$this->menu=array(
    array('label'=>'Operations'),
    array('label'=>'View', 'icon'=>'home', 'url'=>'#', 'active'=>true),
    array('label'=>'Publish', 'icon'=>'book', 'url'=>array('Publish')),
    array('label'=>'Manage', 'icon'=>'pencil', 'url'=>array('admin')),
);
?>

<h1>Your Games</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'//game/gamelist_view',
)); ?>
