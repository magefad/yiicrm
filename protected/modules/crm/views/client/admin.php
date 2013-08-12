<?php

/**
 * @var $this Controller
 * @var $model Client
 */
$userSource = CHtml::listData(User::model()->cache(10800)->active()->findAll(), 'id', 'username');
$this->widget(
    'bootstrap.widgets.TbMenu',
    array(
        'type'  => 'tabs',
        'items' => CrmHelper::projectItems(array(1, 11, 14, 15)),
        'id'    => 'projects-tab'
    )
);
$this->widget(
    'CrmGridView',
    array(
        'id'                    => 'client-grid',
        'dataProvider'          => $model->search(),
        'filter'                => $model,
        'ajaxUrl'               => $this->createUrl('client/admin', array('id' => $model->project_id)),
        'afterAjaxUpdate'       => 'reinstallFilter',
        'rowCssClassExpression' => '!$data->status ? "error" : ($data->status == 2 ? "success" : ($data->status == 4 ? "" : ($data->status == 6 ? "warning" : "")))',
        'columns'               => array(
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
                'name'     => 'name_company',
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array('type' => 'textarea', 'placement' => 'right', 'options' => array('showbuttons' => true))
            ),
            array(
                'name'     => 'name_contact',
                'class'    => 'TbEditableColumn',
                'editable' => array('type' => 'textarea', 'placement' => 'right', 'options' => array('showbuttons' => true))
            ),
            array(
                'name'     => 'phone',
                'value'    => '$data->phone . ($data->time_zone ? " (+" . $data->time_zone . " " . Yii::t("CrmModule.client", "hour") . ")" : "")',
                'class'    => 'TbEditableColumn',
                'htmlOptions' => array('style' => 'width: 95px'),
                'editable' => array('type' => 'textarea', 'placement' => 'right', 'options' => array('showbuttons' => true))
            ),
            array(
                'name'     => 'email',
                'class'    => 'TbEditableColumn',
                'htmlOptions' => array('style' => 'width: 130px'),
                'editable' => array('type' => 'textarea', 'placement' => 'right', 'options' => array('showbuttons' => true))
            ),
            array(
                'name'   => 'city',
                'class'  => 'TbEditableColumn',
                'htmlOptions' => array('style' => 'width: 120px'),
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
            ),
            array(
                'name'     => 'lastOrder.client_request',
                'header'   => Yii::t('CrmModule.client', 'Запрос'),
                'filter'   => CHtml::activeTextField($model, 'client_request'),
                'class'    => 'TbEditableColumn',
                'htmlOptions' => array('style' => 'width: 30px; text-align:center'),
                'editable' => array(
                    'url'       => $this->createUrl('clientOrder/updateEditable'),
                    'placement' => 'left',
                    'options' => array(
                        'showbuttons' => true,
                        'display'     => 'js: function() {$(this).html("<i class=\"icon-list-alt\">_</i>");}',
                        'autotext'    => 'always'
                    ),
                ),
            ),
            array(
                'name'     => 'lastOrder.comment_history',
                'header'   => Yii::t('CrmModule.client', 'История'),
                'filter'   => CHtml::activeTextField($model, 'comment_history'),
                'class'    => 'TbEditableColumn',
                'htmlOptions' => array('style' => 'width: 40px; text-align:center'),
                'editable' => array(
                    'url'       => $this->createUrl('clientOrder/updateEditable'),
                    'placement' => 'left',
                    'options' => array(
                        'showbuttons' => true,
                        'inputclass'  => 'input-xxlarge',
                        'rows'        => 10,
                        'display'     => 'js: function() {$(this).html("<i class=\"icon-list-alt\">_</i>");}',
                        'autotext'    => 'always'
                    )
                ),
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
                'editable'          => array('type' => 'select', 'source' => $model->statusMain->getList()),
                'filter'            => $model->statusMain->getList(),
                'htmlOptions'       => array('style' => 'width: 20px'),
                'filterHtmlOptions' => array('class' => 'mini' . ($model->status ? ' selected' : ''))
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
                    1 => Yii::t('yii', 'Yes'),
                    0 => Yii::t('yii', 'No')
                ),
                'filterHtmlOptions'    => array('class' => 'mini'),
                'htmlOptions'          => array('style' => 'width: 10px'),
            ),
            array(
                'name'              => 'lastOrder.create_user_id',
                'class'             => 'TbEditableColumn',
                'editable' => array(
                    'url'    => $this->createUrl('clientOrder/updateEditable'),
                    'type'   => 'select',
                    'source' => CHtml::listData(User::model()->cache(10800)->active()->findAll(), 'id', 'username')
                ),
                'header'            => 'M',
                'filter'            => CHtml::activeDropDownList($model, 'order_user_id', $userSource, array('empty' => Yii::t('zii', 'Not set'))),
                'filterHtmlOptions' => array('class' => 'mini' . ($model->order_user_id ? ' selected' : '')),
                'htmlOptions'       => array('style' => 'width: 35px')
            ),
            array(
                'header'   =>  Yii::t('CrmModule.client', 'Последний'),
                'name'     => 'update_time',
                'class'    => 'TbEditableColumn',
                'htmlOptions' => array('style' => 'width: 50px'),
                'editable' => array(
                    'type'       => 'date',
                    'placement'  => 'left',
                    'viewformat' => 'dd.mm.yy',
                    'options'    => array('clear' => ''),
                ),
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
                'htmlOptions' => array('style' => 'width: 55px'),
                'editable' => array('type' => 'date', 'placement'  => 'left', 'viewformat' => 'dd.mm.yy'),
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
            array(
                'class'           => 'application.components.behaviors.EButtonColumnWithClearFilters',
                'label'           => Yii::t('CrmModule.client', 'Сбросить фильтры'),
                'template'        => '{update} {payment} {delete}',
                'updateButtonUrl' => $model->project_id != null ? '$this->grid->controller->createUrl("update",array("id"=>$data->primaryKey))' : 'Yii::app()->controller->createUrl("update",array("id"=>$data->primaryKey, "call"=>1))',
                'buttons'         => array(
                    'payment' => array(
                        'icon'    => 'briefcase',
                        'label'   => Yii::t('CrmModule.client', 'Order'),
                        'url'     => '$this->grid->controller->createUrl("payment/create", array("id" => $data->project_id, "client_id" => $data->id))',
                        'options' => array('target' => '_blank')
                    )
                )
            ),
        ),
    )
);
$js = <<<JS
setupGridView();function setupGridView(a){null==a&&(a=".grid-view tr.filters");$("input,select",a).change(function(){var a=$(this).closest(".grid-view");$(document).data(a.attr("id")+"-lastFocused",this.name)})}function refocusFilter(a){a=$("#"+a);var b=$(document).data(a.attr("id")+"-lastFocused");null!=b&&(fe=$('[name="'+b+'"]',a),null!=fe&&("INPUT"==fe.get(0).tagName&&"text"==fe.attr("type")?fe.cursorEnd():fe.focus()),setupGridView(a))}
jQuery.fn.cursorEnd=function(){return this.each(function(){if(this.setSelectionRange)this.focus(),this.setSelectionRange(this.value.length,this.value.length);else if(this.createTextRange){var a=this.createTextRange();a.collapse(!0);a.moveEnd("character",this.value.length);a.moveStart("character",this.value.length);a.select()}return!1})};
JS;

Yii::app()->getClientScript()->registerScript(
    'reinstallFilter',
    $js .
    "var options = " . CJavaScript::encode(
        CMap::mergeArray(
            Client::$rangeOptions,
            array(
                'locale' => array(
                    'daysOfWeek' => Yii::app()->getLocale()->getWeekDayNames('narrow', true),
                    'monthNames' => array_values(Yii::app()->getLocale()->getMonthNames('wide', true)),
                    'firstDay'   => 0,
                )
            )
        )
    ) . ";function reinstallFilter() {jQuery('html, body').animate({scrollTop: $('#client-grid').position().top+2}, 'fast');jQuery('#datepicker_for_next_time').daterangepicker(options);jQuery('#datepicker_for_update_time').daterangepicker(options);jQuery('#typeahead_for_city').typeahead({'source':function(query, process) {return $.getJSON('/crm/client/autoCompleteSearch', { table: 'client', nameField: 'city', term: query }, function(data) {return process(data);})},'minLength':2});}"
);
