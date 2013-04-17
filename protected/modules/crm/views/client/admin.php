<?php

/**
 * @var $this Controller
 * @var $model Client
 */
Yii::app()->clientScript->registerScript('scroll', '$("html, body").animate({scrollTop: $("#client-grid").position().top-40}, "fast");', CClientScript::POS_READY);
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
table.items {
    min-width: 1200px;
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
.filter-container select {
    padding: 0;
    width: 19px !important;
}

');
?>
<!--<?php echo CHtml::link(Yii::t('CrmModule.client', 'Search'), '#', array('class' => 'search-button btn btn-small pull-right')); ?>
<div class="search-form" style="display:none">
    <?php //$this->renderPartial('_search', array('model' => $model)); ?>
</div>
-->
<?php
if (!$items = Yii::app()->getCache()->get('projectItems')) {
    $projects = Yii::app()->db->createCommand()->select('id, name')->from('{{project}}')->queryAll();
    foreach ($projects as $data) {
        if (!in_array($data['id'], array(14, 15))) {
            $items[] = array(
                'label' => $data['name'],
                'url'   => array('/crm/client/admin', 'id' => $data['id']),
            );
        }
    }
    Yii::app()->getCache()->set('projectItems', $items);
}
$this->widget(
    'bootstrap.widgets.TbMenu',
    array(
        'type'        => 'tabs',
        'items'       => $items,
        'htmlOptions' => array('style' => 'font-size: 80%; margin-bottom: 0;')
    )
);
$this->widget(
    'CrmGridView',
    array(
        'id'              => 'client-grid',
        'dataProvider'    => $model->search(),
        'fixedHeader'     => true,
        'filter'          => $model,
        'ajaxUrl'         => $this->createUrl('client/admin', array('id' => $model->project_id)),
        'afterAjaxUpdate' => 'reinstallFilter',
        'template'        => '{pager}{items}{pager}{summary}',
        'htmlOptions'     => array('style' => 'font-size: 83%; padding-top: 1px;'),
        'columns'         => array(
            array(
                'name'        => 'client_id',
                'header'      => 'ID',
                'htmlOptions' => array('style' => 'width: 25px'),
            ),
            array(
                'name'    => 'projectSearch',
                'value'   => '$data->project->name',
                'visible' => $model->project_id == null,
            ),
            array(
                'name'  => 'name_company',
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array('type' => 'textarea', 'placement' => 'right', 'options' => array('showbuttons' => true))
            ),
            array(
                'name'  => 'name_contact',
                'class' => 'TbEditableColumn',
                'editable' => array('type' => 'textarea', 'placement' => 'right', 'options' => array('showbuttons' => true))
            ),
            //'time_zone',
            array(
                'name'  => 'phone',
                'value' => '$data->phone . ($data->time_zone ? " (+" . $data->time_zone . " " . Yii::t("CrmModule.client", "hour") . ")" : "")',
                'class' => 'TbEditableColumn',
                'editable' => array('type' => 'textarea', 'placement' => 'right', 'options' => array('showbuttons' => true))
            ),
            array(
                'name'  => 'email',
                'class' => 'TbEditableColumn',
                'editable' => array('type' => 'textarea', 'placement' => 'right', 'options' => array('showbuttons' => true))
            ),
            //'site',
            array(
                'name'   => 'city',
                'class'  => 'TbEditableColumn',
                'filter' => $this->widget(
                    'bootstrap.widgets.TbTypeahead',
                    array(
                        'model'       => $model,
                        'attribute'   => 'city',
                        'options'     => array(
                            'source'    => 'js:function(query, process) {
    return $.getJSON("/crm/client/autoCompleteSearch", { table: "client", nameField: "city", term: query }, function(data) {
       return process(data);
    })
}',
                            'minLength' => 2,
                        ),
                        'htmlOptions' => array('id' => 'typeahead_for_city'),
                    ),
                    true
                ),
                //'htmlOptions' => array('style' => 'width: 118px;')
            ),
            /*'address',
            'driver',
            'product',*/
            array(
                'name'     => 'lastOrder.client_request',
                'header'   => Yii::t('CrmModule.client', 'Запрос'),
                'filter'   => CHtml::activeTextField($model, 'client_request'),
                'class'    => 'PopoverColumn',
                'editable' => array(
                    'url'       => $this->createUrl('clientOrder/updateEditable'),
                    'placement' => 'left',
                    'options'   => array(
                        'showbuttons' => true,
                    )
                ),
            ),
            array(
                'name'     => 'lastOrder.comment_history',
                'header'   => Yii::t('CrmModule.client', 'История'),
                'filter'   => CHtml::activeTextField($model, 'comment_history'),
                'class'    => 'PopoverColumn',
                'editable' => array(
                    'url'       => $this->createUrl('clientOrder/updateEditable'),
                    'placement' => 'left',
                    'options'   => array(
                        'showbuttons' => true,
                        'inputclass' => 'input-xlarge',
                        'rows' => 10
                    )
                ),
                //'htmlOptions' => array('style' => 'width: 70px')
            ),
            //'link_type',
            /*array(
                'name'  => 'sponsor',
                'class' => 'TbEditableColumn',
                'editable' => array(
                    'url'  => $this->createUrl('updateEditable'),
                    'type' => 'text',
                ),
                'htmlOptions' => array('style' => 'width: 60px'),
            ),*/
            array(
                'name'              => 'status',
                'header'            => 'C',
                'class'             => 'TbEditableColumn',
                'value'             => '$data->status',
                'editable'          => array(
                    'type'   => 'select',
                    'source' => $model->statusMain->getList()
                ),
                'filter'            => $model->statusMain->getList(),
                'htmlOptions'       => array('style' => 'width: 20px'),
                'filterHtmlOptions' => array('style' => 'padding-right: 0')
            ),
            array(
                'name'                 => 'cp',
                'class'                => 'bootstrap.widgets.TbToggleColumn',
                'checkedIcon'          => 'icon-ok',
                'uncheckedIcon'        => 'icon-remove',
                'checkedButtonLabel'   => Yii::t('CrmModule.client', 'Выставлено'),
                'uncheckedButtonLabel' => Yii::t('CrmModule.client', 'Отказано'),
                'visible'              => in_array($model->project_id, array(4, 6, 9)),
                'filter'               => array(
                    1 => Yii::t('CrmModule.client', 'Есть'),
                    0 => Yii::t('CrmModule.client', 'Нет')
                ),
                'filterHtmlOptions'    => array('style' => 'padding-right: 0'),
                'htmlOptions'          => array('style' => 'width: 10px'),
            ),
            array(
                'name'              => 'createUser.username',
                'header'            => 'M',
                'filter'            => CHtml::activeDropDownList($model, 'createUserSearch', CHtml::listData(User::model()->cache(10800)->findAll(), 'id', 'username'), array('empty' => Yii::t('zii', 'Not set'))),
                'filterHtmlOptions' => array('style' => 'padding-right: 0'),
                'htmlOptions'       => array('style' => 'width: 35px')
            ),
            /*
            array(
                'name' => 'create_time',
                'value' => 'Yii::app()->getDateFormatter()->formatDateTime($data->create_time, "short", null)',
            ),*/
            array(
                'header'   =>  Yii::t('CrmModule.client', 'Последний'),
                'name'     => 'update_time',
                'class'    => 'TbEditableColumn',
                'editable' => array(
                    'type'       => 'date',
                    'placement'  => 'left',
                    'viewformat' => 'dd.mm.yy',
                    'options'    => array('clear' => ''),
                ),
                //'htmlOptions' => array('style' => 'width: 50px'),
                'filter'   => $this->widget(
                    'bootstrap.widgets.TbDateRangePicker',
                    array(
                        'model'       => $model,
                        'attribute'   => 'update_time',
                        'options'     => Client::$rangeOptions,
                        'htmlOptions' => array('id' => 'datepicker_for_update_time'),
                    ),
                    true
                ),
            ),
            array(
                'header'   => Yii::t('CrmModule.client', 'Следующий'),
                'name'     => 'next_time',
                'class'    => 'TbEditableColumn',
                'editable' => array(
                    'type'       => 'date',
                    'placement'  => 'left',
                    'viewformat' => 'dd.mm.yy',
                ),
                //'htmlOptions' => array('style' => 'width: 50px'),
                'filter'   => $this->widget(
                    'bootstrap.widgets.TbDateRangePicker',
                    array(
                        'model'       => $model,
                        'attribute'   => 'next_time',
                        'options'     => Client::$rangeOptions,
                        'htmlOptions' => array('id' => 'datepicker_for_next_time'),
                    ),
                    true
                ),
            ),
            //'next_time',
            array(
                'class'    => 'application.components.behaviors.EButtonColumnWithClearFilters',
                'label'    => Yii::t('CrmModule.client', 'Сбросить фильтры'),
                'template' => '{update} {delete}',
                //'htmlOptions' => array('style' => 'width: 60px')
            ),
        ),
    )
);
Yii::app()->clientScript->registerScript(
    'reinstallFilter',
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
    ) . ";function reinstallFilter() {jQuery('html, body').animate({scrollTop: $('#client-grid').position().top+2}, 'fast');jQuery('#datepicker_for_next_time').daterangepicker(options);jQuery('#datepicker_for_update_time').daterangepicker(options);jQuery('#typeahead_for_city').typeahead({'source':function(query, process) {return $.getJSON('/crm/client/autoCompleteSearch', { table: 'client', nameField: 'city', term: query }, function(data) {return process(data);})},'minLength':2});}"
);
?>
