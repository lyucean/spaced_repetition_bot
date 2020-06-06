<?php


namespace srbot\command;

use Exception;
use srbot\core\Telegram;

class Error
{
    private Telegram $telegram;
    private $chat_id;

    public function __construct($telegram)
    {
        $this->telegram = $telegram;
        $this->chat_id = $this->telegram->ChatID();
    }

    public function send($message)
    {
        $this->telegram->sendMessage(
            [
                'chat_id' => $this->chat_id,
                'text' => 'Error: ' . $message
            ]
        );

        throw new Exception($message);
    }
}
