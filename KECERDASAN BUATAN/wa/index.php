<?php
$data = file_get_contents('php://input');
$data = json_decode($data, true);

$nomorsaya = '6285719354041';
$to = $data['to'];
$body = $data['body'];
$from = $data['from'];

    if($body == '!Ping'){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crm.woo-wa.com/send/message-text',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "deviceId":"d_ID@650a712136739_GEC6mSYI1zv9t",
            "number": $to,
            "message":"Pong"
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);
    }



