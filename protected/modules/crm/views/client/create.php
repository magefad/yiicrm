<?php

/**
 * @var $this Controller
 * @var $model Client
 */
$this->breadcrumbs = array(
	Yii::t('CrmModule.client', 'Clients') => array('admin'),
	Yii::t('CrmModule.client', 'Create'),
);

echo $this->renderPartial('_form', array('model' => $model));
