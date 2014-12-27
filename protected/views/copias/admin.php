<?php
$this->breadcrumbs=array(
	'Copias'=>array(Yii::t('app', 'index')),
	Yii::t('app', 'Manage'),
);

$this->menu=array(
		array('label'=>Yii::t('app',
				'List Copias'), 'url'=>array('index')),
		array('label'=>Yii::t('app', 'Create Copias'),
				'url'=>array('create')),
			);

		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('copias-grid', {
data: $(this).serialize()
});
				return false;
				});
			");
		?>

<h1> Administrar&nbsp;Copiases</h1>

<?php echo CHtml::link(Yii::t('app', 'Advanced Search'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'copias-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'estado_id',
		'libros_id',
		'nro_copia',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>