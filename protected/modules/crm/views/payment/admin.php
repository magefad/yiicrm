<?php

/**
 * @var $this Controller
 * @var $model Payment
 */
$this->breadcrumbs = array(
	Yii::t('CrmModule.payment', 'Payments') => array('admin'),
	Yii::t('CrmModule.payment', 'Manage'),
);

Yii::app()->clientScript->registerScript(
    'search',
    "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('payment-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>
<?php echo CHtml::link(Yii::t('CrmModule.payment', 'Search'), '#', array('class' => 'search-button btn btn-small')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array('model' => $model)); ?>
</div><!-- search-form -->

<?php $this->widget('CrmGridView', array(
    'id'           => 'payment-grid',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        array(
            'name'        => 'id',
            'htmlOptions' => array('style' => 'width:20px'),
        ),
		'__ID',
		'client_id',
		'partner_id',
		'name_company',
		'name_contact',
		/*
		'city',
		'comments',
		'payment_amount',
		'payment',
		'payment_remain',
		'calculation_percent',
		'agent_comission_percent',
		'agent_comission_amount',
		'agent_comission_received',
		'agent_comission_remain_amount',
		'agent_comission_remain_now',
		'error',
		'create_user_id',
		'update_user_id',
		'create_time',
		'update_time',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
