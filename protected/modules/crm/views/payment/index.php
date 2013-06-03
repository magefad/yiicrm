<?php
/**
 * @var $this Controller
 * @var $model Payment
 */
$this->widget(
    'bootstrap.widgets.TbTabs',
    array(
        'type'  => 'tabs',
        'tabs' => array_merge(
            CrmHelper::projectItems(array(1, 14, 15), true),
            array(array('label' => Yii::t('CrmModule.Payment', 'Расчеты'), 'url' => array('paymentMoney/admin')))
        ),
        'id'    => 'projects-tab',
        'htmlOptions' => array('style' => 'font-size: 90%')
    )
);
$this->widget(
    'CrmGridView',
    array(
        'id'                    => 'payment-grid',
        'dataProvider'          => $model->search(),
        'filter'                => $model,
        'ajaxUrl'               => $this->createUrl('payment/index', array('id' => $model->projectId)),
        'rowCssClassExpression' => '!$data->agent_comission_remain_amount ? "opacity" : ""',
        'columns'               => array(
            array(
                'name'     => 'paymentMoneyPartner.date',
                'header'   => Yii::t('CrmModule.paymentMoney', 'Date') . ' ' . Yii::t('CrmModule.payment', 'Partner'),
                'filter'   => CHtml::activeTextField($model, 'partnerDate'),
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url'        => $this->createUrl('paymentMoney/updateEditable'),
                    'type'       => 'date',
                    'placement'  => 'left',
                    'viewformat' => 'dd.mm.yy'
                ),
            ),
            array(
                'name'        => 'client_id',
                'value'       => 'isset($data->client) ? CHtml::link($data->client->client_id, array("client/update", "id" => $data->client_id), array("target" => "_blank")) : ""',
                'type'        => 'raw',
                'htmlOptions' => array('style' => 'width: 25px'),
            ),
            array(
                'name'  => 'name_company',
                'class' => 'bootstrap.widgets.TbEditableColumn',
            ),
            array(
                'name'  => 'name_contact',
                'class' => 'TbEditableColumn',
            ),
            array(
                'name'     => 'comments',
                'class'    => 'TbEditableColumn',
                'htmlOptions' => array('style' => 'width: 30px; text-align:center'),
                'editable' => array(
                    'type'      => 'textarea',
                    'placement' => 'left',
                    'options'   => array(
                        'showbuttons' => true,
                        //'display'     => 'js: function() {$(this).html("<i class=\"icon-list-alt\">_</i>");}',
                        //'autotext'    => 'always'
                    )
                ),
            ),
            array(
                'name'     => 'paymentMoneyPartner.method',
                'header'   => Yii::t('CrmModule.paymentMoney', 'Payment Method'),
                'filter'   => CHtml::activeDropDownList($model, 'partnerMethod', PaymentMoney::model()->statusMethod->getList(), array('empty' => '')),
            ),
            array(
                'name'     => 'payment_amount',
                'class'    => 'TbEditableColumn',
                'editable' => array('options' => array('inputclass' => 'input-small')),
            ),
            array(
                'name'        => 'payment',
                'htmlOptions' => array('style' => 'background-color: WhiteSmoke;')
            ),
            array(
                'name'     => 'agent_comission_amount',
                'class'    => 'TbEditableColumn',
                'editable' => array('options' => array('inputclass' => 'input-small')),
                'htmlOptions' => array('style' => 'background-color: WhiteSmoke')
            ),
            array(
                'name'        => 'agent_comission_received',
                'htmlOptions' => array('style' => 'background-color: WhiteSmoke')
            ),
            /*'error',
            'create_user_id',
            'update_user_id',
            'create_time',
            'update_time',*/
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'template' => '{update} {delete}'
            ),
        ),
    )
);
