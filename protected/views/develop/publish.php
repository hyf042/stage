<?php
/* @var $this DeveloperController */
/* @var $model Game */

$this->breadcrumbs=array(
	'Develop'=>array('index'),
	'Publish',
);

$this->menu=array(
	array('label'=>'List Game', 'url'=>array('index')),
	array('label'=>'Manage Game', 'url'=>array('admin')),
);
?>

<h1>Publish Game</h1>

<?php echo $this->renderPartial('edit_form', array('model'=>$model)); ?>