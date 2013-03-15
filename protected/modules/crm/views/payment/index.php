<?php
$this->breadcrumbs = array(
    Yii::t('CrmModule.payment', 'Payments') => array('admin'),
);

?>

<h1>Payments</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
    'dataProvider' => $dataProvider,
    'itemView'     => '_view',
)); ?>
