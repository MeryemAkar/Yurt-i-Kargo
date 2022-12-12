<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php

ini_set("soap.wsdl_cache_enabled", "0");
ini_set('html_errors', true);
ini_set('display_errors', true);

$webUri				= 'https://ws.yurticikargo.com/KOPSWebServices/NgiShipmentInterfaceServices?wsdl';
$webUser			= 'YENIODER2';
$webPass			= '9gGaCg572X7300Xf';
$language			= 'TR';
 

$soapClient = new SoapClient($webUri,array(
							"trace"      => 1,
						    "exceptions" => 1,
							'encoding'=>'utf-8'));

try{

	$cargoKeys = array('46895','46896'); 
	
	$response =  $soapClient->cancelShipment(array('cargoKeys'=>$cargoKeys,'wsUserName'=>$webUser,'wsPassword'=>$webPass,'userLanguage'=>$language));
 
	echo "<p>outFlag :" 		,$response->ShippingOrderResultVO->outFlag			,"</p>";
	echo "<p>outResult :" 		,$response->ShippingOrderResultVO->outResult		,"</p>";
	echo "<p>count :" 			,$response->ShippingOrderResultVO->count			,"</p>";
	echo "<p>senderCustId :" 	,$response->ShippingOrderResultVO->senderCustId	,"</p>";
		
	$responseArr = $response->ShippingOrderResultVO->shippingCancelDetailVO;
	 
	for ($i = 0; $i < count($responseArr); $i++) {
		echo '<p>';
		echo 'cargoKey :'		,  $responseArr[$i]->cargoKey  	,'-' ;
		echo 'docId :'			,  $responseArr[$i]->docId   	,'-' ;
		echo 'jobId :'			,  $responseArr[$i]->jobId   	,'-' ;
		echo 'errCode :'		,  $responseArr[$i]->errCode  	,'-' ;
		echo 'errMessage :'		,  $responseArr[$i]->errMessage ,'-' ; 		
		echo 'operationCode :'		,  $responseArr[$i]->operationCode ,'-' ; 		
		echo 'operationMessage :'	,  $responseArr[$i]->operationMessage ,'-' ; 		
		echo 'operationStatus :'	,  $responseArr[$i]->operationStatus ,'-' ; 				
		echo '</p>';	
	} 	 
	
}
catch (Exception $e) {
    echo "<p>İstek :".htmlspecialchars($soapClient->__getLastRequest()) ."</p>";// Yollanan xml verisi
	echo "<p>Cevap :".htmlspecialchars($soapClient->__getLastResponse())."</p>";// Alinan xml verisi
	echo "<p>Hata  :",  $e->getMessage(), "</p>";
}

?>
</body>