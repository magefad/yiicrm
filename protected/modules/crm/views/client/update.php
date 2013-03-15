<?php

/**
 * @var $this Controller
 * @var $model Client
 */
$this->breadcrumbs = array(
	Yii::t('CrmModule.client', 'Clients') => array('admin'),
	$model->id => array('view', 'id' => $model->client_id),
	Yii::t('zii', 'Update'),
);

echo $this->renderPartial('_form', array('model' => $model));