<?php

/**
 * This is the model class for table "nas".
 *
 * The followings are the available columns in table 'nas':
 * @property integer $id
 * @property string $nasname
 * @property string $shortname
 * @property string $type
 * @property integer $ports
 * @property string $secret
 * @property string $server
 * @property string $community
 * @property string $description
 */
class Nas extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'nas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nasname', 'required'),
			array('ports', 'numerical', 'integerOnly'=>true),
			array('nasname', 'length', 'max'=>128),
			array('shortname', 'length', 'max'=>32),
			array('type', 'length', 'max'=>30),
			array('secret', 'length', 'max'=>60),
			array('server', 'length', 'max'=>64),
			array('community', 'length', 'max'=>50),
			array('description', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nasname, shortname, type, ports, secret, server, community, description', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'nasname' => 'Nasname',
			'shortname' => 'Shortname',
			'type' => 'Type',
			'ports' => 'Ports',
			'secret' => 'Secret',
			'server' => 'Server',
			'community' => 'Community',
			'description' => 'Description',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('nasname',$this->nasname,true);
		$criteria->compare('shortname',$this->shortname,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('ports',$this->ports);
		$criteria->compare('secret',$this->secret,true);
		$criteria->compare('server',$this->server,true);
		$criteria->compare('community',$this->community,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Nas the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
