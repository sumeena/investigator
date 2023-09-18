<?php
$json = file_get_contents('php://input');
$postFields = json_decode($json);
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://sellercentral.amazon.com/rcpublic/getfees',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_SSL_VERIFYHOST=> FALSE,
  CURLOPT_SSL_VERIFYPEER=> FALSE,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{"countryCode":"'.$postFields->countryCode.'","itemInfo":{"asin": "'.$postFields->itemInfo->asin.'","glProductGroupName":"'.$postFields->itemInfo->glProductGroupName.'","afnPriceStr":"'.$postFields->itemInfo->afnPriceStr.'","mfnPriceStr":"'.$postFields->itemInfo->mfnPriceStr.'","mfnShippingPriceStr":"0","currency":"'.$postFields->itemInfo->currency.'","isNewDefined":false},"programIdList":["Core","MFN"]}',
  CURLOPT_HTTPHEADER => array(
    'Content-type: application/json; charset=UTF-8',
    'Accept: */*'
  )
));

$response = curl_exec($curl);
curl_close($curl);
echo $response;
?>