<?php

/**
 * @var $this Controller
 * @var $model Payment
 */
$this->breadcrumbs = array(
	Yii::t('CrmModule.payment', 'Payments') => array('admin'),
	$model->id => array('view', 'id' => $model->id),
	Yii::t('zii', 'Update'),
);

echo $this->renderPartial('_form', array('model' => $model));