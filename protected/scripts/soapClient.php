#!/usr/bin/php
<?php
#ini_set ( 'soap.wsdl_cache_enable' , 0 );
#ini_set ( 'soap.wsdl_cache_ttl' , 0 );

//$client=new SoapClient('http://127.0.0.1/soapApi/index.php?r=site/soap',array('username'=>'francisco','password'=>'pass','location'=>'http://127.0.0.1/soapApi/index.php?r=site/soap','url'=>'http://127.0.0.1/soapApi/','soap_version'=>SOAP_1_2));

//$client=new SoapClient('http://103.26.62.218:8080/soapApi/index.php?r=site/soap',array('soap_version'   => SOAP_1_2));
//$client=new SoapClient('http://127.0.0.1/radiusSoapApi/index.php?r=site/soap&id=111');

$client=new SoapClient('http://14.137.150.90/radiusApi/index.php?r=site/soap');


$functions = $client->__getFunctions ();
var_dump ($functions);

//if($client->speedLimit("testuser",10485760,10485760)){
if($client->unsuspend("testuser")){
    echo "OK";
}else
    echo "FAIL";

//$client=new SoapClient('http://127.0.0.1/soapApi/index.php?r=site/soap');
//$resp=$client->del('200.117.199.156');
//$resp=$client->add('200.117.199.156');
//$resp=$client->show('Proxy');
//echo $resp;
//if($resp){
//	echo "OK";
//}else{
//	echo "Error";
//}

//var_dump($client->__getLastRequestHeaders());
//var_dump($client->__getLastRequest());
//var_dump($res);
//echo $client->__getLastResponse();
//print $client->__getLastRequest();
?>
