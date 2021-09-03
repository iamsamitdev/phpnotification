<?php
require 'connectmssql.php';

define('API_ACCESS_KEY','AAAAVU2zPNw:APA91bHgXtkmD0Pt8Lbon5y52Isk9dKp3iqNawYo1R4N1tJ9yLC5Q417gZCb84vg4zi3j_AYYC5eUZAwLfxihk3aVHYi72YOh0ZkVsUwc0UhMVfQZS43gFAhqNYoty-kFuDQa42mo0Bl');

$fcmUrl = 'https://fcm.googleapis.com/fcm/send';

// ฟังก์ชันรับข้อมูลจาก api
$input = file_get_contents('php://input');
$data_input = json_decode($input);
$username = $data_input->username;
$sender = $data_input->sender;
$message = $data_input->message;

$sql = "SELECT TOP 1 uid,username,token FROM firebasenoti WHERE username=:username";
$result = $connect->prepare($sql);
$result->execute([$username]);
$data = $result->fetch();

$token = $data['token'];


// $token = 'cYdd0_K3RfyPe5eNCNjkdk:APA91bFcjo_LVYTpP2b0z28H4GTY8cYg1ajErkStwtkJsY3iuSEm7Oc1sTv5o7zFMXUdKoEylAFUEGZvetUUkiM07bQ5vXEW4OJeP0kwDyIatgE88ZgHmWW5DM9rJPP-D1aJorOsKbwe';
// $tokenList = ['token1','token2','token3'];

$notification = [
    'title' => $sender,
    'body' => $message,
    'icon' =>'myIcon', 
    'sound' => 'mySound'
];

$extraNotificationData = ["message" => $notification,"moredata" =>'dd'];

$fcmNotification = [
    // 'registration_ids' => $tokenList, //multple token array
    'to'            => $token, //single token
    'notification'  => $notification,
    'data'          => $extraNotificationData
];

$headers = [
    'Authorization: key=' . API_ACCESS_KEY,
    'Content-Type: application/json'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$fcmUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
$result = curl_exec($ch);
curl_close($ch);

// echo $result;

echo json_encode(
    [
        'status'=>'success',
        'token'=> $data['token']
    ]
);
