<?php
/* @var $this Controller */

$this->breadcrumbs = array($this->module->getName());
?>
<h1><?php echo $this->module->getDescription() ?></h1>
<?php
$this->widget(
    'bootstrap.widgets.TbMenu',
    array(
        'type'        => 'list',
        'htmlOptions' => array('class' => 'well span3', 'style' => 'float: none; margin: 0 auto;'),
        'items'       => array(
            array('label' => Yii::t('CrmModule.main', 'Manage'), 'itemOptions' => array('class' => 'nav-header')),
            array('label' => Yii::t('zii', 'Home'), 'url' => '#', 'itemOptions' => array('class' => 'active')),
            array('label' => Yii::t('CrmModule.main', 'Client Base'), 'url' => '/crm/client'),
            array('label' => Yii::t('CrmModule.main', 'Payment'), 'url' => '/crm/payment'),
            array('label' => Yii::t('CrmModule.main', 'Payment Money'), 'url' => '/crm/paymentMoney'),
            array('label' => Yii::t('CrmModule.main', 'Project'), 'url' => '/crm/project'),
            array('label' => Yii::t('CrmModule.main', 'Project Partner'), 'url' => '/crm/projectPartner'),
        )
    )
);
?>
