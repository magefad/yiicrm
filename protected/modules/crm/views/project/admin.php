<?php

/**
 * @var $this Controller
 * @var $model Project
 */
$this->breadcrumbs = array(
	Yii::t('CrmModule.project', 'Projects') => array('admin'),
	Yii::t('CrmModule.project', 'Manage'),
);
$this->widget(
    'CrmGridView',
    array(
        'id'                    => 'project-grid',
        'dataProvider'          => $model->search(),
        'filter'                => $model,
        'rowCssClassExpression' => '',
        'columns'               => array(
            array(
                'name'        => 'id',
                'htmlOptions' => array('style' => 'width:20px'),
            ),
            'name',
            'name_short',
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
            ),
        ),
    )
);
