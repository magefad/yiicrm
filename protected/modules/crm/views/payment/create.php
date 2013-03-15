<?php

/**
 * @var $this Controller
 * @var $model Payment
 */
$this->breadcrumbs = array(
	Yii::t('CrmModule.payment', 'Payments') => array('admin'),
	Yii::t('CrmModule.payment', 'Create'),
);

echo $this->renderPartial('_form', array('model' => $model));
