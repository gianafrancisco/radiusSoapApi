<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Radius SOAP API',

	// preloading 'log' component
	'preload'=>array('log'),
	'import'=>array(
		'application.models.*',
		'application.components.*',
                'application.commands.*',
	),
	// application components
	'components'=>array(
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=radius',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'IsaacNewton',
			'charset' => 'utf8',
		),
                 * 
                 */
            	'db'=>array(
			'connectionString' => 'mysql:host=radiusmysql.cajadzo6fbz6.ap-southeast-2.rds.amazonaws.com;dbname=radius',
			'emulatePrepare' => true,
			'username' => 'radiusmysql',
			'password' => 'efSeFUsPs9',
			'charset' => 'utf8',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning, info',
				),
			),
		),
	),
);