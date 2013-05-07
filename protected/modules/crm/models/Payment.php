<?php

/**
 * This is the model class for table "{{payment}}".
 *
 * The followings are the available columns in table '{{payment}}':
 * @property integer $id
 * @property string $__ID
 * @property integer $client_id
 * @property integer $partner_id
 * @property string $name_company
 * @property string $name_contact
 * @property string $city
 * @property string $comments
 * @property integer $payment_amount
 * @property integer $payment
 * @property integer $payment_remain
 * @property string $calculation_percent
 * @property string $agent_comission_percent
 * @property integer $agent_comission_amount
 * @property integer $agent_comission_received
 * @property integer $agent_comission_remain_amount
 * @property integer $agent_comission_remain_now
 * @property integer $error
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
 * @property PaymentMoney[] $paymentMoneys
 */
class Payment extends CActiveRecord
{
    /**
     * @var int
     */
    public $project_id;

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
            array('partner_id, payment_amount', 'required'),
            array('client_id, partner_id, payment_amount, payment, payment_remain, agent_comission_amount, agent_comission_received, agent_comission_remain_amount, agent_comission_remain_now, error, create_user_id, update_user_id', 'numerical', 'integerOnly' => true),
            array('name_company', 'length', 'max' => 97),
            array('name_contact', 'length', 'max' => 102),
            array('city', 'length', 'max' => 60),
            array('comments', 'length', 'max' => 159),
            array('calculation_percent, agent_comission_percent', 'length', 'max' => 14),
            array('create_time', 'safe'),
            // The following rule is used by search().
            array('id, __ID, client_id, partner_id, name_company, name_contact, city, comments, payment_amount, payment, payment_remain, calculation_percent, agent_comission_percent, agent_comission_amount, agent_comission_received, agent_comission_remain_amount, agent_comission_remain_now, error, create_user_id, update_user_id, create_time, update_time, project_id', 'safe', 'on' => 'search'),
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
            'client' => array(self::BELONGS_TO, 'Client', 'client_id'),
            'partner' => array(self::BELONGS_TO, 'ProjectPartner', 'partner_id'),
            //'project' => array(self::BELONGS_TO, 'Project', 'project_id'),
            'createUser' => array(self::BELONGS_TO, 'User', 'create_user_id'),
            'updateUser' => array(self::BELONGS_TO, 'User', 'update_user_id'),
            'paymentMoneys' => array(self::HAS_MANY, 'PaymentMoney', 'payment_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'client_id' => Yii::t('CrmModule.payment', 'Client'),
            'project_id' => Yii::t('CrmModule.payment', 'Project'),
            'partner_id' => Yii::t('CrmModule.payment', 'Partner'),
            'name_company' => Yii::t('CrmModule.payment', 'Company'),
            'name_contact' => Yii::t('CrmModule.payment', 'Contact'),
            'city' => Yii::t('CrmModule.payment', 'City'),
            'comments' => Yii::t('CrmModule.payment', 'Comments'),
            'payment_amount' => Yii::t('CrmModule.payment', 'Payment Amount'),
            'payment' => Yii::t('CrmModule.payment', 'Payment'),
            'payment_remain' => Yii::t('CrmModule.payment', 'Payment Remain'),
            'calculation_percent' => Yii::t('CrmModule.payment', 'Calculation %'),
            'agent_comission_percent' => Yii::t('CrmModule.payment', 'AC %'),
            'agent_comission_amount' => Yii::t('CrmModule.payment', 'AC Amount'),
            'agent_comission_received' => Yii::t('CrmModule.payment', 'AC Received'),
            'agent_comission_remain_amount' => Yii::t('CrmModule.payment', 'AC Remain Amount'),
            'agent_comission_remain_now' => Yii::t('CrmModule.payment', 'AC Remain Now'),
            'error' => Yii::t('CrmModule.payment', 'Error'),
            'create_user_id' => Yii::t('CrmModule.payment', 'Create User'),
            'update_user_id' => Yii::t('CrmModule.payment', 'Update User'),
            'create_time' => Yii::t('CrmModule.payment', 'Create Time'),
            'update_time' => Yii::t('CrmModule.payment', 'Update Time'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->with = array('partner' => array('select' => 'name'), 'partner.project' => array('select' => 'name'));
		$criteria->compare('id', $this->id);
		$criteria->compare('__ID', $this->__ID,true);
		$criteria->compare('client_id', $this->client_id);
		$criteria->compare('partner_id', $this->partner_id);
		$criteria->compare('name_company', $this->name_company,true);
		$criteria->compare('name_contact', $this->name_contact,true);
		$criteria->compare('city', $this->city,true);
		$criteria->compare('comments', $this->comments,true);
		$criteria->compare('payment_amount', $this->payment_amount);
		$criteria->compare('payment', $this->payment);
		$criteria->compare('payment_remain', $this->payment_remain);
		$criteria->compare('calculation_percent', $this->calculation_percent,true);
		$criteria->compare('agent_comission_percent', $this->agent_comission_percent,true);
		$criteria->compare('agent_comission_amount', $this->agent_comission_amount);
		$criteria->compare('agent_comission_received', $this->agent_comission_received);
		$criteria->compare('agent_comission_remain_amount', $this->agent_comission_remain_amount);
		$criteria->compare('agent_comission_remain_now', $this->agent_comission_remain_now);
		$criteria->compare('error', $this->error);
		$criteria->compare('create_user_id', $this->create_user_id);
		$criteria->compare('update_user_id', $this->update_user_id);
		$criteria->compare('create_time', $this->create_time,true);
		$criteria->compare('update_time', $this->update_time,true);

        $criteria->compare('partner.project.name', $this->project_id, true);
        $criteria->compare('partner.name', $this->partner_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
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
                    'createUser.username' => array(
                        'asc'  => 'createUser.username',
                        'desc' => 'createUser.username DESC'
                    ),
                    '*'
                )
            )
        ));
    }
}