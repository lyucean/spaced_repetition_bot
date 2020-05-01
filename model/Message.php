<?php


namespace srbot\Model;


use Telegram;

class Message
{
    private $telegram;

    public function __construct()
    {
        $this->telegram = new Telegram(
            TELEGRAM_TOKEN, true, [
                              'type' => PROXY_TYPE,
                              'auth' => PROXY_AUTH,
                              'url' => PROXY_IP,
                              'port' => PROXY_PORT,
                          ]
        );

        return $this;
    }

    public function Send($chat_id, $text)
    {
        $content = array('chat_id' => $chat_id, 'text' => $text);
        $this->telegram->sendMessage($content);
    }
}
