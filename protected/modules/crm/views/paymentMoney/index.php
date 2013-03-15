<?php
$this->breadcrumbs = array(
    Yii::t('CrmModule.paymentMoney', 'Payment Moneys') => array('admin'),
);

?>

<h1>Payment Moneys</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
    'dataProvider' => $dataProvider,
    'itemView'     => '_view',
)); ?>
