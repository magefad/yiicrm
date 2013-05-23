<!DOCTYPE html>
<html lang="<?php echo Yii::app()->getLanguage(); ?>">
<head>
    <meta charset="utf-8">
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
<?php
/** @var $this Controller */
$id = in_array($this->getId(), array('client', 'payment')) ? @intval($_GET['id']) : 0;
$this->widget(
    'bootstrap.widgets.TbNavbar',
    array(
        'type'        => 'inverse',
        'fixed'       => false,
        'brand'       => CHtml::encode(Yii::app()->name),
        'brandUrl'    => '/',
        'items'       => array(
            array(
                'class' => 'bootstrap.widgets.TbMenu',
                'items' => array(
                    array(
                        'icon'  => 'headphones',
                        'label' => 'Позвонить',
                        'url'   => '/crm/client/admin/?Client[next_time]=' . date(
                            'Y-m-d'
                        ) . '&Client_page=1'
                    ),
                    array(
                        'icon'    => 'briefcase',
                        'label'   => 'Оплаты',
                        'url'     => array('/crm/payment/admin', 'id' => $id),
                        'visible' => $this->getId() != 'payment'
                    ),
                    array(
                        'icon'    => 'user',
                        'label'   => 'Клиентская база',
                        'url'     => array('/crm/client/admin', 'id' => $id),
                        'visible' => $this->getId() != 'client'
                    ),
                    array(
                        'icon'    => 'file',
                        'label'   => Yii::t('admin', 'Добавить клиента'),
                        'url'     => array('/crm/client/create', 'id' => $id),
                        'visible' => Yii::app()->user->checkAccess('Admin') || Yii::app()->user->checkAccess('Editor')
                    )
                )
            ),
            array(
                'class'       => 'bootstrap.widgets.TbMenu',
                'htmlOptions' => array('class' => 'pull-right'),
                'items'       => array(
                    array(
                        'label'   => 'Управление',
                        'visible' => Yii::app()->user->checkAccess('Admin'),
                        'items'   => array(
                            array('label' => 'Права доступа', 'url' => array('/auth')),
                            array('label' => 'Пользователи', 'url' => array('/user/default/admin')),
                            array('label' => 'Очистить кэши', 'url' => array('/crm/client/flush'))
                        )
                    ),
                    array(
                        'label'   => 'Войти',
                        'url'     => array('/user/account/login'),
                        'visible' => Yii::app()->user->isGuest
                    ),
                    array(
                        'label'       => 'Выйти',
                        'url'         => array('/user/account/logout'),
                        'visible'     => !Yii::app()->user->isGuest,
                        'htmlOptions' => array('class' => 'btn')
                    ),
                )
            )
        )
    )
);
?>
<div class="container-fluid">
<?php if (isset($this->breadcrumbs)) {
    $this->widget(
        'bootstrap.widgets.TbBreadcrumbs',
        array(
            'links'     => $this->breadcrumbs,
            'separator' => ' / ',
            'homeLink'  => CHtml::link('Главная', Yii::app()->getHomeUrl()),
        )
    );
}
$this->widget('bootstrap.widgets.TbAlert');
echo $content;
?>
</div>
<footer class="footer">
    <div class="container">
<?php #$this->widget('ext.performance.widgets.statistic');?>
    </div>
</footer>
</body>
</html>
