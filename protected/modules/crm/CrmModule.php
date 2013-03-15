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
		// import the module-level models and components
		$this->setImport(array(
			'crm.models.*',
			'crm.components.*',
		));
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
        $menu = array(
            array('icon'  => 'list-alt',
                  'label' => Yii::t('admin', 'Список'),
                  'url' => array(
                      '/' . $this->id . '/' . Yii::app()->controller->id . '/admin',
                  )
            ),
            array(
                'icon' => 'file',
                'label' => Yii::t('admin', 'Добавить'),
                'url' => array(
                    '/' . $this->id . '/' . Yii::app()->controller->id . '/create',
                    'id' => Yii::app()->controller->id == 'client' ? @intval($_GET['id']) : 0
                )
            )
        );
        if (isset(Yii::app()->controller->actionParams['id']) && Yii::app()->controller->id == 'default') {
            $menu[] = array(
                'icon'  => 'pencil',
                'label' => Yii::t('zii', 'Update'),
                'url'   => array(
                    '/' . $this->id . '/' . Yii::app()->controller->id . '/update',
                    'id' => Yii::app()->controller->actionParams['id']
                )
            );
            $menu[] = array(
                'icon'        => 'remove',
                'label'       => Yii::t('zii', 'Delete'),
                'url'         => '#',
                'linkOptions' => array(
                    'submit'  => array('/' . $this->id . '/' . Yii::app()->controller->id . '/delete', 'id' => Yii::app()->controller->actionParams['id']),
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
        return $menu;
    }
}
