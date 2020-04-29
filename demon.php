<?php

include(__DIR__ . '/vendor/autoload.php');
include 'config.php';
include 'data.php';

$hour = date("G");
$minute = date("i");

if (7 < $hour && $hour < 21 && $minute == $hour) {
    $telegram = new Telegram(
        TELEGRAM_TOKEN, true, [
                          'type' => PROXY_TYPE,
                          'auth' => PROXY_AUTH,
                          'url' => PROXY_IP,
                          'port' => PROXY_PORT,
                      ]
    );

    $data = new Data();

    $content = array('chat_id' => TELEGRAM_CHAT_ID, 'text' => $data->getContentPrepared(TELEGRAM_CHAT_ID));
    $telegram->sendMessage($content);
}
