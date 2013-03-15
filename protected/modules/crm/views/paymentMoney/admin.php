<?php

/**
 * @var $this Controller
 * @var $model PaymentMoney
 */
$this->breadcrumbs = array(
	Yii::t('CrmModule.paymentMoney', 'Payment Moneys') => array('admin'),
	Yii::t('CrmModule.paymentMoney', 'Manage'),
);

Yii::app()->clientScript->registerScript(
    'search',
    "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('payment-money-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>
<?php echo CHtml::link(Yii::t('CrmModule.paymentMoney', 'Search'), '#', array('class' => 'search-button btn btn-small')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array('model' => $model)); ?>
</div><!-- search-form -->

<?php $this->widget('CrmGridView', array(
    'id'           => 'payment-money-grid',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        array(
            'name'        => 'id',
            'htmlOptions' => array('style' => 'width:20px'),
        ),
		'type',
		'payment_id',
		'date',
		'amount',
		'create_user_id',
		/*
		'update_user_id',
		'create_time',
		'update_time',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
