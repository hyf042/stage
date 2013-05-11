<?php
/* @var $this RepositoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Repository',
);
?>

<h1>Your repository</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'gamelist_view',
)); ?>
