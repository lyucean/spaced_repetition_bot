<?php
//include (__DIR__ . '/vendor/autoload.php');
include 'Telegram.php';

$telegram = new Telegram('1245144600:AAGlodrrBasrqj8cLe7v0Kjd3TrHqHzN4a4', true, [
    'type'=>'CURLPROXY_HTTPS',
    'auth'=>'proxyuser:necniskEgowerbot',
    'url'=>'212.237.60.232',
    'port'=>'3128',
]);


$content = array('chat_id' => 138984892, 'text' => 'Ты молодец, хуярь дальше!');
$telegram->sendMessage($content);

//$req = $telegram->getUpdates();
//
//for ($i = 0; $i < $telegram-> UpdateCount(); $i++) {
//    // You NEED to call serveUpdate before accessing the values of message in Telegram Class
//    $telegram->serveUpdate($i);
//    $text = $telegram->Text();
//    $chat_id = $telegram->ChatID(); // my 138984892
//
//
//    if ($text == '/start') {
//        $reply = 'Работает!';
//        $content = array('chat_id' => $chat_id, 'text' => $reply);
//        $telegram->sendMessage($content);
//    }
//
//    $content = array('chat_id' => $chat_id, 'text' => $telegram->ChatID());
//    $telegram->sendMessage($content);
//
//
//    // DO OTHER STUFF
//}
