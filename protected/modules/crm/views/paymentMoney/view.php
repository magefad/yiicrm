<?php

/**
 * @var $this Controller
 * @var $model PaymentMoney
 */
$this->breadcrumbs = array(
	Yii::t('CrmModule.paymentMoney', 'Payment Moneys') => array('admin'),
	$model->id,
);

$this->widget('bootstrap.widgets.TbDetailView', array(
	'data'       => $model,
	'attributes' => array(
		'id',
		'type',
		'payment_id',
		'date',
		'amount',
		'create_user_id',
		'update_user_id',
		'create_time',
		'update_time',
	),
));
