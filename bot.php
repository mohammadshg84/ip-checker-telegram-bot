<?php

define('API_KEY', 'TOKEN');

function bot($method, $datas = [])
{
    $url = 'https://api.telegram.org/bot' . API_KEY . '/' . $method;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($datas));
    $res = curl_exec($ch);
    if (curl_error($ch)) {
        var_dump(curl_error($ch));
    } else {
        return json_decode($res);
    }
}

$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$text = $update->message->text;
$chat_id = $update->message->chat->id;
$message_id = $update->message->message_id;
$from_id = $update->message->from->id;

if ($text == '/start') {
    bot('sendMessage', [
        'chat_id' => $chat_id,
        'text' => 'Hi, Send ip',
        'parse_mode' => 'html',
    ]);
}