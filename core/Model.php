<?php


namespace srbot\core;

class Model
{
    public $telegram;
    public $db;

    public function __construct()
    {
        $this->telegram = new Telegram();
        $this->db = new DB();
    }
}
