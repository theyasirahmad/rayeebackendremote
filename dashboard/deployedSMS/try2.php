<?php
  
 include 'oldindex2.php';
 
 echo "NEW SESSIONID ....\r\n";
 echo getSessionId();
 //echo " nice ufff ";

$messageText="Please Confirm your OTP ".$_GET['msg']." in Raaye App. Thanks. \n http://Raaye.com.pk";
$toNumbersCsv=$_GET['number'];

echo "\r\n";
echo $messageText;
echo "\r\n";
echo $toNumbersCsv;
echo "\r\n";

//$messageText="pop-api curl hosting site to local";
//$toNumbersCsv="923333314434";

$mask="RAAYE";
$sessionKey=getsessionID();
sendSmsMessage($messageText,$toNumbersCsv,$mask,$sessionKey);

print "\r\n....CHK MOBILE..wiht mask"



?>
