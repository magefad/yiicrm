<?php

/**
 * @var $this Controller
 * @var $model PaymentMoney
 */
$this->breadcrumbs = array(
	Yii::t('CrmModule.paymentMoney', 'Payment Moneys') => array('admin'),
	Yii::t('CrmModule.paymentMoney', 'Create'),
);

echo $this->renderPartial('_form', array('model' => $model));
