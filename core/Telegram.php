<?php


namespace srbot\core;


class Telegram extends \Telegram
{
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
