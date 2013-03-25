<?php
$this->breadcrumbs = array(
    Yii::t('CrmModule.client', 'Clients') => array('admin'),
);
$this->widget('bootstrap.widgets.TbListView',array(
    'dataProvider' => $dataProvider,
    'itemView'     => '_view',
));
