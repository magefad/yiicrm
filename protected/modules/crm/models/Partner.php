<?php

/**
 * This is the model class for table "{{partner}}".
 *
 * The followings are the available columns in table '{{partner}}':
 * @property integer $id
 * @property string $name
 * @property string $name_short
 * @property integer $delivery
 *
 * The followings are the available model relations:
 * @property Project[] $fadProjects
 * @property Payment[] $payments
 */
class Partner extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Partner the static model class
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
        return '{{partner}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, name_short', 'required'),
            array('delivery', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 255),
            array('name_short', 'length', 'max' => 3),
            // The following rule is used by search().
            array('id, name, name_short, delivery', 'safe', 'on' => 'search'),
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
            'projects' => array(self::MANY_MANY, 'Project', '{{partner_project}}(partner_id, project_id)'),
            'payments' => array(self::HAS_MANY, 'Payment', 'partner_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('CrmModule.partner', 'ID'),
            'name' => Yii::t('CrmModule.partner', 'Name'),
            'name_short' => Yii::t('CrmModule.partner', 'Name Short'),
            'delivery' => Yii::t('CrmModule.partner', 'Delivery'),
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
		$criteria->compare('name', $this->name,true);
		$criteria->compare('name_short', $this->name_short,true);
		$criteria->compare('delivery', $this->delivery);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}