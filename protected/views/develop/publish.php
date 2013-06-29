<?php
/* @var $this DeveloperController */
/* @var $model Game */

$this->breadcrumbs=array(
	'Develop'=>array('index'),
	'Publish',
);

$this->menu=array(
        array('label'=>'Operations'),
        array('label'=>'View', 'icon'=>'home', 'url'=>array('index')),
        array('label'=>'Publish', 'icon'=>'book', 'url'=>'#', 'active'=>true),
        array('label'=>'Manage', 'icon'=>'pencil', 'url'=>array('admin')),
);
?>

<h1>Publish Game</h1>

<?php echo $this->renderPartial('edit_form', array('model'=>$model)); ?>