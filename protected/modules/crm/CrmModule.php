<?php

class CrmModule extends CWebModule
{
    /**
     * @var string DefaultPage
     */
    public $defaultPage = 'index';

    public function getName()
    {
        return Yii::t('CrmModule.main', 'CRM');
    }

    public function getDescription()
    {
        return Yii::t('CrmModule.main', 'Customer relationship management');
    }

	public function init()
	{
		$this->setImport(array('crm.models.*'));
	}

    /**
     * @param Controller $controller
     * @param CAction $action
     * @return bool
     */
    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action)) {
            if (in_array($action->getId(), array('admin', 'index', 'calculations'))) {
                Yii::app()->widgetFactory->widgets['TbEditableField']['url'] = $controller->createUrl('updateEditable');
                $this->setImport(array('crm.helpers.CrmHelper', 'crm.components.CrmGridView'));
            }
            return true;
        } else {
            return false;
        }
    }
}
