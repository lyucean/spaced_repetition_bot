<?php


namespace srbot\core;

class Model
{
    public Telegram $telegram;
    public DB $db;

    public function __construct()
    {
        $this->telegram = new Telegram();
        $this->db = new DB();
    }
}
