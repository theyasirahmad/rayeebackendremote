<?php


function getToken(){
$client = curl_init();
curl_setopt($client, CURLOPT_URL, 'https://telenorcsms.com.pk:27677/corporate_sms2/api/auth.jsp?msisdn=923420637755&password=Makeup@123456789');
curl_setopt($client, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($client, CURLOPT_HEADER, 0);
$res = curl_exec($client);
// print $res;
$xml = simplexml_load_string($res);
$json = json_encode($xml);
$arr = json_decode($json);
$token = $arr->data;
curl_close($client);
return $token;
}

function SendSms(){
$tok = getToken();
$phone = $_GET['phone'];
$msg = '';
$msg .= $_GET['msg'];
$msg .= " is your makeup studio verification code.";
$url = 'https://telenorcsms.com.pk:27677/corporate_sms2/api/sendsms.jsp?session_id='.$tok.'&to='.$phone.'&text='.urlencode($msg).'&mask=Mkupstudio';
$send = curl_init();
curl_setopt($send,CURLOPT_URL, $url);
curl_setopt($send, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($send, CURLOPT_HEADER, 0);
$sms = curl_exec($send);
print $sms;
curl_close($send);
}

SendSms();

