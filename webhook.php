<?php

include (__DIR__ . '/vendor/autoload.php');
include 'config.php';
include 'Telegram.php';

$req = $telegram->getUpdates();

for ($i = 0; $i < $telegram-> UpdateCount(); $i++) {
    // You NEED to call serveUpdate before accessing the values of message in Telegram Class
    $telegram->serveUpdate($i);
    $text = $telegram->Text();
    $chat_id = $telegram->ChatID(); // my 138984892


    if ($text == '/start') {
        $reply = 'Работает!';
        $content = array('chat_id' => $chat_id, 'text' => $reply);
        $telegram->sendMessage($content);
    }

    $content = array('chat_id' => $chat_id, 'text' => $telegram->ChatID());
    $telegram->sendMessage($content);


    // DO OTHER STUFF
}

