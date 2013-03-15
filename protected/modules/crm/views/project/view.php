<?php

/**
 * @var $this Controller
 * @var $model Project
 */
$this->breadcrumbs = array(
	Yii::t('CrmModule.project', 'Projects') => array('admin'),
	$model->name,
);

$this->widget('bootstrap.widgets.TbDetailView', array(
	'data'       => $model,
	'attributes' => array(
		'id',
		'name',
		'name_short',
	),
));
