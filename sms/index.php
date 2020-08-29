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

function SendSms($msg,$phone){
    $tok = getToken();
    $url = 'https://telenorcsms.com.pk:27677/corporate_sms2/api/sendsms.jsp?session_id='.$tok.'&to='.$phone.'&text='.urlencode($msg).'&mask=Mkupstudio';
    $send = curl_init();
    curl_setopt($send,CURLOPT_URL, $url);
    curl_setopt($send, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($send, CURLOPT_HEADER, 0);
    $sms = curl_exec($send);
    print $sms;
    curl_close($send);
}

switch ($_GET['form']) {
    case 'pending':
        $user = $_GET['user'];
        $total = $_GET['total'];
        $phone = $_GET['phone'];
        $msg = "Hello $user \r\nThe appointment is in a pending state. We will soon assign a beautician according to the details of your order for futher process.\r\nTotal Charges Rs $total.Charges payable after service completion.\r\nThanks for using Makeup Studio!";
        SendSms($msg,$phone);
    break;

    case 'processing':
        $user = $_GET['user'];
        $total = $_GET['total'];
        $phone = $_GET['phone'];
        $id = $_GET['appointment'];
        $date = $_GET['date'];
        $time = $_GET['time'];
        $msg = "Dear $user \r\nYour appointment is in processing we have successfully noted details of your order. Your appointment number is #$id we have assign a beautican to your appoinment. Worker will be your place on $date at $time. You can check out details in your Makeup Studio account.\r\nTotal Charges Rs $total. Charges payable after service completion.\r\n Thanks for using Makeup Studio!";
        SendSms($msg,$phone);
    break;

    case 'completed':
        $user = $_GET['user'];
        $phone = $_GET['phone'];
        $id = $_GET['appointment'];
        $msg = "Dear $user\r\n Your appointment #$id has been successfully completed.\r\nThank you for using Makeup Studio!";   
        SendSms($msg,$phone);
    break;

    case 'cancel':
        $user = $_GET['user'];
        $phone = $_GET['phone'];
        $id = $_GET['appointment'];
        $msg = "Dear $user\r\nThe order for appointment no #$id has been cancelled.\r\nThank you for using Makeup Studio!";     
        SendSms($msg,$phone);
    break;


    
    default:
        echo 'something went wrong';
    break;
}


?>