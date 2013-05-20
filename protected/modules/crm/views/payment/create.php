<?php

/**
 * @var $this Controller
 * @var $payment Payment
 * @var $paymentMoney PaymentMoney
 */
$this->breadcrumbs = array(
	Yii::t('CrmModule.payment', 'Payments') => array('admin'),
	Yii::t('CrmModule.payment', 'Create'),
);

echo $this->renderPartial('_form', array('payment' => $payment, 'paymentMoney' => isset($paymentMoney) ? $paymentMoney : new PaymentMoney));
