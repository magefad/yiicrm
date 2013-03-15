<?php

/**
 * @var $this Controller
 * @var $model ProjectPartner
 */
$this->breadcrumbs = array(
	Yii::t('CrmModule.projectPartner', 'Project Partners') => array('admin'),
	Yii::t('CrmModule.projectPartner', 'Create'),
);

echo $this->renderPartial('_form', array('model' => $model));
