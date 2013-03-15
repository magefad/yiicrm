<?php

/**
 * @var $this Controller
 * @var $model ProjectPartner
 */
$this->breadcrumbs = array(
	Yii::t('CrmModule.projectPartner', 'Project Partners') => array('admin'),
	$model->name => array('view', 'id' => $model->id),
	Yii::t('zii', 'Update'),
);
echo $this->renderPartial('_form', array('model' => $model));