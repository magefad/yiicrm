<?php

/**
 * @var $this Controller
 * @var $model Client
 */
$this->breadcrumbs = array(
	Yii::t('CrmModule.client', 'Clients') => array('admin'),
    $model->project->name => array('admin', 'id' => $model->project_id),
	$model->client_id => array('view', 'id' => $model->client_id),
	Yii::t('zii', 'Update'),
);

echo $this->renderPartial('_form', array('model' => $model));