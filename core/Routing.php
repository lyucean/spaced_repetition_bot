<?php


namespace srbot\core;


class Routing
{
    public function index($text)
    {
        // If it's a callback, we'll redirect it to the last command.
        /*        if ($this->telegram->getUpdateType() == 'callback_query') {
                    // Get the last command called

                    return;
                }*/

        // If it's an independent command.
        if (mb_substr($text, 0, 1, 'UTF-8') == '/') {
            return;
        }
    }
}
