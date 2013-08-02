<?php

/**
 * This is the model class for table "{{partner_project}}".
 *
 * The followings are the available columns in table '{{partner_project}}':
 * @property integer $partner_id
 * @property integer $project_id
 */
class PartnerProject extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PartnerProject the static model class
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
        return '{{partner_project}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('partner_id, project_id', 'required'),
            array('partner_id, project_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            array('partner_id, project_id', 'safe', 'on' => 'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'partner_id' => Yii::t('PartnerProject', 'Partner'),
            'project_id' => Yii::t('PartnerProject', 'Project'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;

		$criteria->compare('partner_id', $this->partner_id);
		$criteria->compare('project_id', $this->project_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}