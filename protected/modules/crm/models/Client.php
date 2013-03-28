<?php

/**
 * This is the model class for table "{{client}}".
 *
 * The followings are the available columns in table '{{client}}':
 * @property integer $id
 * @property integer $project_id
 * @property integer $client_id
 * @property string $name_company
 * @property string $name_contact
 * @property string $time_zone
 * @property string $phone
 * @property string $email
 * @property string $site
 * @property string $city
 * @property string $address
 * @property integer $status
 * @property boolean $cp
 * @property integer $create_user_id
 * @property integer $update_user_id
 * @property string $create_time
 * @property string $update_time
 * @property string $next_time
 *
 * The followings are the available model relations:
 * @property User $updateUser
 * @property Project $project
 * @property User $createUser
 * @property Payment[] $payments
 * @property ClientOrder[] $orders
 * @property ClientOrder $lastOrder
 */
class Client extends CActiveRecord
{
    public $projectSearch;
    public $createUserSearch;
    public $updateUserSearch;

    public $client_request;
    public $comment_history;

    public static $rangeOptions = array(
        'ranges' => array(
            'Вчера'            => array('yesterday', 'yesterday'),
            'Сегодня'          => array('today', 'today'),
            'Завтра'           => array('tomorrow', 'tomorrow'),
            'Следующая неделя' => array('today', 'js:Date.today().add({ days: +7 })'),
            'Последние 3 дня'  => array('js:Date.today().add({ days: -3 })', 'today'),
            'Последняя неделя' => array('js:Date.today().add({ days: -6 })', 'today'),
            'Последний месяц'  => array('js:Date.today().add({ days: -31 })', 'today'),
        ),
        'format' => 'yyyy-MM-dd',
        'opens'  => 'left',
        'locale' => array(
            'applyLabel'       => 'Выбрать',
            'clearLabel'       => '<i class="icon icon-remove"></i>',
            'fromLabel'        => 'От',
            'toLabel'          => 'До',
            'customRangeLabel' => 'Выбрать период',
            'firstDay'         => 1
        ),
    );

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Client the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{client}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name_contact, city', 'required'),
            array('client_id, project_id, status, create_user_id', 'numerical', 'integerOnly' => true),
            array('name_company, name_contact, phone, email, site, city, address', 'length', 'max' => 255),
            array('time_zone', 'length', 'max' => 2),
            array('cp', 'boolean'),
            array('update_time, next_time', 'type', 'type' => 'datetime', 'datetimeFormat' => 'yyyy-MM-dd hh:mm:ss'),
            array('cp, update_time, next_time', 'default', 'value' => null, 'setOnEmpty' => true),
            // The following rule is used by search().
            array('id, project_id, client_id, name_company, name_contact, time_zone, phone, email, site, city, address, status, cp, create_user_id, update_user_id, create_time, update_time, next_time, projectSearch, createUserSearch, updateUserSearch, client_request, comment_history', 'safe', 'on' => 'search'),
        );
    }

    /**
     * Returns a list of behaviors that this model should behave as.
     * @return array the behavior configurations (behavior name=>behavior configuration)
     */
    public function behaviors()
    {
        return array(
            'SaveBehavior' => array(
                'class'           => 'application.components.behaviors.SaveBehavior',
                'updateAttribute' => null
            ),
            'statusMain'   => array(
                'class' => 'application.components.behaviors.StatusBehavior',
                'list'  => array(
                    0 => Yii::t('CrmModule.client', '0. Отказ'),
                    1 => Yii::t('CrmModule.client', '1. Рабочий клиент'),
                    2 => '2',
                    3 => '3',
                    4 => Yii::t('CrmModule.client', '4. Сделка выполнена'),
                    5 => '5',
                    6 => Yii::t('CrmModule.client', '6. Дилер'),
                )
            ),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'updateUser' => array(self::BELONGS_TO, 'User', 'update_user_id'),
            'project'    => array(self::BELONGS_TO, 'Project', 'project_id'),
            'payments'   => array(self::HAS_MANY, 'Payment', 'client_id'),
            'orders'     => array(self::HAS_MANY, 'ClientOrder', 'client_id', 'order' => 'orders.id DESC'),
            'lastOrder'  => array(self::HAS_ONE, 'ClientOrder', 'client_id', 'order' => 'lastOrder.id DESC'),
            'createUser' => array(self::HAS_ONE, 'User', array('create_user_id' => 'id'), 'through' => 'lastOrder'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'                     => Yii::t('CrmModule.client', 'ID'),
            'project_id'             => Yii::t('CrmModule.client', 'Project'),
            'client_id'              => Yii::t('CrmModule.client', 'Client'),
            'name_company'           => Yii::t('CrmModule.client', 'Name Company'),
            'name_contact'           => Yii::t('CrmModule.client', 'Name Contact'),
            'time_zone'              => Yii::t('CrmModule.client', 'TZ'),
            'phone'                  => Yii::t('CrmModule.client', 'Phone'),
            'email'                  => Yii::t('CrmModule.client', 'Email'),
            'site'                   => Yii::t('CrmModule.client', 'Site'),
            'city'                   => Yii::t('CrmModule.client', 'City'),
            'address'                => Yii::t('CrmModule.client', 'Address'),
            'status'                 => Yii::t('CrmModule.client', 'Status'),
            'cp'                     => Yii::t('CrmModule.client', 'Cp'),
            'create_user_id'         => Yii::t('CrmModule.client', 'Create User'),
            'update_user_id'         => Yii::t('CrmModule.client', 'Update User'),
            'create_time'            => Yii::t('CrmModule.client', 'Create Time'),
            'update_time'            => Yii::t('CrmModule.client', 'Update Time'),
            'next_time'              => Yii::t('CrmModule.client', 'Next Time'),
            'projectSearch'          => Yii::t('CrmModule.client', 'Project'),
            'createUserSearch'       => Yii::t('CrmModule.client', 'Manager')
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria       = new CDbCriteria;
        $criteria->with = array(
            'lastOrder',
            'createUser' => array('select' => 'username')
        );
        if ($this->project_id) {
            $criteria->with[] = array('project' => array('select' => 'name'));
        }
        $criteria->compare('t.id', $this->id);
        $criteria->compare('project_id', $this->project_id);
        $criteria->compare('client_id', $this->client_id);
        $criteria->compare('name_company', $this->name_company, true);
        $criteria->compare('name_contact', $this->name_contact, true);
        $criteria->compare('time_zone', $this->time_zone, true);
        $criteria->compare('t.phone', $this->phone, true);
        $criteria->compare('t.email', $this->email, true);
        $criteria->compare('site', $this->site, true);
        $criteria->compare('t.city', $this->city, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('cp', $this->cp, true);
        //$criteria->compare('create_user_id', $this->create_user_id);
        //$criteria->compare('update_user_id', $this->update_user_id);
        $criteria->compare('t.create_time', $this->create_time, false);
        if (strlen($this->update_time) > 10) {
            $this->update_time = trim($this->update_time);
            $from              = substr($this->update_time, 0, 10);
            $to                = date('Y-m-d', strtotime('+1 day', strtotime(substr($this->update_time, -10))));
            if ($from != substr($this->update_time, -10)) {
                $criteria->addBetweenCondition('t.update_time', $from, $to);
            } else {
                $criteria->compare('t.update_time', $from, true);
            }
        } else {
            $criteria->compare('t.update_time', $this->update_time, true);
        }

        if (strlen($this->next_time) > 10) {
            $this->next_time = trim($this->next_time);
            $from            = substr($this->next_time, 0, 10);
            $to              = date('Y-m-d', strtotime('+1 day', strtotime(substr($this->next_time, -10))));
            if ($from != substr($this->next_time, -10)) {
                $criteria->addBetweenCondition('t.next_time', $from, $to);
            } else {
                $criteria->compare('t.next_time', $from, true);
            }
        } else {
            $criteria->compare('t.next_time', $this->next_time, true);
        }
        $criteria->compare('project.name', $this->projectSearch, true);
        $criteria->compare('createUser.id', $this->createUserSearch, true);
        $criteria->compare('updateUser.id', $this->updateUserSearch, true);

        $criteria->compare('lastOrder.client_request', $this->client_request, true);
        $criteria->compare('lastOrder.comment_history', $this->comment_history, true);

        return new CActiveDataProvider($this, array(
            'criteria'   => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
            'sort'       => array(
                'defaultOrder' => array('client_id' => true),
                'attributes'   => array(
                    'projectSearch'             => array(
                        'asc'  => 'project.name',
                        'desc' => 'project.name DESC',
                    ),
                    'lastOrder.client_request'  => array(
                        'asc'  => 'lastOrder.client_request',
                        'desc' => 'lastOrder.client_request DESC'
                    ),
                    'lastOrder.comment_history' => array(
                        'asc'  => 'lastOrder.comment_history',
                        'desc' => 'lastOrder.comment_history DESC'
                    ),
                    'createUser.username' => array(
                        'asc'  => 'createUser.username',
                        'desc' => 'createUser.username DESC'
                    ),
                    '*'
                )
            )
        ));
    }

    protected function beforeValidate()
    {
        if ($nextTime = CDateTimeParser::parse($this->next_time, 'yyyy-MM-dd', array('hour' => date('H'), 'minute'))) {
            $this->next_time = date('Y-m-d H:i:s', $nextTime);
        }
        if ($updateTime = CDateTimeParser::parse($this->update_time, 'yyyy-MM-dd', array('hour' => date('H'), 'minute'))) {
            $this->update_time = date('Y-m-d H:i:s', $updateTime);
        }
        return parent::beforeValidate();
    }

    protected function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->client_id = (int)Yii::app()->db->createCommand()->select(new CDbExpression('MAX(client_id)'))->from('{{client}}')->where(
                'project_id = :project_id',
                array(':project_id' => $this->project_id)
            )->queryScalar() + 1;
        }
        return parent::beforeSave();
    }

    public function getList($attribute)
    {
        if (!$list = Yii::app()->getCache()->get(__CLASS__ . 'getList_' . $attribute)) {
            $command = Yii::app()->db->createCommand()->select($attribute)->from(self::tableName());
            if ($this->project_id) {
                $command->where('project_id = :project_id', array(':project_id' => $this->project_id));
            }
            $command->setGroup($attribute);
            $rows = $command->queryAll();
            $list = array();
            foreach ($rows as $i => $data) {
                $list[$data[$attribute]] = $data[$attribute];
            }
            Yii::app()->getCache()->set(__CLASS__ . 'getList_' . $attribute, $list, 3600);
        }
        return $list;
    }
}