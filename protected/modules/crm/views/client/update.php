<?php

/**
 * @var $this Controller
 * @var $client Client
 * @var $orders ClientOrder[]
 */
$this->breadcrumbs = array(
	Yii::t('CrmModule.client', 'Clients') => array('admin'),
    $client->cache(3600)->project->name => array('admin', 'id' => $client->project_id),
    $client->client_id . ' ' . Yii::t('zii', 'Update'),
);
$this->menu[1]['url']['id'] = $client->project_id;
echo $this->renderPartial('_form', array('client' => $client, 'orders' => $orders, 'order' => isset($order) ? $order : new ClientOrder()));