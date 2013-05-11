<?php
/* @var $this GameController */
/* @var $model Game */

$this->breadcrumbs=array(
	'Games'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Game', 'url'=>array('index')),
	array('label'=>'Create Game', 'url'=>array('create')),
	array('label'=>'Update Game', 'url'=>array('update', 'id'=>$model->game_id)),
	array('label'=>'Delete Game', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->game_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Game', 'url'=>array('admin')),
);
?>

<h1>View Game #<?php echo $model->game_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'game_id',
		'user_id',
		'name',
		'alias',
		'price',
		'deploy_url',
		'tags',
		'summary',
		'description',
		'params',
	),
)); ?>
