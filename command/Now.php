<?php


namespace srbot\command;

use srbot\core\Telegram;

class Now
{
    private Telegram $telegram;

    public function __construct($telegram)
    {
        $this->telegram = $telegram;
    }

    public function index()
    {
        // Just a redirect to Content class
        (new  Content($this->telegram))->sendContent();
    }
}
