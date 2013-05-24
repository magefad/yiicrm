<?php

/**
 * @var $this Controller
 * @var $payment Payment
 * @var $paymentMoney PaymentMoney
 */
$this->breadcrumbs = array(
	Yii::t('CrmModule.payment', 'Payments') => array('admin'),
    isset($_GET['id']) && $_GET['id']
        ? Project::model()->cache(108000)->findByPk(intval($_GET['id']))->name
        : Yii::t('CrmModule.client', 'Project') . ' ' . Yii::t('zii', 'Not set'),
	Yii::t('CrmModule.payment', 'Create'),
);

echo $this->renderPartial('_form', array('payment' => $payment, 'paymentMoney' => isset($paymentMoney) ? $paymentMoney : new PaymentMoney));
