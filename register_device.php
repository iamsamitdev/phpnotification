<?php
require 'connectmssql.php';

$input = file_get_contents('php://input');
$data_input = json_decode($input);

$current_date = date('Y-m-d');

$data = array(
    ':uid'  => 'no_uid',
    ':username'  =>  $data_input->username,
    ':token'  =>  $data_input->token,
    ':created_at' =>  $current_date
);

$result = $connect->prepare("INSERT INTO firebasenoti (uid,username,token,created_at) 
                             VALUES ( :uid, :username, :token, :created_at)");
if ($result->execute($data))
{
    echo json_encode(
        [
            'status'=>'success'
        ]
    );
}
else
{
    echo json_encode(
        [
            'status'=>'fail'
        ]
    );
}