<?php

/**
 * @var $this Controller
 * @var $model Client
 */
$this->breadcrumbs = array(
	Yii::t('CrmModule.client', 'Clients') => array('admin'),
    $model->project->name => array('admin', 'id' => $model->project_id),
	$model->client_id,
);
$this->menu['0']['url'] = array('admin', 'id' => $model->project_id);
$this->menu['1']['url'] = array('create', 'id' => $model->project_id);

$this->widget('bootstrap.widgets.TbDetailView', array(
	'data'       => $model,
	'attributes' => array(
		//'id',
		//'project_id',
		'client_id',
		'manager',
		'name_company',
		'name_contact',
		'time_zone',
		'phone',
		'email',
		'site',
		'city',
		'address',
		'driver',
		'product',
		'client_request:html',
		'link_type',
		'sponsor',
		'status',
		'cp',
		'comment_history',
		'comment_fail',
		'contract_copy',
		'comment_review',
		'photo',
		'description_production',
		'create_user_id',
		'update_user_id',
		'create_time',
		'update_time',
		'next_time',
	),
));
