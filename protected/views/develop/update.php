<?php
/* @var $this DeveloperController */
/* @var $model Game */

$this->breadcrumbs=array(
	'Develop'=>array('index'),
	$model->name=>array('view','id'=>$model->game_id),
	'Update',
);

$this->menu=array(
    array('label'=>'Operations'),
    array('label'=>'View', 'icon'=>'home', 'url'=>array('index')),
    array('label'=>'Publish', 'icon'=>'book', 'url'=>array('Publish')),
    array('label'=>'Manage', 'icon'=>'pencil', 'url'=>array('admin')),
//	array('label'=>'List Game', 'url'=>array('index')),
//	array('label'=>'Publish Game', 'url'=>array('Publish')),
//	array('label'=>'View Game', 'url'=>array('view', 'id'=>$model->game_id)),
//	array('label'=>'Manage Game', 'url'=>array('admin')),
);
?>

<h1>Update Game <?php echo $model->game_id; ?></h1>

<?php echo $this->renderPartial('edit_form', array('model'=>$model)); ?>