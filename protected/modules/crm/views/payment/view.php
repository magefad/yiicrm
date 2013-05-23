<?php

/**
 * @var $this Controller
 * @var $model Payment
 */
$this->breadcrumbs = array(
	Yii::t('CrmModule.payment', 'Payments') => array('admin'),
	$model->id,
);

$this->widget('bootstrap.widgets.TbDetailView', array(
	'data'       => $model,
	'attributes' => array(
		'id',
		'client_id',
		'partner_id',
		'name_company',
		'name_contact',
		'clientCity',
		'comments',
		'payment_amount',
		'payment',
		'payment_remain',
		'agent_comission_percent',
		'agent_comission_amount',
		'agent_comission_received',
		'agent_comission_remain_amount',
		'agent_comission_remain_now',
		'create_user_id',
		'update_user_id',
		'create_time',
		'update_time',
	),
));
