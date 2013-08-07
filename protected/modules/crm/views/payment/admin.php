<?php
/**
 * @var $this Controller
 * @var $model Payment
 */
$this->widget(
    'bootstrap.widgets.TbMenu',
    array(
        'type'  => 'tabs',
        'items' => CrmHelper::projectItems(array(1, 14, 15)),
        'id'    => 'projects-tab'
    )
);
$this->widget(
    'CrmGridView',
    array(
        'id'                    => 'payment-grid',
        'dataProvider'          => $model->search(),
        'filter'                => $model,
        'ajaxUrl'               => $this->createUrl('payment/admin', array('id' => $model->projectId)),
        'rowCssClassExpression' => '!$data->agent_comission_remain_amount ? "opacity" : ""',
        'columns'               => array(
            array(
                'name'        => 'client_id',
                'value'       => 'isset($data->client) ? CHtml::link($data->client->client_id, array("client/update", "id" => $data->client_id), array("target" => "_blank")) : ""',
                'type'        => 'raw',
                'htmlOptions' => array('style' => 'width: 25px'),
            ),
            array(
                'name'        => 'order_id',
                'value'       => '$data->order_id ? "<span rel=\"tooltip\" title=\"" . $data->clientOrder->create_time . "\">" . $data->clientOrder->number . "</span>"  : " - "',
                'type'        => 'raw',
                'htmlOptions' => array('style' => 'width: 20px'),
            ),
            array(
                'name'    => 'client.project.name',
                'header'  => Yii::t('CrmModule.payment', 'Project'),
                'visible' => $model->projectId == null,
            ),
            array(
                'name'   => 'partner.name',
                'header' => Yii::t('CrmModule.payment', 'Partner'),
                'filter' => CHtml::activeDropDownList($model, 'partner_id', CHtml::listData(CrmHelper::partners($model->projectId), 'id', 'name'), array('empty' => '')),
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
                'name'     => 'client.city',
                'class'    => 'TbEditableColumn',
                'filter'   => CHtml::activeTextField($model, 'clientCity'),
                'editable' => array('url' => $this->createUrl('client/updateEditable')),
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
                        'display'     => 'js: function() {$(this).html("<i class=\"icon-list-alt\">_</i>");}',
                        'autotext'    => 'always'
                    )
                ),
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
                'name'        => 'payment_remain',
                'htmlOptions' => array('style' => 'background-color: WhiteSmoke')
            ),
            'agent_comission_percent',
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
            'agent_comission_remain_amount',
            array(
                'name'        => 'agent_comission_remain_now',
                'htmlOptions' => array('style' => 'background-color: WhiteSmoke')
            ),
            array(
                'name'     => 'paymentMoneyPartner.date',
                'header'   => Yii::t('CrmModule.paymentMoney', 'Date') . ' ' . Yii::t('CrmModule.payment', 'Partner'),
                'filter'   => CHtml::activeTextField($model, 'partnerDate'),
                'class'    => 'TbEditableColumn',
                'editable' => array(
                    'url'        => $this->createUrl('paymentMoney/updateEditable'),
                    'type'       => 'date',
                    'placement'  => 'left',
                    'viewformat' => 'dd.mm.yy'
                ),
                'htmlOptions' => array('style' => 'border-left-color: #B5B5B5')
            ),
            array(
                'name'     => 'paymentMoneyPartner.amount',
                'header'   => Yii::t('CrmModule.paymentMoney', 'Payment Moneys') . ' ' . Yii::t('CrmModule.payment', 'Partner'),
                'filter'   => CHtml::activeTextField($model, 'partnerAmount'),
                'class'    => 'TbEditableColumn',
                'editable' => array('url' => $this->createUrl('paymentMoney/updateEditable')),
            ),
            array(
                'name'     => 'paymentMoneyAgent.date',
                'header'   => Yii::t('CrmModule.paymentMoney', 'Date') . ' ' . Yii::t('CrmModule.payment', 'Reward'),
                'filter'   => CHtml::activeTextField($model, 'agentDate'),
                'class'    => 'TbEditableColumn',
                'editable' => array(
                    'url'        => $this->createUrl('paymentMoney/updateEditable'),
                    'type'       => 'date',
                    'placement'  => 'left',
                    'viewformat' => 'dd.mm.yy'
                ),
            ),
            array(
                'name'     => 'paymentMoneyAgent.amount',
                'header'   => Yii::t('CrmModule.paymentMoney', 'Payment Moneys') . ' ' . Yii::t('CrmModule.payment', 'Reward'),
                'filter'   => CHtml::activeTextField($model, 'agentAmount'),
                'class'    => 'TbEditableColumn',
                'editable' => array('url' => $this->createUrl('paymentMoney/updateEditable')),
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
