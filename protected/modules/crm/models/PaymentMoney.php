<?php

/**
 * This is the model class for table "{{payment_money}}".
 *
 * The followings are the available columns in table '{{payment_money}}':
 * @property integer $id
 * @property integer $type
 * @property integer $method
 * @property integer $payment_id
 * @property string $date
 * @property integer $amount
 * @property integer $create_user_id
 * @property integer $update_user_id
 * @property string $create_time
 * @property string $update_time
 *
 * The followings are the available model relations:
 * @property Payment $payment
 * @property User $createUser
 * @property User $updateUser
 *
 * @property StatusBehavior $statusMethod
 * @property StatusBehavior $statusType
 */
class PaymentMoney extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PaymentMoney the static model class
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
        return '{{payment_money}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('payment_id, amount, create_user_id, update_time', 'required'),
            array('type, method, payment_id, amount, create_user_id, update_user_id', 'numerical', 'integerOnly' => true),
            array('date, create_time', 'safe'),
            // The following rule is used by search().
            array('id, type, method, payment_id, date, amount, create_user_id, update_user_id, create_time, update_time', 'safe', 'on' => 'search'),
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
                'class' => 'application.components.behaviors.SaveBehavior',
            ),
            'statusType'   => array(
                'class'     => 'application.components.behaviors.StatusBehavior',
                'attribute' => 'method',
                'list'      => array('Партнер', 'Контрагент')
            ),
            'statusMethod' => array(
                'class' => 'StatusBehavior',
                'list'  => array('Наличные', 'Р/С', 'Карта')
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
            'payment' => array(self::BELONGS_TO, 'Payment', 'payment_id'),
            'createUser' => array(self::BELONGS_TO, 'User', 'create_user_id'),
            'updateUser' => array(self::BELONGS_TO, 'User', 'update_user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'type' => Yii::t('CrmModule.paymentMoney', 'Type'),
            'method' => Yii::t('CrmModule.paymentMoney', 'Payment Method'),
            'payment_id' => Yii::t('CrmModule.paymentMoney', 'Payment'),
            'date' => Yii::t('CrmModule.paymentMoney', 'Date'),
            'amount' => Yii::t('CrmModule.paymentMoney', 'Amount'),
            'create_user_id' => Yii::t('CrmModule.paymentMoney', 'Create User'),
            'update_user_id' => Yii::t('CrmModule.paymentMoney', 'Update User'),
            'create_time' => Yii::t('CrmModule.paymentMoney', 'Create Time'),
            'update_time' => Yii::t('CrmModule.paymentMoney', 'Update Time'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('type', $this->type);
		$criteria->compare('payment_id', $this->payment_id);
		$criteria->compare('date', $this->date, true);
		$criteria->compare('amount', $this->amount);
		$criteria->compare('create_user_id', $this->create_user_id);
		$criteria->compare('update_user_id', $this->update_user_id);
		$criteria->compare('create_time', $this->create_time, true);
		$criteria->compare('update_time', $this->update_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function afterFind()
    {
        $this->date = substr($this->date, 0, 10);
        parent::afterFind();
    }
}