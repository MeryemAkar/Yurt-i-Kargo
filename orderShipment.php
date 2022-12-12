<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php
ini_set("soap.wsdl_cache_enabled", "0");
ini_set('html_errors', true);
ini_set('display_errors', true);

$isim = "Arya Mia";
$adres = "23 sokak no:43 İstanbul";
$telefon1 = "05333333333";
$telefon2 = "02120000000";


$webUri		= 'https://ws.yurticikargo.com/KOPSWebServices/NgiShipmentInterfaceServices?wsdl';
$webUser	= 'YKTEST';
$webPass	= 'YK';
$language	= 'TR';
$soapClient = new SoapClient($webUri,array(
							"trace"      => 1,
						    "exceptions" => 1,
							'encoding'=>'utf-8'));

try{

	$order = new stdClass(); 
	// Gönderi Bilgileri
	$order->cargoKey          	= "HH10012";
	$order->invoiceKey          = "HH10012";
	//$order->waybillNo           = "TSVK282222";
	$order->description         = "HH1000 nolu sipariş açıklamasıdır. www.google.com"; 
	$order->desi                = "0";
	$order->kg                  = "0";
	//$order->specialField1	    = "2$2519#";
	$order->cargoCount        	= 2;
	
	// Alıcı Bilgileri
	$order->receiverCustName    = $isim;
	$order->receiverAddress     = $adres;
	$order->receiverPhone1      = $telefon1;
	$order->receiverPhone2      = $telefon2;
	$order->cityName            = "İstanbul";
	$order->townName            = "Beşiktas";

	$order->taxOfficeId     	= NULL;
	$order->taxNumber     		= NULL;
	$order->taxOfficeName   	= NULL;

	// Tahsilatlı Teslimat 
	$order->ttDocumentId		= NULL; // Tahsilâtlı Teslimat Fatura No
	$order->ttDocumentSaveType  = "0"; // "Tahsilâtlı teslimat ürünü hizmet bedeli gönderi içerisinde mi?  (0 – Aynı fatura,1 – farklı fatura)"
	$order->ttInvoiceAmount     = "20"; // "Tahsilâtlı teslimat ürünü tutar bilgisi Separator (.) olmalıdır."
	$order->orgReceiverCustId   = "123456"; // Alıcı Müşteri Kodu (Örn: Temsilci No)
	$order->ttCollectionType    = "1"; // "Tahsilâtlı teslimat ürünü ödeme tipi  ( 0 – Nakit, 1-Kredi Kartı)"

	// Kredi Kartlı Tahsilatlı Teslimat
	$order->dcSelectedCredit    = "1"; // "Müşteri Taksit Seçimi (Taksit Sayısı)"
	$order->dcCreditRule    	= "1"; // "Taksit Uygulama Kriteri  0: Müşteri Seçimi Zorunlu,  1: Tek Çekime izin ver"
	
	
	$response =  $soapClient->createShipment(array('ShippingOrderVO'=>$order,'wsUserName'=>$webUser,'wsPassword'=>$webPass,'userLanguage'=>$language));
	
	echo "<p>outFlag :" 	,$response->ShippingOrderResultVO->outFlag		,"</p>";
	echo "<p>outResult :" 	,$response->ShippingOrderResultVO->outResult	,"</p>";
	echo "<p>count :" 		,$response->ShippingOrderResultVO->count		,"</p>";
	echo "<p>jobId :" 		,$response->ShippingOrderResultVO->jobId		,"</p>";
	
	$responseArr = $response->ShippingOrderResultVO->shippingOrderDetailVO;

	echo '<p>';
	echo 'cargoKey :'	,  $responseArr->cargoKey  		,'-' ;
	echo 'invoiceKey :'	,  $responseArr->invoiceKey   	,'-' ;
	echo 'errCode :'	,  $responseArr->errCode   		,'-' ;
	echo 'errMessage :'	,  $responseArr->errMessage  	;
	echo '</p>';
}
catch (Exception $e) {
    echo "<p>İstek :".htmlspecialchars($soapClient->__getLastRequest()) ."</p>";// Yollanan xml verisi
	echo "<p>Cevap :".htmlspecialchars($soapClient->__getLastResponse())."</p>";// Alınan xml verisi
	echo "<p>Hata  :",  $e->getMessage(), "</p>";
}

?>
</body>