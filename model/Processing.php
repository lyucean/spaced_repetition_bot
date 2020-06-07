<?php


namespace srbot\model;

use srbot\command\Content;
use srbot\command\Error;
use srbot\core\Action;
use srbot\core\Model;

/**
 * Responsible for the processing of all incoming messages from the user
 * Class Processing
 * @package srbot\Action
 */
class Processing extends Model
{
    const MESSAGE_LIMIT_PER_REQUEST = 10;

    public function check()
    {
        // Get all the new updates and set the new correct update_id before each call
        $updates = $this->telegram->getUpdates(0, self::MESSAGE_LIMIT_PER_REQUEST);
        if (empty($updates['result'])) {
            return;
        }
        for ($i = 0; $i < (int)$this->telegram->UpdateCount(); $i++) {
            // You NEED to call serveUpdate before accessing the values of message in Telegram Class
            $this->telegram->serveUpdate($i);


            if (!in_array($this->telegram->getUpdateType(), ['message', 'callback_query', 'inline_query'])) {
                (new Error($this->telegram))->send('I don\'t know how to work with this type of message!');
            }

            $text = $this->telegram->Text();
            $chat_id = $this->telegram->ChatID();

            // Tracking activity
            $this->db->addChatHistory(
                [
                    'chat_id' => $this->telegram->ChatID(),
                    'first_name' => $this->telegram->FirstName(),
                    'last_name' => $this->telegram->LastName(),
                    'user_name' => $this->telegram->Username(),
                    'user_id' => $chat_id,
                    'text' => $text
                ]
            );

            // If it's an independent command, it has the highest priority.
            if (mb_substr($text, 0, 1, 'UTF-8') == '/') {
                $action = new Action($text);
                $action->execute($this->telegram);
                continue;
            }

            // If this message, then check if the controller is waiting
            $waiting = $this->db->getLastRoute($chat_id);
            if (!empty($waiting['controller'])) {
                continue;
            }

            //All that remains is sent to the controller by default
            (new Content($this->telegram))->add();
            continue;
        }
    }

}
