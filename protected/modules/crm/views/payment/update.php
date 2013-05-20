<?php

/**
 * @var $this Controller
 * @var $payment Payment
 * @var $paymentMoney PaymentMoney
 */
$this->breadcrumbs = array(
	Yii::t('CrmModule.payment', 'Payments') => array('admin'),
	$payment->id => array('view', 'id' => $payment->id),
	Yii::t('zii', 'Update'),
);

echo $this->renderPartial('_form', array('payment' => $payment, 'paymentMoney' => $paymentMoney));