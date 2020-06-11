<?php


namespace srbot\core;


class Telegram extends \Telegram
{
    private int $set_chat_id = 0;

    public function setChatID($chat_id)
    {
        $this->set_chat_id = (int)$chat_id;
    }

    public function ChatID()
    {
        return 0 < $this->set_chat_id ? $this->set_chat_id : parent::ChatID();
    }

    public function __construct()
    {
        parent::__construct(
            TELEGRAM_TOKEN,
            true,
            [
                'type' => PROXY_TYPE,
                'auth' => PROXY_AUTH,
                'url' => PROXY_IP,
                'port' => PROXY_PORT,
            ]
        );
    }
}
