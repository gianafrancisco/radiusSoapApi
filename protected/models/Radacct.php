<?php

/**
 * This is the model class for table "radacct".
 *
 * The followings are the available columns in table 'radacct':
 * @property string $radacctid
 * @property string $acctsessionid
 * @property string $acctuniqueid
 * @property string $username
 * @property string $groupname
 * @property string $realm
 * @property string $nasipaddress
 * @property string $nasportid
 * @property string $nasporttype
 * @property string $acctstarttime
 * @property string $acctstoptime
 * @property integer $acctsessiontime
 * @property string $acctauthentic
 * @property string $connectinfo_start
 * @property string $connectinfo_stop
 * @property string $acctinputoctets
 * @property string $acctoutputoctets
 * @property string $calledstationid
 * @property string $callingstationid
 * @property string $acctterminatecause
 * @property string $servicetype
 * @property string $framedprotocol
 * @property string $framedipaddress
 * @property integer $acctstartdelay
 * @property integer $acctstopdelay
 * @property string $xascendsessionsvrkey
 */
class Radacct extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'radacct';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('calledstationid, callingstationid', 'required'),
			array('acctsessiontime, acctstartdelay, acctstopdelay', 'numerical', 'integerOnly'=>true),
			array('acctsessionid, username, groupname, realm', 'length', 'max'=>64),
			array('acctuniqueid, nasporttype, acctauthentic, acctterminatecause, servicetype, framedprotocol', 'length', 'max'=>32),
			array('nasipaddress, nasportid, framedipaddress', 'length', 'max'=>15),
			array('connectinfo_start, connectinfo_stop', 'length', 'max'=>50),
			array('acctinputoctets, acctoutputoctets', 'length', 'max'=>20),
			array('calledstationid, callingstationid', 'length', 'max'=>255),
			array('xascendsessionsvrkey', 'length', 'max'=>10),
			array('acctstarttime, acctstoptime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('radacctid, acctsessionid, acctuniqueid, username, groupname, realm, nasipaddress, nasportid, nasporttype, acctstarttime, acctstoptime, acctsessiontime, acctauthentic, connectinfo_start, connectinfo_stop, acctinputoctets, acctoutputoctets, calledstationid, callingstationid, acctterminatecause, servicetype, framedprotocol, framedipaddress, acctstartdelay, acctstopdelay, xascendsessionsvrkey', 'safe', 'on'=>'search'),
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
			'radacctid' => 'Radacctid',
			'acctsessionid' => 'Acctsessionid',
			'acctuniqueid' => 'Acctuniqueid',
			'username' => 'Username',
			'groupname' => 'Groupname',
			'realm' => 'Realm',
			'nasipaddress' => 'Nasipaddress',
			'nasportid' => 'Nasportid',
			'nasporttype' => 'Nasporttype',
			'acctstarttime' => 'Acctstarttime',
			'acctstoptime' => 'Acctstoptime',
			'acctsessiontime' => 'Acctsessiontime',
			'acctauthentic' => 'Acctauthentic',
			'connectinfo_start' => 'Connectinfo Start',
			'connectinfo_stop' => 'Connectinfo Stop',
			'acctinputoctets' => 'Acctinputoctets',
			'acctoutputoctets' => 'Acctoutputoctets',
			'calledstationid' => 'Calledstationid',
			'callingstationid' => 'Callingstationid',
			'acctterminatecause' => 'Acctterminatecause',
			'servicetype' => 'Servicetype',
			'framedprotocol' => 'Framedprotocol',
			'framedipaddress' => 'Framedipaddress',
			'acctstartdelay' => 'Acctstartdelay',
			'acctstopdelay' => 'Acctstopdelay',
			'xascendsessionsvrkey' => 'Xascendsessionsvrkey',
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

		$criteria->compare('radacctid',$this->radacctid,true);
		$criteria->compare('acctsessionid',$this->acctsessionid,true);
		$criteria->compare('acctuniqueid',$this->acctuniqueid,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('groupname',$this->groupname,true);
		$criteria->compare('realm',$this->realm,true);
		$criteria->compare('nasipaddress',$this->nasipaddress,true);
		$criteria->compare('nasportid',$this->nasportid,true);
		$criteria->compare('nasporttype',$this->nasporttype,true);
		$criteria->compare('acctstarttime',$this->acctstarttime,true);
		$criteria->compare('acctstoptime',$this->acctstoptime,true);
		$criteria->compare('acctsessiontime',$this->acctsessiontime);
		$criteria->compare('acctauthentic',$this->acctauthentic,true);
		$criteria->compare('connectinfo_start',$this->connectinfo_start,true);
		$criteria->compare('connectinfo_stop',$this->connectinfo_stop,true);
		$criteria->compare('acctinputoctets',$this->acctinputoctets,true);
		$criteria->compare('acctoutputoctets',$this->acctoutputoctets,true);
		$criteria->compare('calledstationid',$this->calledstationid,true);
		$criteria->compare('callingstationid',$this->callingstationid,true);
		$criteria->compare('acctterminatecause',$this->acctterminatecause,true);
		$criteria->compare('servicetype',$this->servicetype,true);
		$criteria->compare('framedprotocol',$this->framedprotocol,true);
		$criteria->compare('framedipaddress',$this->framedipaddress,true);
		$criteria->compare('acctstartdelay',$this->acctstartdelay);
		$criteria->compare('acctstopdelay',$this->acctstopdelay);
		$criteria->compare('xascendsessionsvrkey',$this->xascendsessionsvrkey,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Radacct the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
