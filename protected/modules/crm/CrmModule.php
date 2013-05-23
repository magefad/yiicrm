<?php

class CrmModule extends WebModule
{
    /**
     * @var string DefaultPage
     */
    public $defaultPage = 'index';

    public static function getAdminLink()
    {
        return array('icon' => self::getIcon(), 'label' => self::getName(), 'url' => array('/crm'));
    }

    public static function getName()
    {
        return Yii::t('CrmModule.main', 'CRM');
    }

    public static function getDescription()
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
            $controller->menu = $this->getAdminMenu();
            if ($action->id == 'admin') {
                Yii::app()->widgetFactory->widgets['TbEditableField']['url'] = $controller->createUrl('updateEditable');
                $this->setImport(array('crm.helpers.CrmHelper', 'crm.components.*'));
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return array items for TbNavbar
     */
    public function getAdminMenu()
    {
        /*$controllerId = Yii::app()->getController()->getId();
        if ($controllerId == 'payment') {
            return false;
        }
        $menu = array(
            array('icon'  => 'list-alt',
                  'label' => Yii::t('admin', 'Список'),
                  'url' => array(
                      '/' . $this->id . '/' . $controllerId . '/admin',
                  )
            ),
            array(
                'icon' => 'file',
                'label' => Yii::t('admin', 'Добавить'),
                'url' => array(
                    '/' . $this->id . '/' . $controllerId . '/create',
                    'id' => in_array($controllerId, array('client', 'payment')) ? @intval($_GET['id']) : 0
                )
            )
        );
        if (isset(Yii::app()->getController()->actionParams['id']) && $controllerId == 'default') {
            $menu[] = array(
                'icon'  => 'pencil',
                'label' => Yii::t('zii', 'Update'),
                'url'   => array(
                    '/' . $this->id . '/' . $controllerId . '/update',
                    'id' => Yii::app()->getController()->actionParams['id']
                )
            );
            $menu[] = array(
                'icon'        => 'remove',
                'label'       => Yii::t('zii', 'Delete'),
                'url'         => '#',
                'linkOptions' => array(
                    'submit'  => array('/' . $this->id . '/' . $controllerId . '/delete', 'id' => Yii::app()->getController()->actionParams['id']),
                    'confirm' => Yii::t('zii', 'Are you sure you want to delete this item?')
                )
            );
        } else if (!empty($this->settingData)) {
            $menu[] = array(
                'icon'  => 'wrench',
                'label' => Yii::t('admin', 'Настройки'),
                'url'   => array('/admin/setting/update/' . $this->id . '/')
            );
        }
        return $menu;*/
        return null;
    }
}
