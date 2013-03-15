<?php

/**
 * @var $this Controller
 * @var $model PaymentMoney
 */
$this->breadcrumbs = array(
	Yii::t('CrmModule.paymentMoney', 'Payment Moneys') => array('admin'),
	$model->id => array('view', 'id' => $model->id),
	Yii::t('zii', 'Update'),
);

echo $this->renderPartial('_form', array('model' => $model));