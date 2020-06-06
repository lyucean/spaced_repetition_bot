<?php

namespace srbot\core;

class Command
{
    public $db;

    public function __construct()
    {
        $this->db = new DB();
    }
}
