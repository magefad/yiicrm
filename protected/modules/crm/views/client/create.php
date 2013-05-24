<?php

/**
 * @var $this Controller
 * @var $client Client
 * @var $order ClientOrder
 */
$this->breadcrumbs = array(
	Yii::t('CrmModule.client', 'Clients') => array('admin'),
    isset($_GET['id'])
        ? Project::model()->cache(108000)->findByPk(intval($_GET['id']))->name
        : Yii::t('CrmModule.client', 'Project') . ' ' . Yii::t('zii', 'Not set'),
	Yii::t('CrmModule.client', 'Create'),
);
echo $this->renderPartial('_form', array('client' => $client, 'order' => $order));
