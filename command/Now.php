<?php


namespace srbot\command;

use srbot\core\Telegram;
use srbot\model\Schedule;

class Now
{
    private Telegram $telegram;
    private int $chat_id;

    public function __construct($telegram)
    {
        $this->telegram = $telegram;
        $this->chat_id = $this->telegram->ChatID();
    }

    public function index()
    {
        (new  Schedule())->sendContent($this->chat_id);
    }
}
