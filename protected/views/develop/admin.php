<?php
/* @var $this DeveloperController */
/* @var $model Game */

$this->breadcrumbs=array(
	'Develop'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Operations'),
	array('label'=>'View', 'icon'=>'home', 'url'=>array('index')),
	array('label'=>'Publish', 'icon'=>'book', 'url'=>array('Publish')),
    array('label'=>'Manage', 'icon'=>'pencil', 'url'=>'#', 'active'=>true),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#game-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Games</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('search_form',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'game-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'game_id',
		'name',
		'tags',
		/*
		'download_url',
		'params',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
