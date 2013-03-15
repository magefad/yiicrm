<?php

/**
 * @var $this Controller
 * @var $model ProjectPartner
 */
$this->breadcrumbs = array(
	Yii::t('CrmModule.projectPartner', 'Project Partners') => array('admin'),
	$model->name,
);
$this->widget('bootstrap.widgets.TbDetailView', array(
	'data'       => $model,
	'attributes' => array(
		'id',
		'project_id',
		'name',
		'name_short',
	),
));
