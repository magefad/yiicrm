<?php

/**
 * This is the model class for table "{{project}}".
 *
 * The followings are the available columns in table '{{project}}':
 * @property integer $id
 * @property string $name
 * @property string $name_short
 *
 * The followings are the available model relations:
 * @property Client[] $clients
 * @property ProjectPartner[] $projectPartners
 */
class Project extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Project the static model class
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
        return '{{project}}';
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
            array('name', 'length', 'max' => 255),
            array('name_short', 'length', 'max' => 3),
            // The following rule is used by search().
            array('id, name, name_short', 'safe', 'on' => 'search'),
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
            'clients' => array(self::HAS_MANY, 'Client', 'project_id'),
            'projectPartners' => array(self::HAS_MANY, 'ProjectPartner', 'project_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => Yii::t('CrmModule.project', 'Name'),
            'name_short' => Yii::t('CrmModule.project', 'Name Short'),
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

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getList($attribute = 'name')
    {
        $rows = Yii::app()->db->createCommand()->select('id,' . $attribute)->from('{{project}}')->queryAll();
        $list = array();
        foreach ($rows as $i => $data) {
            $list[$data['id']] = $data[$attribute];
        }
        return $list;
    }
}