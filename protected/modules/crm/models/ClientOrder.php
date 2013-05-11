<?php

/**
 * This is the model class for table "{{client_order}}".
 *
 * The followings are the available columns in table '{{client_order}}':
 * @property integer $id
 * @property integer $client_id
 * @property string $product
 * @property string $client_request
 * @property string $sponsor
 * @property string $comment_history
 * @property string $comment_fail
 * @property boolean $contract_copy
 * @property string $comment_review
 * @property integer $photo
 * @property string $description_production
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_user_id
 *
 * The followings are the available model relations:
 * @property User $createUser
 * @property Client $client
 */
class ClientOrder extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ClientOrder the static model class
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
        return '{{client_order}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('client_id, client_request, comment_history', 'required'),
            array('client_id, photo, create_user_id', 'numerical', 'integerOnly' => true),
            array('contract_copy', 'boolean'),
            array('product', 'length', 'max' => 255),
            array('sponsor', 'length', 'max' => 100),
            array('client_request, comment_history, comment_fail, comment_review, photo, description_production', 'filter', 'filter' => 'strip_tags'),
            array(
                'client_request, comment_history, comment_fail, comment_review, photo, description_production',
                'filter',
                'filter' => array($obj = new CHtmlPurifier(), 'purify')
            ),
            array('contract_copy, photo, update_time', 'default', 'value' => null, 'setOnEmpty' => true),
            array('update_time', 'type', 'type' => 'datetime', 'datetimeFormat' => 'yyyy-MM-dd hh:mm:ss'),
            // The following rule is used by search().
            array('id, client_id, product, client_request, sponsor, comment_history, comment_fail, contract_copy, comment_review, create_time, update_time, create_user_id', 'safe', 'on' => 'search'),
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
                'class'               => 'application.components.behaviors.SaveBehavior',
                'updateAttribute'     => null,
                'updateUserAttribute' => null,
            ),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'createUser' => array(self::BELONGS_TO, 'User', 'create_user_id'),
            'client'     => array(self::BELONGS_TO, 'Client', 'client_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'                     => 'ID',
            'client_id'              => Yii::t('CrmModule.client', 'Client'),
            'product'                => Yii::t('CrmModule.client', 'Product'),
            'client_request'         => Yii::t('CrmModule.client', 'Client Request'),
            'sponsor'                => Yii::t('CrmModule.client', 'Sponsor'),
            'comment_history'        => Yii::t('CrmModule.client', 'Comment History'),
            'comment_fail'           => Yii::t('CrmModule.client', 'Comment Fail'),
            'contract_copy'          => Yii::t('CrmModule.client', 'Contract Copy'),
            'comment_review'         => Yii::t('CrmModule.client', 'Comment Review'),
            'photo'                  => Yii::t('CrmModule.client', 'Photo'),
            'description_production' => Yii::t('CrmModule.client', 'Description Production'),
            'create_time'            => Yii::t('CrmModule.client', 'Create Time'),
            'update_time'            => Yii::t('CrmModule.client', 'Update Time'),
            'create_user_id'         => Yii::t('CrmModule.client', 'Manager'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;
        //$criteria->with = array('createUser');
		$criteria->compare('id', $this->id);
		$criteria->compare('client_id', $this->client_id);
		$criteria->compare('product', $this->product,true);
		$criteria->compare('client_request', $this->client_request,true);
		$criteria->compare('sponsor', $this->sponsor,true);
		$criteria->compare('comment_history', $this->comment_history,true);
		$criteria->compare('comment_fail', $this->comment_fail,true);
		$criteria->compare('contract_copy', $this->contract_copy);
		$criteria->compare('comment_review', $this->comment_review,true);
		$criteria->compare('photo', $this->photo,true);
		$criteria->compare('description_production', $this->description_production,true);
		$criteria->compare('create_time', $this->create_time,true);
		$criteria->compare('update_time', $this->update_time,true);
		$criteria->compare('create_user_id', $this->create_user_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    protected function beforeValidate()
    {
        if ($updateTime = CDateTimeParser::parse($this->update_time, 'yyyy-MM-dd', array('hour' => date('H'), 'minute'))) {
            $this->update_time = date('Y-m-d H:i:s', $updateTime);
        }
        return parent::beforeValidate();
    }

    public function getList($attribute)
    {
        if (!$list = Yii::app()->getCache()->get(__CLASS__ . 'getList_' . $attribute)) {
            $command = Yii::app()->getDb()->createCommand()->select($attribute)->from(self::tableName());
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
