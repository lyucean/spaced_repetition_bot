<?php


namespace srbot\command;

use srbot\model\Schedule;

class Now
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
        (new  Schedule())->sendContent($this->chat_id);
    }
}
