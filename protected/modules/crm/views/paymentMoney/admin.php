<?php
/**
 * @var $this Controller
 * @var $model PaymentMoney
 */
$this->widget(
    'bootstrap.widgets.TbTabs',
    array(
        'type' => 'tabs',
        'tabs' => array_merge(
            CrmHelper::projectItems(array(1, 14, 15), true),
            array(array('label' => Yii::t('CrmModule.Payment', 'Расчеты'), 'url' => array('calculations')))
        ),
        'id'   => 'projects-tab'
    )
);
$this->widget(
    'bootstrap.widgets.TbGroupGridView',
    array(
        'id'              => 'payment-money-grid',
        'type'            => 'striped condensed bordered',
        'dataProvider'    => $model->search(),
        'afterAjaxUpdate' => 'reinstallFilter',
        'filter'          => $model,
        'mergeColumns'    => array('payment.client.id', 'amount', 'date'),
        'columns'         => array(
            //'type',
            //'payment_id',
            'payment.client.id',
            'payment.client.name_company',
            array(
                'name'   => 'payment.client.name_contact',

            ),
            array(
                'name' => 'payment.comments',
                'footer' => CHtml::tag(
                    'strong',
                    array('class' => 'pull-right'),
                    Yii::t('CrmModule.paymentMoney', 'Amount')
                ),
            ),
            array(
                'name'  => 'amount',
                'class' => 'bootstrap.widgets.TbTotalSumColumn',
            ),
            array(
                'name'   => 'date',
                'filter' => $this->widget(
                    'bootstrap.widgets.TbDateRangePicker',
                    array(
                        'model'       => $model,
                        'attribute'   => 'date',
                        'options'     => Client::$rangeOptions,
                        'htmlOptions' => array('id' => 'datepicker_for_update_time'),
                    ),
                    true
                ),
            ),
            /*'create_user_id',
            'update_user_id',
            'create_time',
            'update_time',
            */
            /*array(
                'class'=>'bootstrap.widgets.TbButtonColumn',
            ),*/
        ),
    )
);
Yii::app()->getClientScript()->registerScript(
    'reinstallFilter',
    $js . "var options = " . CJavaScript::encode(
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
    ) . ";function reinstallFilter() {jQuery('html, body').animate({scrollTop: $('#payment-money-grid').position().top+2}, 'fast');jQuery('#datepicker_for_next_time').daterangepicker(options);jQuery('#datepicker_for_update_time').daterangepicker(options);jQuery('#typeahead_for_city').typeahead({'source':function(query, process) {return $.getJSON('/crm/client/autoCompleteSearch', { table: 'client', nameField: 'city', term: query }, function(data) {return process(data);})},'minLength':2});}"
);
