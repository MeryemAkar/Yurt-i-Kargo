<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php

ini_set("soap.wsdl_cache_enabled", "0");
ini_set('html_errors', true);
ini_set('display_errors', true);


$webUri		= 'https://ws.yurticikargo.com/KOPSWebServices/WsReportWithReferenceServices?wsdl';

$webUser	= 'YKTEST';
$webPass	= 'YK';
$language			= 'TR';
$keyType			= '0';
$addHistoricalData  = true;
$onlyTracking 		= false;

$soapClient = new SoapClient($webUri,array(
							"trace"      => 1,
						    "exceptions" => 1,
							'encoding'=>'utf-8'));

try{

	function object2array($object) {
	    if (is_object($object)) {
	        foreach ($object as $key => $value) {
	            $array[$key] = $value;
	        }
	    }
	    else {
	        $array = $object;
	    }
	    return $array;
	}

	$keys = array('46895','46896'); 
	
	$response =  $soapClient->queryShipment(array(
									'keys' => $keys,
									'wsUserName' => $webUser,
									'wsPassword' => $webPass,
									'wsLanguage' => $language,
									'keyType' => $keyType,
									'addHistoricalData' => $addHistoricalData,
									'onlyTracking' => $onlyTracking
								));
 

	echo "<p>outFlag :" 		,$response->ShippingDeliveryVO->outFlag			,"</p>";
	echo "<p>outResult :" 		,$response->ShippingDeliveryVO->outResult		,"</p>";
	echo "<p>count :" 			,$response->ShippingDeliveryVO->count			,"</p>";
	echo "<p>senderCustId :" 	,$response->ShippingDeliveryVO->senderCustId	,"</p>";


	$responseArr = $response->ShippingDeliveryVO->shippingDeliveryDetailVO;


	for ($i = 0; $i < count($responseArr); $i++) {
		if($keyType == '0')
			echo '<b>', $responseArr[$i]->cargoKey ,' kargo anahtarı için gönderi sorgulama ; </b>';
		else
			echo '<b>', $responseArr[$i]->invoiceKey ,' fatura anahtarı için gönderi sorgulama ; </b>';
	
		if(count($responseArr[$i]->shippingDeliveryItemDetailVO)>0){
			echo '<p>';
			echo 'cargoKey :'			,  $responseArr[$i]->cargoKey  			,'-' ;
			echo 'invoiceKey :'			,  $responseArr[$i]->invoiceKey   		,'-' ;
			echo 'jobId :'				,  $responseArr[$i]->jobId   			,'-' ;
			echo 'operationCode :'		,  $responseArr[$i]->operationCode  	,'-' ;
			echo 'operationMessage :'	,  $responseArr[$i]->operationMessage  	,'-' ;
			echo 'operationStatus :'	,  $responseArr[$i]->operationStatus  	;
		 
			echo '<br>&nbsp;&nbsp;&nbsp;-->trackingUrl :'			,  $responseArr[$i]->shippingDeliveryItemDetailVO->trackingUrl  	;
			 
			if($addHistoricalData){
				echo '<br>&nbsp;&nbsp;&nbsp;-->cargoKey :'				,  $responseArr[$i]->shippingDeliveryItemDetailVO->cargoKey  	;
				echo '<br>&nbsp;&nbsp;&nbsp;-->docId :'					,  $responseArr[$i]->shippingDeliveryItemDetailVO->docId  	;
				echo '<br>&nbsp;&nbsp;&nbsp;-->invoiceNumber :'			,  $responseArr[$i]->shippingDeliveryItemDetailVO->invoiceNumber  	;
				echo '<br>&nbsp;&nbsp;&nbsp;-->docNumber :'				,  $responseArr[$i]->shippingDeliveryItemDetailVO->docNumber  	;
				echo '<br>&nbsp;&nbsp;&nbsp;-->senderCustId :'			,  $responseArr[$i]->shippingDeliveryItemDetailVO->senderCustId  	;
				echo '<br>&nbsp;&nbsp;&nbsp;-->senderCustName :'		,  $responseArr[$i]->shippingDeliveryItemDetailVO->senderCustName  	;
				echo '<br>&nbsp;&nbsp;&nbsp;-->senderAddressTxt :'		,  $responseArr[$i]->shippingDeliveryItemDetailVO->senderAddressTxt  	;
				echo '<br>&nbsp;&nbsp;&nbsp;-->receiverCustId :'		,  $responseArr[$i]->shippingDeliveryItemDetailVO->receiverCustId  	;
				echo '<br>&nbsp;&nbsp;&nbsp;-->receiverCustName :'		,  $responseArr[$i]->shippingDeliveryItemDetailVO->receiverCustName  	;
				echo '<br>&nbsp;&nbsp;&nbsp;-->receiverAddressTxt :'	,  $responseArr[$i]->shippingDeliveryItemDetailVO->receiverAddressTxt  	;
				echo '<br>&nbsp;&nbsp;&nbsp;-->documentDate :'			,  $responseArr[$i]->shippingDeliveryItemDetailVO->documentDate  	;
				echo '<br>&nbsp;&nbsp;&nbsp;-->documentTime :'			,  $responseArr[$i]->shippingDeliveryItemDetailVO->documentTime  	;
				
				
				
				if(count($responseArr[$i]->shippingDeliveryItemDetailVO->invDocCargoVOArray)>0){

					foreach ( $responseArr[$i]->shippingDeliveryItemDetailVO->invDocCargoVOArray as $inkey){
					echo '<br>&nbsp;&nbsp;&nbsp;Gönderi Bilgileri&nbsp;&nbsp; --> ';
						$arr = object2array($inkey);
						echo ' unitId : ', $arr['unitId'];
						echo ' ,unitName : ', $arr['unitName'];
						echo ' ,eventId : ', $arr['eventId']; 
						echo ' ,eventId : ', $arr['eventId']; 
						echo ' ,eventName : ', $arr['eventName']; 
						echo ' ,reasonId : ', $arr['reasonId']; 
						echo ' ,reasonName : ', $arr['reasonName']; 
						echo ' ,eventDate : ', $arr['eventDate']; 
						echo ' ,eventTime : ', $arr['eventTime']; 
						echo ' ,cityName : ', $arr['cityName']; 
						echo ' ,townName : ', $arr['townName']; 
					}

				}
			}
			echo '</p>';		
		}else{
			echo '<p>';
			echo 'errCode :'			,  $responseArr[$i]->errCode  			,'-' ;
			echo 'errMessage :'			,  $responseArr[$i]->errMessage   		,'-' ;
			echo '</p>';
		}

	}
	
}
catch (Exception $e) {
    echo "<p>ıstek :".htmlspecialchars($soapClient->__getLastRequest()) ."</p>";// Yollanan xml verisi
	echo "<p>Cevap :".htmlspecialchars($soapClient->__getLastResponse())."</p>";// Alınan xml verisi
	echo "<p>Hata  :",  $e->getMessage(), "</p>";
}

?>
</body>