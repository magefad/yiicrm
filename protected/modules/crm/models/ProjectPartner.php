<?php

/**
 * This is the model class for table "{{project_partner}}".
 *
 * The followings are the available columns in table '{{project_partner}}':
 * @property integer $id
 * @property integer $project_id
 * @property string $name
 * @property string $name_short
 *
 * The followings are the available model relations:
 * @property Payment[] $payments
 * @property Project $project
 */
class ProjectPartner extends CActiveRecord
{
    public $projectSearch;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ProjectPartner the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{project_partner}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('project_id, name, name_short', 'required'),
            array('project_id', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 255),
            array('name_short', 'length', 'max' => 3),
            // The following rule is used by search().
            array('id, project_id, name, name_short, projectSearch', 'safe', 'on' => 'search'),
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
            'payments' => array(self::HAS_MANY, 'Payment', 'partner_id'),
            'project'  => array(self::BELONGS_TO, 'Project', 'project_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'         => 'ID',
            'project_id' => Yii::t('CrmModule.projectPartner', 'Project'),
            'name'       => Yii::t('CrmModule.projectPartner', 'Name'),
            'name_short' => Yii::t('CrmModule.projectPartner', 'Name Short'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria       = new CDbCriteria;
        $criteria->with = array('project');
        $criteria->compare('t.id', $this->id);
        //$criteria->compare('project_id', $this->project_id);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.name_short', $this->name_short, true);
        $criteria->compare('project.name', $this->projectSearch, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort'     => array(
                'attributes' => array(
                    'projectSearch' => array(
                        'asc'  => 'project.name',
                        'desc' => 'project.name DESC'
                    ),
                    '*'
                )
            )
        ));
    }
}