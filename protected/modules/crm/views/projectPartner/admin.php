<?php

/**
 * @var $this Controller
 * @var $model ProjectPartner
 */
$this->breadcrumbs = array(
	Yii::t('CrmModule.projectPartner', 'Project Partners') => array('admin'),
	Yii::t('CrmModule.projectPartner', 'Manage'),
);
$this->widget(
    'CrmGridView',
    array(
        'id'                    => 'project-partner-grid',
        'dataProvider'          => $model->search(),
        'filter'                => $model,
        'rowCssClassExpression' => '',
        'columns'               => array(
            array(
                'name'        => 'id',
                'htmlOptions' => array('style' => 'width:20px'),
            ),
            //'project_id',
            array('name' => 'projectSearch', 'value' => '$data->project->name'),
            'name',
            'name_short',
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
            ),
        ),
    )
);
