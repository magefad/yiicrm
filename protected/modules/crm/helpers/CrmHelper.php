<?php
/**
 * CrmHelper.php class file.
 * 
 * @author Ruslan Fadeev <fadeevr@gmail.com>
 * @link http://yiifad.ru/
 * @copyright 2012-2013 Ruslan Fadeev
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

class CrmHelper
{
    /**
     * @param array $skip
     * @return array items for TbMenu etc.
     */
    public static function projectItems($skip = array())
    {
        $projects = self::projects();
        $items = array();
        foreach ($projects as $data) {
            if (!in_array($data['id'], $skip)) {
                $items[] = array(
                    'label' => $data['name'],
                    'url'   => array('/crm/' . Yii::app()->getController()->getId() . '/admin', 'id' => $data['id']),
                );
            }
        }
        return $items;
    }

    public static function projects()
    {
        if (!$projects = Yii::app()->getCache()->get('project')) {
            $projects = Yii::app()->db->createCommand()->select('id, name')->from('{{project}}')->queryAll();
            Yii::app()->getCache()->set('project', $projects);
        }
        return $projects;
    }

    public static function partners()
    {
        if (!$partners = Yii::app()->getCache()->get('project_partner')) {
            $partners = Yii::app()->db->createCommand()->select('id, name')->from('{{project_partner}}')->queryAll();
            Yii::app()->getCache()->set('project_partner', $partners);
        }
        return $partners;
    }
}