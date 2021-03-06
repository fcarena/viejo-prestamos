<?php
/* @var $this LibrosController */
/* @var $data Libros */
?>

<div class="view">
	<b><?php echo CHtml::encode($data->getAttributeLabel('titulo')); ?>:</b>
	<?php echo CHtml::encode($data->titulo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('autor')); ?>:</b>
	<?php echo displayAutores($data->autors);?>
	
    <br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('editorial')); ?>:</b>
	<?php echo CHtml::encode($data->editorial); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ano')); ?>:</b>
	<?php echo CHtml::encode($data->ano); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipo_libro_id')); ?>:</b>
	<?php echo CHtml::encode($data->tipoLibro->descripcion); ?>
	<br />


</div>
