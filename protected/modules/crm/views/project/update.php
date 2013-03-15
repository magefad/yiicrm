<?php

/**
 * @var $this Controller
 * @var $model Project
 */
$this->breadcrumbs = array(
	Yii::t('CrmModule.project', 'Projects') => array('admin'),
	$model->name => array('view', 'id' => $model->id),
	Yii::t('zii', 'Update'),
);
echo $this->renderPartial('_form', array('model' => $model));