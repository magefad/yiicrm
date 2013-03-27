<?php

/**
 * @var $this Controller
 * @var $client Client
 * @var $order ClientOrder
 */
$this->breadcrumbs = array(
	Yii::t('CrmModule.client', 'Clients') => array('admin'),
	Yii::t('CrmModule.client', 'Create'),
);
echo $this->renderPartial('_form', array('client' => $client, 'order' => $order));
