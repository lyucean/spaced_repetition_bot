<?php

namespace srbot\command;

use srbot\core\Telegram;

class Start
{
    private Telegram $telegram;
    private int $chat_id = 0;

    public function __construct($telegram)
    {
        $this->telegram = $telegram;
        $this->chat_id = $this->telegram->ChatID();
    }

    public function index()
    {
        $reply = "Hey, the bot is in development, it's too early to use it :) " .
            "\n I will write to you how it will be ready.";
        $this->telegram->sendMessage(
            [
                'chat_id' => $this->chat_id,
                'text' => $reply
            ]
        );
    }
}
