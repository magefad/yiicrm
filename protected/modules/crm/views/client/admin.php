<?php

/**
 * @var $this Controller
 * @var $model Client
 */
/*$this->breadcrumbs = array(
	Yii::t('CrmModule.client', 'Clients') => array('admin'),
	Yii::t('CrmModule.client', 'Manage'),
);*/
#$client = Client::model()->findByPk(4717);
#echo $client->name_contact;
Yii::app()->clientScript->registerScript('scroll', '$("html, body").animate({scrollTop: $("#client-grid").position().top-62}, "slow");', CClientScript::POS_READY);
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
table.items tr td {
    word-wrap: break-word;
}
table.items tr td div.compact {
    width: 70px;
    max-height: 25px;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}
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
        //'responsiveTable'       => true,
        'fixedHeader'           => true,
        'filter'                => $model,
        'ajaxUrl'               => $this->createUrl('client/admin', array('id' => $model->project_id)),
        'afterAjaxUpdate'       => 'reinstallDatePicker',
        'template'              => '{items}{pager}{summary}',
        'htmlOptions'           => array('style' => 'font-size: 83%;'),
        'columns'               => array(
            /*array(
                'name'        => 'id',
                'htmlOptions' => array('style' => 'width:20px'),
            ),*/
            //'project_id',
            array(
                'name'        => 'client_id',
                'header'      => 'ID',
                //'htmlOptions' => array('style' => 'width: 36px'),
                //'headerHtmlOptions' => array('style' => 'width: 36px'),
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
                //'htmlOptions' => array('style' => 'width: 150px;')
            ),
            array(
                'name' => 'name_contact',
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url' => $this->createUrl('updateEditable'),
                ),
                //'htmlOptions' => array('style' => 'width: 95px;')
            ),
            //'time_zone',
            array(
                'name'  => 'phone',
                'value' => '$data->phone . ($data->time_zone ? " (+" . $data->time_zone . " " . Yii::t("CrmModule.client", "hour") . ")" : "")',
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url' => $this->createUrl('updateEditable'),
                ),
                //'htmlOptions' => array('style' => 'width: 84px;')
            ),
            array(
                'name' => 'email',
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url' => $this->createUrl('updateEditable'),
                ),
                //'htmlOptions' => array('style' => 'max-width: 104px; word-wrap: break-word;')
            ),
            //'site',
            array(
                'name'     => 'city',
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url' => $this->createUrl('updateEditable'),
                ),
                //'htmlOptions' => array('style' => 'width: 118px;')
            ),
            /*'address',
            'driver',
            'product',*/
            array(
                'name'  => 'client_request',
                'class' => 'PopoverColumn',
                'header' => 'Запрос',
                #'class' => 'bootstrap.widgets.TbEditableColumn',
                #'value' => '$data->client_request',
                'editable' => array(
                    'url'       => $this->createUrl('updateEditable'),
                    'placement' => 'left',
                    'options'   => array(
                        'showbuttons' => true,
                    )
                ),
                //'htmlOptions' => array('style' => 'width: 70px')
            ),
            //'link_type',
            /*array(
                'name'  => 'sponsor',
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url'  => $this->createUrl('updateEditable'),
                    'type' => 'text',
                ),
                'htmlOptions' => array('style' => 'width: 60px'),
            ),*/
            array(
                'name'  => 'status',
                'header' => 'C',
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'value' => '$data->status',
                'editable' => array(
                    'url'       => $this->createUrl('updateEditable'),
                    'type'      => 'select',
                    'source'    => $model->statusMain->getList()
                ),
                //'htmlOptions' => array('style' => 'width: 35px')
            ),
            array(
                'name'                 => 'cp',
                'class'                => 'bootstrap.widgets.TbToggleColumn',
                'checkedIcon'          => 'icon-ok',
                'uncheckedIcon'        => 'icon-remove',
                'checkedButtonLabel'   => Yii::t('CrmModule.client', 'Выставлено'),
                'uncheckedButtonLabel' => Yii::t('CrmModule.client', 'Отказано'),
                'visible'              => in_array($model->project_id, array(4, 6, 9)),
                //'htmlOptions'          => array('style' => 'width: 10px')
            ),
            /*'comment_history',
            'comment_fail',
            'contract_copy',
            'comment_review',
            'photo',
            'description_production',*/
            array(
                'name'  => 'createUserSearch',
                'header' => 'M',
                'value' => '$data->createUser->username',
                //'htmlOptions' => array('style' => 'width: 35px')
            ),
            /*'update_user_id',
            array(
                'name' => 'create_time',
                'value' => 'Yii::app()->getDateFormatter()->formatDateTime($data->create_time, "short", null)',
            ),*/
            array(
                'header' => 'Последний',
                'name'  => 'update_time',
                'value' => 'Yii::app()->getDateFormatter()->formatDateTime($data->update_time, "short", null)',
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url'       => $this->createUrl('updateEditable'),
                    'type'      => 'date',
                    'placement' => 'left',
                    'viewformat' => 'dd.mm.yy',
                    'options' => array('clear' => '', 'showbuttons' => true, 'datepicker' => array('autoclose' => false)),
                ),
                //'htmlOptions' => array('style' => 'width: 50px'),
                'filter'      => $this->widget(
                    'bootstrap.widgets.TbDateRangePicker',
                    array(
                        'model'     => $model,
                        'attribute' => 'update_time',
                        'options'   => Client::$rangeOptions,
                        'htmlOptions' => array('id' => 'datepicker_for_update_time'),
                    ), true
                ),
            ),
            array(
                'header' => 'Следующий',
                'name'             => 'next_time',
                'value'            => 'Yii::app()->getDateFormatter()->formatDateTime($data->next_time, "short", null)',
                'class'            => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url'       => $this->createUrl('updateEditable'),
                    'type'      => 'date',
                    'placement' => 'left',
                    'viewformat' => 'dd.mm.yy',
                    'options' => array('showbuttons' => true, 'datepicker' => array('autoclose' => false)),
                ),
                //'htmlOptions' => array('style' => 'width: 50px'),
                'filter'      => $this->widget(
                    'bootstrap.widgets.TbDateRangePicker',
                    array(
                        'model'     => $model,
                        'attribute' => 'next_time',
                        'options'   => Client::$rangeOptions,
                        'htmlOptions' => array('id' => 'datepicker_for_next_time'),
                    ), true
                ),
            ),
            array(
                'name'  => 'comment_history',
                'class' => 'PopoverColumn',
                #'class' => 'bootstrap.widgets.TbEditableColumn',
                #'value' => '$data->client_request',
                'editable' => array(
                    'url'       => $this->createUrl('updateEditable'),
                    'placement' => 'left',
                    'options'   => array(
                        'showbuttons' => true,
                    )
                ),
                //'htmlOptions' => array('style' => 'width: 70px')
            ),
            //'next_time',
            array(
                'class'       => 'bootstrap.widgets.TbButtonColumn',
                'template' => '{update} {delete}',
                //'htmlOptions' => array('style' => 'width: 60px')
            ),
        ),
    )
);
$daysOfWeek = Yii::app()->locale->getWeekDayNames('narrow', true);
array_push($daysOfWeek, $daysOfWeek[0]);
array_shift($daysOfWeek);
Yii::app()->clientScript->registerScript(
    're-install-date-picker',
    "var options = " . CJavaScript::encode(
        CMap::mergeArray(
            Client::$rangeOptions,
            array(
                'locale' => array(
                    'daysOfWeek' => Yii::app()->locale->getWeekDayNames('narrow', true),
                    'monthNames' => array_values(Yii::app()->locale->getMonthNames('wide', true)),
                    'firstDay' => 0,
                )
            )
        )
    ) . ";function reinstallDatePicker(id, data) {jQuery('#datepicker_for_next_time').daterangepicker(options);jQuery('#datepicker_for_update_time').daterangepicker(options);}"
);
?>
