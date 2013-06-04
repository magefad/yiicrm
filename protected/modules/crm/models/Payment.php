<?php

/**
 * This is the model class for table "{{payment}}".
 *
 * The followings are the available columns in table '{{payment}}':
 * @property integer $id
 * @property integer $client_id
 * @property integer $partner_id
 * @property string $name_company
 * @property string $name_contact
 * @property string $comments
 * @property integer $payment_amount
 * @property integer $payment
 * @property integer $payment_remain
 * @property string $agent_comission_percent
 * @property integer $agent_comission_amount
 * @property integer $agent_comission_received
 * @property integer $agent_comission_remain_amount
 * @property integer $agent_comission_remain_now
 * @property integer $create_user_id
 * @property integer $update_user_id
 * @property string $create_time
 * @property string $update_time
 *
 * The followings are the available model relations:
 * @property Client $client
 * @property ProjectPartner $partner
 * @property User $createUser
 * @property User $updateUser
 * @property PaymentMoney[] $paymentMoneysPartner
 * @property PaymentMoney[] $paymentMoneysAgent
 * @property PaymentMoney $paymentMoneyPartner last payment
 * @property PaymentMoney $paymentMoneyAgent last payment
 * self::STAT
 * @property int $paymentSum
 * @property int $agentComissionReceived
 */
class Payment extends CActiveRecord
{
    /** @var int */
    public $projectId;

    /** @var string Client City */
    public $clientCity;

    /**
     * @var string date of last payment to partner
     * @see PaymentMoney::date
     */
    public $partnerDate;

    /**
     * @var int last payment money send to partner
     * @see PaymentMoney::amount
     */
    public $partnerAmount;

    /**
     * @var string date of last payment to agent
     * @see PaymentMoney::date
     */
    public $agentDate;

    /**
     * @var int last payment money send to agent
     * @see PaymentMoney::amount
     */
    public $agentAmount;

    /**
     * @var int payment method
     * @see PaymentMoney::method
     */
    public $partnerMethod;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Payment the static model class
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
        return '{{payment}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('client_id, partner_id, payment_amount', 'required'),
            array('client_id, partner_id, payment_amount, payment, agent_comission_amount, agent_comission_received, agent_comission_remain_amount, agent_comission_remain_now, create_user_id, update_user_id', 'numerical', 'integerOnly' => true),
            array('name_company, name_contact', 'length', 'max' => 100),
            array('comments', 'length', 'max' => 255),
            //array('create_time', 'type', 'type' => 'datetime', 'datetimeFormat' => 'yyyy-MM-dd hh:mm:ss'),
            // The following rule is used by search().
            array('id, client_id, partner_id, name_company, name_contact, comments, payment_amount, payment, agent_comission_amount, agent_comission_received, agent_comission_remain_amount, agent_comission_remain_now, create_user_id, update_user_id, create_time, update_time, projectId, city', 'safe', 'on' => 'search'),
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
                'class' => 'application.components.behaviors.SaveBehavior'
            ),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'client'               => array(self::BELONGS_TO, 'Client', 'client_id'),
            'partner'              => array(self::BELONGS_TO, 'ProjectPartner', 'partner_id'),
            //'project'          => array(self::BELONGS_TO, 'Project', 'project_id'),
            'createUser'           => array(self::BELONGS_TO, 'User', 'create_user_id'),
            //'updateUser'       => array(self::BELONGS_TO, 'User', 'update_user_id'),
            'paymentMoneysPartner' => array(self::HAS_MANY, 'PaymentMoney', 'payment_id', 'condition' => 'paymentMoneysPartner.type = 0'),
            'paymentMoneysAgent'   => array(self::HAS_MANY, 'PaymentMoney', 'payment_id', 'condition' => 'paymentMoneysAgent.type = 1'),
            'paymentMoneyPartner'  => array(
                self::HAS_ONE,
                'PaymentMoney',
                'payment_id',
                'on'    => 'paymentMoneyPartner.type = 0',
                'order' => 'paymentMoneyPartner.id DESC'
            ),
            'paymentMoneyAgent'    => array(
                self::HAS_ONE,
                'PaymentMoney',
                'payment_id',
                'on'    => 'paymentMoneyAgent.type = 1',
                'order' => 'paymentMoneyAgent.id DESC'
            ),
            'paymentSum' => array(self::STAT, 'PaymentMoney', 'payment_id', 'select' => 'SUM(amount)', 'condition' => 'type = 0'),
            'agentComissionReceived' => array(self::STAT, 'PaymentMoney', 'payment_id', 'select' => 'SUM(amount)', 'condition' => 'type = 1')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'                            => 'ID',
            'client_id'                     => Yii::t('CrmModule.payment', 'Client'),
            'projectId'                     => Yii::t('CrmModule.payment', 'Project'),
            'partner_id'                    => Yii::t('CrmModule.payment', 'Partner'),
            'name_company'                  => Yii::t('CrmModule.payment', 'Company'),
            'name_contact'                  => Yii::t('CrmModule.payment', 'Contact'),
            'city'                          => Yii::t('CrmModule.payment', 'City'),
            'comments'                      => Yii::t('CrmModule.payment', 'Comments'),
            'payment_amount'                => Yii::t('CrmModule.payment', 'Payment Amount'),
            'payment'                       => Yii::t('CrmModule.payment', 'Payment'),
            'payment_remain'                => Yii::t('CrmModule.payment', 'Payment Remain'),
            'agent_comission_percent'       => Yii::t('CrmModule.payment', 'AC %'),
            'agent_comission_amount'        => Yii::t('CrmModule.payment', 'AC Amount'),
            'agent_comission_received'      => Yii::t('CrmModule.payment', 'AC Received'),
            'agent_comission_remain_amount' => Yii::t('CrmModule.payment', 'AC Remain Amount'),
            'agent_comission_remain_now'    => Yii::t('CrmModule.payment', 'AC Remain Now'),
            'create_user_id'                => Yii::t('CrmModule.payment', 'Create User'),
            'update_user_id'                => Yii::t('CrmModule.payment', 'Update User'),
            'create_time'                   => Yii::t('CrmModule.payment', 'Create Time'),
            'update_time'                   => Yii::t('CrmModule.payment', 'Update Time'),
        );
    }

    public function afterFind()
    {
        $this->payment_remain = $this->payment_amount - $this->payment;
        if ($this->payment_amount) {
            $this->agent_comission_percent = round($this->agent_comission_amount / $this->payment_amount * 100, 1);
        }
        parent::afterFind();
    }

    protected function beforeValidate()
    {
        if ($createTime = CDateTimeParser::parse($this->create_time, 'yyyy-MM-dd', array('hour' => date('H'), 'minute'))) {
            $this->create_time = date('Y-m-d H:i:s', $createTime);
        }
        return parent::beforeValidate();
    }

    public function beforeSave()
    {
        if (!$this->getIsNewRecord()) {
            $this->payment = $this->paymentSum;
        }
        $agentComissionPercent               = $this->agent_comission_amount / $this->payment_amount;
        $this->payment_remain                = $this->payment_amount - $this->payment;
        $this->agent_comission_percent       = round($agentComissionPercent * 100, 2);
        $this->agent_comission_received      = $this->agentComissionReceived;
        $this->agent_comission_remain_amount = $this->agent_comission_amount - $this->agent_comission_received;
        if ($this->agent_comission_amount == $this->agent_comission_received) {
            $this->agent_comission_remain_now = 0;
        } else if ($this->payment == 0) {
            $this->agent_comission_remain_now = $this->agent_comission_remain_amount;
        } else {
            $this->agent_comission_remain_now = round(
                $this->payment * ($agentComissionPercent - ($this->agent_comission_received / $this->payment))
            );
        }
        return parent::beforeSave();
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria       = new CDbCriteria;
        $criteria->with = array(
            'partner'             => array('select' => 'name'),
            'partner.project'     => array('select' => 'name', 'alias' => 'project'), //@todo alias check for errors
            'client'              => array('select' => 'client_id, city'),
            'paymentMoneyPartner',
            'paymentMoneyAgent'
        );
		$criteria->compare('id', $this->id);
		$criteria->compare('client.client_id', $this->client_id);
		$criteria->compare('partner_id', $this->partner_id);
		$criteria->compare('t.name_company', $this->name_company, true);
		$criteria->compare('t.name_contact', $this->name_contact, true);
		$criteria->compare('comments', $this->comments, true);
		$criteria->compare('payment_amount', $this->payment_amount);
		$criteria->compare('payment', $this->payment);
		$criteria->compare('agent_comission_amount', $this->agent_comission_amount);
		$criteria->compare('agent_comission_received', $this->agent_comission_received);
		$criteria->compare('agent_comission_remain_amount', $this->agent_comission_remain_amount);
		$criteria->compare('agent_comission_remain_now', $this->agent_comission_remain_now);
		$criteria->compare('create_user_id', $this->create_user_id);
		$criteria->compare('update_user_id', $this->update_user_id);
		$criteria->compare('create_time', $this->create_time, true);
		$criteria->compare('update_time', $this->update_time, true);

        $criteria->compare('project.id', $this->projectId);
        $criteria->compare('client.city', $this->clientCity, true);
        $criteria->compare('partner.id', $this->partner_id);
        $criteria->compare('paymentMoneyPartner.date', $this->partnerDate);
        $criteria->compare('paymentMoneyPartner.amount', $this->partnerAmount);
        $criteria->compare('paymentMoneyPartner.method', $this->partnerMethod);
        $criteria->compare('paymentMoneyAgent.date', $this->agentDate);
        $criteria->compare('paymentMoneyAgent.amount', $this->agentAmount);

        return new CActiveDataProvider($this, array(
            'criteria'   => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
            'sort'       => array(
                'defaultOrder' => array('id' => true),
                'attributes'   => array(
                    'partner.project.name'  => array(
                        'asc'  => 'partner.project.name',
                        'desc' => 'partner.project.name DESC'
                    ),
                    'partner.name' => array(
                        'asc'  => 'partner.name',
                        'desc' => 'partner.name DESC'
                    ),
                    'client.city' => array(
                        'asc'  => 'client.city',
                        'desc' => 'client.city DESC'
                    ),
                    'createUser.username' => array(
                        'asc'  => 'createUser.username',
                        'desc' => 'createUser.username DESC'
                    ),
                    'paymentMoneyPartner.date' => array(
                        'asc'  => 'paymentMoneyPartner.date',
                        'desc' => 'paymentMoneyPartner.date DESC'
                    ),
                    'paymentMoneyPartner.amount' => array(
                        'asc'  => 'paymentMoneyPartner.amount',
                        'desc' => 'paymentMoneyPartner.amount DESC'
                    ),
                    'paymentMoneyAgent.date' => array(
                        'asc'  => 'paymentMoneyAgent.date',
                        'desc' => 'paymentMoneyAgent.date DESC'
                    ),
                    'paymentMoneyAgent.amount' => array(
                        'asc'  => 'paymentMoneyAgent.amount',
                        'desc' => 'paymentMoneyAgent.amount DESC'
                    ),
                    'paymentMoneyPartner.method' => array(
                        'asc'  => 'paymentMoneyPartner.method',
                        'desc' => 'paymentMoneyPartner.method DESC',
                    ),
                    '*'
                )
            )
        ));
    }
}