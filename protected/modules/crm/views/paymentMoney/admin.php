<?php

/**
 * @var $this Controller
 * @var $model PaymentMoney
 */
$this->breadcrumbs = array(
	Yii::t('CrmModule.paymentMoney', 'Payment Moneys') => array('admin'),
	Yii::t('CrmModule.paymentMoney', 'Manage'),
);
$this->widget('CrmGridView', array(
    'id'           => 'payment-money-grid',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        array(
            'name'        => 'id',
            'htmlOptions' => array('style' => 'width:20px'),
        ),
		'type',
		'payment_id',
		'date',
		'amount',
		'create_user_id',
		/*
		'update_user_id',
		'create_time',
		'update_time',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
));
