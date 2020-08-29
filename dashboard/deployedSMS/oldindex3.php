<?php
// Urls for authentication and sending quich message
//$planetbeyondApiUrl="https://telenorcsms.com.pk:27677/corporate_sms2/api/auth.jsp?msisdn=#userName#&password=#password#";
$planetbeyondApiUrl="https://telenorcsms.com.pk:27677/corporate_sms2/api/auth.jsp?msisdn=arif&password=Arif2020Pakistan12345678";

////$planetbeyondApiSendSmsUrl="https://telenorcsms.com.pk:27677/corporate_sms2/api/sendsms.jsp?session_id=#session_id#&to=#to_number_csv#&text=#message_text#&mask=RAAYE&transaction_message=true";


$planetbeyondApiSendSmsUrl="https://secure-web.cisco.com/18tzQk3wGbk7ePZjMO6411xoWuCLDnaXx9TG7OhKZ-7Np2dFC8YLHjcEOQrxT18OsUa1IvChbEsRQHFHy4PD7Oyw8vEz_hacKB0SYcqSdFIwibkGkruX0vS9xxioztmCxe1D9xcA1-UnIG3WflyKWJRZamM-UOf2uyLFES88G2gOxvYt23L3QXA_uPhpmghuyrbbs2uXUjgg3LvlDQWnlJea8WMRYmDAr192wHul2YIkQWciyPll5HquJ4-LBnD_Q4HrNxa2KnlZebHay3-cTGg/https%3A%2F%2Ftelenorcsms.com.pk%3A27677%2Fcorporate_sms2%2Fapi/sendsms.jsp?session_id=#session_id#&to=#to_number_csv#&text=#message_text#&mask=RAAYE&transaction_message=true"


// Please provide correct username and password here of your account
//$userName="923405258574";
//$password="Pakistan123#123#";

$userName="arif";
$password="Arif2020Pakistan12345678";

/**
 Returns sessionId required to send quick message
*/

function getSessionId()
{
	//echo "in session id..";
	global $userName,$password,$planetbeyondApiUrl;
	$url=str_replace("#username#",$userName,$planetbeyondApiUrl);
	$url=str_replace("#password#",$password,$url);
	
	$response = sendApiCall($url);
	echo $response;
	
	if($response && substr($response->response,0,5)!=="Error")
	{
	    return $response->data;
	}
	return -1;
    
}

/**
 Sends Quick message
*/
function sendSmsMessage($messageText,$toNumbersCsv,$mask,$sessionKey)
{
	global $planetbeyondApiSendSmsUrl;
	$sessionKey=getSessionId();
	$url=str_replace("#message_text#",urlencode($messageText),$planetbeyondApiSendSmsUrl);
	$url=str_replace("#to_number_csv#",$toNumbersCsv,$url);
	//$url=str_replace("#from_number#",$fromNumber,$url);
	$urlWithSessionKey=str_replace("#session_id#",$sessionKey,$url);
	if($mask!=null)
	{
		$urlWithSessionKey = $urlWithSessionKey . "&mask=" . $mask;
	}
	$xml=sendApiCall($urlWithSessionKey);
	//echo $xml;
	return $xml->data;
}

/**
 Sends Http request to api
*/
function sendApiCall($url)
{
	//echo "in call api..";	
	$response = file_get_contents($url);
	$xml=simplexml_load_string($response) or die("Error: Cannot create object");
	
	//if($xml && !isEmpty($xml->response))
	//{
	    return $xml;
	//    echo "ITS NULL";
	//}
	//return "";
}

echo "DONE...";
?>
