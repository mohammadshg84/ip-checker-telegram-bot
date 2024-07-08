<?php

const API_KEY = 'TOKEN';

function bot($method, $datas = [])
{
    $url = 'https://api.telegram.org/bot'.API_KEY.'/'.$method;
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

switch ($text) {
    case '/start':
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'text' => 'سلام، برای دریافت اطلاعات آی‌پی، اون رو برای بات بفرست.',
            'parse_mode' => 'html'
        ]);
        break;
    default:
        if (filter_var($text, FILTER_VALIDATE_IP)) {
            $res = file_get_contents("https://ip.wiki/$text/json");
            bot('sendMessage', [
                'chat_id' => $chat_id,
                'text' => $res,
                'parse_mode' => 'html',
                'reply_to_message_id' => $message_id
            ]);
        } else {
            bot('sendMessage', [
                'chat_id' => $chat_id,
                'text' => 'لطفن یه آدرس آی‌پی معتبر بفرست.',
                'parse_mode' => 'html',
                'reply_to_message_id' => $message_id
            ]);
        }
        break;
}