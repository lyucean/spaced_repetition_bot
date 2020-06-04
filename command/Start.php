<?php

namespace srbot\command;

class Start
{
    private $telegram;
    private $chat_id;

    public function __construct($telegram)
    {
        $this->telegram = $telegram;
        $this->chat_id = $this->telegram->ChatID();
    }

    public function index()
    {
        $reply = "Hey, the bot is in development, it's too early to use it :) " .
            "\n I will write to you how it will be ready.";
        $content = ['chat_id' => $this->chat_id, 'text' => $reply];
        $this->telegram->sendMessage($content);
    }
}
