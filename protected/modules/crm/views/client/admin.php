<?php

/**
 * @var $this Controller
 * @var $model Client
 */
$this->breadcrumbs = array(
	Yii::t('CrmModule.client', 'Clients') => array('admin'),
	Yii::t('CrmModule.client', 'Manage'),
);

Yii::app()->clientScript->registerScript(
    'search',
    "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('client-grid', {
        data: $(this).serialize()
    });
    return false;
});
");

Yii::app()->clientScript->registerCss('all', '
td a.editable {
    color: #333333;
    border-bottom: none;
}
table.items a.sort-link {
    font-size: 80%;
}
table.items tr td div.compact {
    width: 70px;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    /*-webkit-transition: all .3s ease .3s;
       -moz-transition: all .3s ease .3s;
         -o-transition: all .3s ease .3s;
            transition: all .3s ease .3s;*/
}
/*table.items tr div.compact:hover {
    max-height: 999px;
}*/
');
?>
<?php echo CHtml::link(Yii::t('CrmModule.client', 'Search'), '#', array('class' => 'search-button btn btn-small pull-right')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array('model' => $model)); ?>
</div><!-- search-form -->

<?php
if (!$items = Yii::app()->getCache()->get('projectItems')) {
    $projects = Yii::app()->db->createCommand()->select('id, name')->from('{{project}}')->queryAll();
    foreach ($projects as $data) {
        $items[] = array(
            'label' => $data['name'],
            'url'   => array('/crm/client/admin', 'id' => $data['id']),
        );
    }
    Yii::app()->getCache()->set('projectItems', $items);
}
$this->widget(
    'bootstrap.widgets.TbMenu',
    array(
        'type'        => 'tabs',
        'items'       => $items,
        'htmlOptions' => array('style' => 'font-size: 80%')
    )
);
$this->widget(
    'CrmGridView',
    array(
        'id'                    => 'client-grid',
        'dataProvider'          => $model->search(),
        //'fixedHeader' => true,
        'filter'                => $model,
        'template'              => '{items}{pager}{summary}',
        'htmlOptions'           => array('style' => 'font-size: 90%;'),
        'columns'               => array(
            /*array(
                'name'        => 'id',
                'htmlOptions' => array('style' => 'width:20px'),
            ),*/
            //'project_id',
            array(
                'name'        => 'client_id',
                'htmlOptions' => array('style' => 'width:20px'),
            ),
            array(
                'name'    => 'projectSearch',
                'value'   => '$data->project->name',
                'visible' => $model->project_id == null,
                //'htmlOptions' => array('style' => 'width: 75px')
            ),
            array(
                'name'  => 'name_company',
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url' => $this->createUrl('updateEditable'),
                ),
            ),
            array(
                'name' => 'name_contact',
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url' => $this->createUrl('updateEditable'),
                ),
            ),
            //'time_zone',
            array(
                'name'  => 'phone',
                'value' => '$data->phone . ($data->time_zone ? " (+" . $data->time_zone . " " . Yii::t("CrmModule.client", "hour") . ")" : "")',
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url' => $this->createUrl('updateEditable'),
                ),
            ),
            array(
                'name' => 'email',
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url' => $this->createUrl('updateEditable'),
                ),
            ),
            //'site',
            array(
                'name'     => 'city',
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url' => $this->createUrl('updateEditable'),
                ),
            ),
            /*'address',
            'driver',
            'product',*/
            array(
                'name'  => 'client_request',
                'class' => 'PopoverColumn',
                #'class' => 'bootstrap.widgets.TbEditableColumn',
                #'value' => '$data->client_request',
                'editable' => array(
                    'url'       => $this->createUrl('updateEditable'),
                    'placement' => 'left',
                    'options'   => array(
                        'showbuttons' => true,
                    )
                )
            ),
            //'link_type',
            array(
                'name'  => 'sponsor',
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url'  => $this->createUrl('updateEditable'),
                    'type' => 'text',
                ),
                'htmlOptions' => array('style' => 'width: 60px'),
            ),
            array(
                'name'  => 'status',
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'value' => '$data->status',
                'editable' => array(
                    'url'       => $this->createUrl('updateEditable'),
                    'type'      => 'select',
                    'source'    => $model->statusMain->getList()
                ),
                'htmlOptions' => array('style' => 'width: 60px'),
            ),
            /*'cp',
            'comment_history',
            'comment_fail',
            'contract_copy',
            'comment_review',
            'photo',
            'description_production',*/
            array(
                'name'  => 'createUserSearch',
                'value' => '$data->createUser->username'
            ),
            /*'update_user_id',
            array(
                'name' => 'create_time',
                'value' => 'Yii::app()->getDateFormatter()->formatDateTime($data->create_time, "short", null)',
            ),*/
            array(
                'name'  => 'update_time',
                'value' => 'Yii::app()->getDateFormatter()->formatDateTime($data->update_time, "short", null)',
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url'       => $this->createUrl('updateEditable'),
                    'type'      => 'date',
                    'placement' => 'left',
                    'viewformat' => 'dd.mm.yy',
                ),

                'htmlOptions' => array('style' => 'width: 50px')
            ),
            array(
                'name'             => 'next_time',
                'value'            => 'Yii::app()->getDateFormatter()->formatDateTime($data->update_time, "short", null)',
                'class'            => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url'       => $this->createUrl('updateEditable'),
                    'type'      => 'date',
                    'placement' => 'left',
                    'viewformat' => 'dd.mm.yy',
                ),
                'htmlOptions'      => array('style' => 'width: 50px')
            ),
            array(
                'class'       => 'bootstrap.widgets.TbButtonColumn',
                'htmlOptions' => array('style' => 'width: 60px')
            ),
        ),
    )
); ?>
