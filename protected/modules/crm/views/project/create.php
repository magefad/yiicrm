<?php

/**
 * @var $this Controller
 * @var $model Project
 */
$this->breadcrumbs = array(
	Yii::t('CrmModule.project', 'Projects') => array('admin'),
	Yii::t('CrmModule.project', 'Create'),
);

echo $this->renderPartial('_form', array('model' => $model));
