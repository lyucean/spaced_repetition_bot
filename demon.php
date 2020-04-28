<?php

include(__DIR__ . '/vendor/autoload.php');
include 'config.php';
include 'data.php';

$hour = date("G");
$minute = date("i");

// отправим клиентам sms о том что завтра будет доставка заказа
if ($hour == '9' && $minute == '12') {
    $telegram = new Telegram(
        TELEGRAM_TOKEN, true, [
                          'type' => 'CURLPROXY_HTTPS',
                          'auth' => 'proxyuser:necniskEgowerbot',
                          'url' => '212.237.60.232',
                          'port' => '3128',
                      ]
    );

    $data = new Data();

    $content = array('chat_id' => $data->getChatId(), 'text' => $data->getContent());
    $telegram->sendMessage($content);
}
