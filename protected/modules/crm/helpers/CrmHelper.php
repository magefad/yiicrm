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
     * @param boolean $withPartners
     * @return array items for TbMenu etc.
     */
    public static function projectItems($skip = array(), $withPartners = false)
    {
        $projects = self::projects();
        $items = array();
        foreach ($projects as $data) {
            if (!in_array($data['id'], $skip)) {
                if ($withPartners) {
                    $itemsPartners = self::partnerItems($data['id'], array(), !in_array($data['id'], array(11, 14, 15)));
                    $items[] = array(
                        'label' => $data['name'],
                        'active' => isset($itemsPartners[@$_GET['id']]) && $data['id'] == @$_GET['project_id'] ? true : false,
                        'items' => $itemsPartners,
                    );
                } else {
                    $items[] = array(
                        'label' => $data['name'],
                        'url'   => array('/crm/' . Yii::app()->getController()->getId() . '/' . Yii::app()->getController()->getAction()->getId(), 'id' => $data['id']),
                    );
                }
            }
        }
        return $items;
    }

    public static function partnerItems($project = 0, $skip = array(), $typeMainOnly = false)
    {
        $partners = self::partners($project);
        $items = array();
        foreach ($partners as $data) {
            if (!in_array($data['id'], $skip)) {
                if ($typeMainOnly && $data['type'] != Partner::TYPE_MAIN) {
                    continue;
                }
                $items[$data['id']] = array(
                    'label' => $data['name'],
                    'url'   => array(
                        '/crm/' . Yii::app()->getController()->getId() . '/' . Yii::app()->getController()->getAction(
                        )->getId(),
                        'id'         => $data['id'],
                        'project_id' => $data['type'] == Partner::TYPE_MAIN ? true : false ? $project : ''
                    ),
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

    public static function partners($projectId = 0)
    {
        if (!$partners = Yii::app()->getCache()->get('project_partner' . $projectId)) {
            $command = Yii::app()->db->createCommand()->select('id, name, type')->from('{{partner}} p')->leftJoin('{{partner_project}} pp', 'pp.partner_id=p.id');
            if ($projectId) {
                $command->where('pp.project_id=:project_id', array(':project_id' => $projectId));
            }
            Yii::app()->getCache()->set('project_partner' . $projectId, $partners = $command->queryAll());
        }
        return $partners;
    }
}
